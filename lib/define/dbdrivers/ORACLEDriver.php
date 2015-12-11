<?php
namespace Define\DBDrivers;
use Define\DBDrivers\IDatabase;
use Define\Traits\SingletonTrait;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * ORACLE DRIVER
 *
 * Oracle Driver class
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
class ORACLEDriver implements IDatabase {
	
	use SingletonTrait;
	
	/**
	 * Open a connection to Oracle server
	 *
	 * @param none
	 * @return Object $this
	 */
	public function getConnection(DatabaseBean $bean) {
		$this->sqlLink = \oci_connect($bean->sqlUser, $bean->sqlPass, $bean->sqlHost.'/XE');
		return $this;
	}
	
	/**
	 * Select a Oracle database.
	 *
	 * @param none
	 * @return Object $this
	 */
	public function selectDB() {
		// Nothing to do
	}
	
	/**
	 * Execute the SQL
	 *
	 * @param String $query
	 * @return Object $this
	 */
	public function executeSql($query, $parameters = '') {
		$this->sqlExec = oci_parse($this->sqlLink, $query);
		oci_execute($this->sqlExec);
		return $this;
	}
	
	/**
	 * Starts a transaction
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function beginTransaction() {
		// Nothing to do
	}
	
	/**
	 * Commit the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function commitTransaction() {
		return oci_commit($this->sqlLink);
	}
	
	/**
	 * Rollback the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function rollbackTransaction() {
		return oci_rollback($this->sqlLink);
	}
	
	/**
	 * Fetch a result row as an associative array
	 *
	 * @param none
	 * @return Object $this
	 */
	public function fetchAssoc() {
		$sqlStoreValues = array();
		while($this->sqlRows = oci_fetch_assoc($this->sqlExec)) {
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
		while($this->sqlRows = oci_fetch_array($this->sqlExec, OCI_BOTH)) {
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
		while($this->sqlRows = oci_fetch_object($this->sqlExec, OCI_BOTH)){
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
		return oci_num_rows($this->sqlExec);
	}
	
	/**
	 * Method to return the id of last affected row
	 *
	 * @param none
	 * @return Int $this->lastID Last id
	 */
	public function lastID($tableName = '', $fieldName = '') {
		$oracleSql = "SELECT $fieldName FROM $tableName ORDER BY $fieldName DESC LIMIT 1";
	
		$this->executeSql($oracleSql);
		return $this->sqlRows[$fieldName];
	}
	
	/**
	 * Method to return id of last multiple insert statements executed
	 *
	 * @param Int $size Count of statements
	 * @return array
	 */
	public function multipleID($size, $tableName = '', $fieldName = '') {
		$lastId = $this->lastID($tableName = '', $fieldName = '');
	
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
		oci_free_statement($this->sqlExec);
	}
	
	/**
	 * Destroy Oracle connection
	 *
	 * @param none
	 * @return void
	 */
	public function __destruct(){
		oci_close($this->sqlLink);
	}
}