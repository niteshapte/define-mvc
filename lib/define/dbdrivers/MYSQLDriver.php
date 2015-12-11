<?php
namespace Define\DBDrivers;
use Define\DBDrivers\IDatabase;
use Define\Traits\SingletonTrait;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * MYSQL DRIVER
 *
 * MySql driver class
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
class MYSQLDriver implements IDatabase {

	use SingletonTrait;

	private $conn = NULL;
	
	private $result = NULL;
	
	private $sqlDB;
	
	
	/**
	 * Open a connection to MySQLi server
	 *
	 * @param none
	 * @return Object $this
	 */
	public function getConnection(DatabaseBean $bean) {
		$this->conn = @mysql_connect($bean->getHost(), $bean->getUser(), $bean->getPass());
		$this->sqlDB = $bean->getDb();
		$this->selectDB();
		return $this;
	}

	/**
	 * Select a mysql database.
	 *
	 * @param none
	 * @return Object $this
	 */
	public function selectDB(){
		@mysql_select_db($this->sqlDB, $this->conn);
	}
	
	/**
	 * Execute the SQL
	 *
	 * @param String $query
	 * @return Object $this
	 */
	public function executeSql($query, $parameter = array()) {
		$this->result = @mysql_query($query, $this->conn);
		return $this;
	}
	
	/**
	 * Starts a transaction
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function beginTransaction(){
		@mysql_query("BEGIN");
		return $this;
	}
	
	/**
	 * Commit the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function commitTransaction(){
		@mysql_query("COMMIT");
		return $this;
	}
	
	/**
	 * Rollback the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function rollbackTransaction(){
		@mysql_query("ROLLBACK");
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
		while($rows = @mysql_fetch_assoc($this->result)){
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
		while($this->sqlArray = @mysql_fetch_array($this->result, @MYSQL_BOTH)){
			$sqlStoreValues[] = $this->sqlArray;
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
	public function fetchObject(){
		$sqlStoreValues = array();
		while($this->sqlRows = @mysql_fetch_object($this->result)){
			$sqlStoreValues[] = $this->sqlRows;
		}
		$this->freeResult();
		return $sqlStoreValues;
	}
	
	/**
	 * Fetch number of affected rows in previous mysql operation
	 *
	 * @param none
	 * @return Object $this
	 */
	public function affectedRows(){
		return @mysql_affected_rows();
	}
	
	/**
	 * Method to return the id of last affected row
	 *
	 * @param none
	 * @return Int $this->lastID Last id
	 */
	public function lastID(){
		return @mysql_insert_id();
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
	 	@@mysql_free_result($this->result);
	 }
	
	 /**
	 * Print the mysql error number
	 *
	 * @param none
	 * @return number
	 */
	 public function sqlErrorNo() {
	 	return @mysql_errno($this->conn);
	 }
	
	 /**
	 * Destroy mysql connection
	 *
	 * @param none
	 * @return void
	 */
	 public function __destruct(){
	 	@mysql_close($this->conn);
	 }
}