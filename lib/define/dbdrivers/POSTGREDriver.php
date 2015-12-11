<?php
namespace Define\DBDrivers;
use Define\DBDrivers\IDatabase;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * POSTGRE DRIVER
 *
 * Postgre Driver class
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
class POSTGREDriver implements IDatabase {
	
	use SingletonTrait;
	
	/**
	 * Open a connection to Postgre server
	 *
	 * @param none
	 * @return Object $this
	 */
	public function getConnection(DatabaseBean $bean) {
		$this->sqlLink = pg_connect('host = '.$bean->sqlHost.' port=5432 dbname = '.$bean->sqlDB.' user = '.$bean->sqlUser.' password = '.$bean->sqlPass);
		return $this;
	}
	
	/**
	 * Select a Oracle database.
	 *
	 * @param none
	 * @return Object $this
	 */
	public function selectDB() {
		// Nothing to do here
	}
	
	/**
	 * Execute the SQL
	 *
	 * @param String $query
	 * @return Object $this
	 */
	public function executeSql($query) {
		$this->sqlExec = pg_execute($this->sqlLink, $query);
		return $this;
	}
	
	/**
	 * Starts a transaction
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function beginTransaction() {
		pg_execute($this->sqlLink, "BEGIN");
		return $this;
	}
	
	/**
	 * Commit the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function commitTransaction() {
		pg_execute($this->sqlLink, "COMMIT");
		return $this;
	}
	
	/**
	 * Rollback the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function rollbackTransaction() {
		pg_execute($this->sqlLink, "ROLLBACK");
		return $this;
	}
	
	/**
	 * Fetch a result row as an associative array
	 *
	 * @param none
	 * @return Object $this
	 */
	public function fetchAssoc() {
		$sqlStoreValues = array();
		while($this->sqlRows = pg_fetch_assoc($this->sqlExec)) {
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
	public function fetchArray() {
		$sqlStoreValues = array();
		while($this->sqlRows = pg_fetch_array($this->sqlExec, OCI_BOTH)) {
			$sqlStoreValues[] = $this->sqlRows;
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
	public function fetchObject() {
		$sqlStoreValues = array();
		while($this->sqlRows = pg_fetch_object($this->sqlExec, OCI_BOTH)) {
			$sqlStoreValues[] = $this->sqlRows;
		}
		$this->freeResult();
		return $sqlStoreValues;
	}
	
	/**
	 * Fetch number of affected rows in previous Oracle operation
	 *
	 * @param none
	 * @return Object $this
	 */
	public function affectedRows() {
		return pg_affected_rows();
	}
	
	/**
	 * Method to return the id of last affected row
	 *
	 * @param none
	 * @return Int $this->lastID Last id
	 */
	public function lastID($tableName = '', $fieldName = '') {
		$pgSql = "SELECT $fieldName FROM $tableName ORDER BY $fieldName DESC LIMIT 1";
	
		$this->executeSql($pgSql);
		return $this->sqlRows[$fieldName];
	}
	
	/**
	 * Method to return id of last multiple insert statements executed
	 *
	 * @param Int $size Count of statements
	 * @return array
	 */
	public function multipleID($size, $tableName = '', $fieldName = '') {
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
	public function freeResult() {
		pg_free_result($this->sqlExec);
	}
	
	/**
	 * Destroy Oracle connection
	 *
	 * @param none
	 * @return void
	 */
	public function __destruct() {
		pg_close($this->sqlLink);
	}
}