<?php
namespace Define\DBDrivers;
use Define\DBDrivers\IDatabase;
use Define\Traits\SingletonTrait;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * MSSQL DRIVER
 *
 * Microsoft SQL Driver class.
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
class MSSQLDriver implements IDatabase {
	
	use SingletonTrait;
	
	/**
	 * Open a connection to MySQL server
	 *
	 * @param none
	 * @return Object $this
	 */
	public function getConnection(DatabaseBean $bean) {
		$this->sqlLink = mssql_connect($bean->sqlHost, $bean->sqlUser, $bean->sqlPass);
		return $this;
	}
	
	/**
	 * Select a MySQL database.
	 *
	 * @param none
	 * @return Object $this
	 */
	public function selectDB() {
		mssql_select_db($this->sqlDB, $this->sqlLink);
	}
	
	/**
	 * Execute the SQL
	 *
	 * @param String $query
	 * @return Object $this
	 */
	public function executeSql($query, $parameter = array()) {
		$this->sqlExec = mssql_query($query);
		return $this;
	}
	
	/**
	 * Starts a transaction
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function beginTransaction(){
		mssql_query("BEGIN TRAN");
		return $this;
	}
	
	/**
	 * Commit the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function commitTransaction(){
		mssql_query("COMMIT");
		return $this;
	}
	
	/**
	 * Rollback the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function rollbackTransaction(){
		mssql_query("ROLLBACK");
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
		while($this->sqlRows = mssql_fetch_assoc($this->sqlExec)){
			$sqlStoreValues[] = $this->sqlRows;
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
		while($this->sqlArray = mssql_fetch_array($this->sqlExec, MYSQL_BOTH)){
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
		while($this->sqlRows = mssql_fetch_object($this->sqlExec)){
			$sqlStoreValues[] = $this->sqlRows;
		}
		$this->freeResult();
		return $sqlStoreValues;
	}
	
	/**
	 * Fetch number of affected rows in previous MySQL operation
	 *
	 * @param none
	 * @return Object $this
	 */
	public function affectedRows(){
		return mssql_num_rows();
	}
	
	/**
	 * Method to return the id of last affected row
	 *
	 * @param none
	 * @return Int $this->lastID Last id
	 */
	public function lastID($tableName = '', $fieldName = ''){
		$msSql = "SELECT $fieldName FROM $tableName ORDER BY $fieldName DESC LIMIT 1";
	
		$this->executeSql($msSql);
		return $this->sqlRows[$fieldName];
	}
	
	/**
	 * Method to return id of last multiple insert statements executed
	 *
	 * @param Int $size Count of statements
	 * @return array
	 */
	public function multipleID($size, $tableName = '', $fieldName = '') {
		$lastID = $this->lastID($tableName, $fieldName);
		$lastIDs = array();
		for($i = $lastID; $i< ($lastID + $size); $i++){
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
		mssql_free_result($this->sqlExec);
	}
	
	/**
	 * Destroy MySQL connection
	 *
	 * @param none
	 * @return void
	 */
	public function __destruct(){
		mssql_close($this->sqlLink);
	}
}