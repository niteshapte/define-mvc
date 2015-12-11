<?php
namespace Define\DBDrivers;
use Define\DBDrivers\IDatabase;
use Define\Traits\SingletonTrait;
use Define\Exceptions\FrameworkException;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * MYSQLI DRIVER
 *
 * MySQLi Driver class
 *  
 * @category Define
 * @package DBDrivers
 * @author Nitesh Apte <me@niteshapte.com>
 * @copyright 2015 Nitesh Apte
 * @version 1.0.0
 * @since 1.0.0
 * @license https://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class MYSQLIDriver implements IDatabase {

	use SingletonTrait;
	
	private $conn = null;
	
	private $preparedStatement = null;
	
	private $result = null;
	
	/**
	 * Open a connection to MySQLi server
	 *
	 * @param none
	 * @return Object $this
	 */
	public function getConnection(DatabaseBean $bean) {
		$this->conn = new \mysqli($bean->getHost(), $bean->getUser(), $bean->getPass(), $bean->getDb());
		return $this;
	}

	/**
	 * Select a mysqli database.
	 *
	 * @param none
	 * @return Object $this
	 */
	public function selectDB($databaseName) { }
	
	/**
	 * Execute the SQL
	 *
	 * @param String $query
	 * @return Object $this
	 */
	public function executeSql($query, $parameter = array()) {
		if (!is_string($query) || empty($query)):
			throw new FrameworkException("The specified query is not valid.");
		endif;
		$this->preparedStatement = $this->conn->prepare($query);
		if($this->preparedStatement === false):
			throw new FrameworkException("Prepared Statement is wrong. Error: ".$this->sqlErrorNo(), $this->sqlErrorNo());
		endif;
		if(!empty($parameter)):
			$args = $this->castValues($parameter);
			call_user_func_array(array($this->preparedStatement, 'bind_param'), $this->makeValuesReferenced($args));
		endif;
		$this->preparedStatement->execute();
		return $this;
	}
	
	private function castValues(array $paramter = null) {
		$types = '';
		if (!empty($paramter)) {
			foreach($paramter as $v) {
				switch ($v) {
					case '':
						$types .= 's';
					break;
							
					case is_null($v):
					case is_bool($v):
					case is_int($v):
						$types .= 'i';
					break;
							
					case is_float($v):
						$types .= 'd';
					break;
							
					case is_string($v):
						$types .= 's';
					break;
				}
			}
		}
		return array_merge(array($types), $paramter);
	}
	
	private function makeValuesReferenced(&$arr) {
		$refs = array();
		foreach($arr as $key => $value)
			$refs[$key] = &$arr[$key];
		$value; 
		// @TODO Remove $value
		return $refs;
	}
	
	/**
	 * Starts a transaction
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function beginTransaction() {
		\phpversion() > "5.5.0" ? $this->conn->begin_transaction() : $this->conn->autocommit(false);
		return $this;
	}
	
	/**
	 * Commit the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function commitTransaction(){
		\phpversion() > "5.5.0" ? $this->conn->commit() : $this->conn->autocommit(true);
		return $this;
	}
	
	/**
	 * Rollback the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function rollbackTransaction(){
		$this->conn->rollback();
		return $this;
	}
	
	/**
	 * Fetch a result row as an associative array
	 *
	 * @param none
	 * @return Object $this
	 */
	public function fetchAssoc(){
		$sqlStoreValues = array();
		$this->result = $this->preparedStatement->get_result();
		while($rows = $this->result->fetch_assoc()){
			$sqlStoreValues[] = $rows;
		}
		$this->freeResult();
		return $sqlStoreValues;
	}
	
	/**
	 * Fetch a result row as an associative array and as an enumerated array
	 *
	 * @param none
	 * @return Array $this->sqlStoreValues
	 */
	public function fetchArray(){
		$sqlStoreValues = array();
		$this->result = $this->preparedStatement->get_result();
		while($rows = $this->result->fetch_array(MYSQLI_BOTH)){
			$sqlStoreValues[] = $rows;
		}
		
		$this->freeResult();
		return $sqlStoreValues;
	}
	
	/**
	 * Fetch a result row as an object
	 *
	 * @param none
	 * @return Array $this->sqlStoreValues
	 */
	public function fetchObject($object = null){
		$sqlStoreValues = array();
		$this->result = $this->preparedStatement->get_result();
		while($rows = $this->result->fetch_object($object)){
			$sqlStoreValues[] = $rows;
		}
		$this->freeResult();
		return $sqlStoreValues;
	}
	
	/**
	 * Fetch number of affected rows in previous mysqli operation
	 *
	 * @param none
	 * @return Object $this
	 */
	public function affectedRows(){
		return $this->conn->affected_rows;
	}
	
	public function isUpdated() {
		return mysqli_sqlstate($this->conn) == 00000 ? true : false;
	}
	
	/**
	 * Method to return the id of last affected row
	 *
	 * @param none
	 * @return Int $this->lastID Last id
	 */
	public function lastID(){
		return $this->conn->insert_id;
	}
	
	/**
	 * Method to return id of last multiple insert statements executed
	 *
	 * @param Int $size Count of statements
	 * @return array
	 */
	public function multipleID($size){
		$lastId = $this->lastID();
		$lastIDs = array();
		for($i = $lastId; $i< ($lastId + $size); $i++){
			$lastIDs[] = $i;
		}
		return $lastIDs;
	}
	
	/**
	* Method to free the results from memory
	 *
	 * @param none
	 * @return void
	 */
	 public function freeResult(){
	 	$this->result->close();
	 	$this->preparedStatement->free_result();
	 	$this->preparedStatement->close();
	 	
	 }
	
	 /**
	 * Print the mysqli error number
	 *
	 * @param none
	 * @return number
	 */
	 public function sqlErrorNo() {
	 	return $this->conn->errno;
	 }
	
	 /**
	 * Destroy mysqli connection
	 *
	 * @param none
	 * @return void
	 */
	 public function __destruct(){
	 	return $this->conn->close();
	 }
}