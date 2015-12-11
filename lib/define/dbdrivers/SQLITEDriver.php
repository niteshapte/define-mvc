<?php
namespace Define\DBDrivers;
use Define\DBDrivers\IDatabase;
use Define\Traits\SingletonTrait;
use Define\Exceptions\FrameworkException;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * SQLITE DRIVER
 *
 * Sqlite Driver class
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
class SQLITEDriver implements IDatabase {
	
	use SingletonTrait;
	
	/**
	 * Open a connection to MySQL server
	 *
	 * @param none
	 * @return Object $this
	 */
	public function getConnection(DatabaseBean $bean) {
		$sqliteError = '';
		$this->sqlLink = sqlite_open($bean->sqlDB, 0666, $sqliteError);
		if($sqliteError != '') {
			throw new FrameworkException("Unable to connect to Sqlite database.");
		}
		return $this;
	}
	
	/**
	 * Execute the SQL
	 *
	 * @param String $query
	 * @return Object $this
	 */
	public function executeSql($query) {
		$this->sqlExec = sqlite_query($this->sqlLink, $query);
		return $this;
	}
	
	/**
	 * Starts a transaction
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function beginTransaction() {
		throw new \Exception('Transaction is not supported in Sqlite. Hence, transaction initialization quitted.');
	}
	
	/**
	 * Commit the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function commitTransaction() {
		throw new \Exception('Transaction is not supported in Sqlite. Hence, transaction commit quitted.');
	}
	
	/**
	 * Rollback the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function rollbackTransaction() {
		throw new \Exception('Transaction is not supported in Sqlite. Hence, transaction rollback quitted.');
	}
	
	/**
	 * Fetch a result row as an associative array
	 *
	 * @param none
	 * @return Object $this
	 */
	public function fetchAssoc() {
		$sqlStoreValues = array();
		while($this->sqlRows = sqlite_fetch_array($this->sqlExec, SQLITE_ASSOC)) {
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
		while($this->sqlArray = sqlite_fetch_array($this->sqlExec, SQLITE_BOTH)) {
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
	public function fetchObject() {
		$sqlStoreValues = array();
		while($this->sqlRows = sqlite_fetch_object($this->sqlExec)) {
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
	public function affectedRows() {
		return sqlite_num_rows($this->sqlExec);
	}
	
	/**
	 * Method to return the id of last affected row
	 *
	 * @param none
	 * @return Int $this->lastID Last id
	 */
	public function lastID() {
		return sqlite_last_insert_rowid($this->sqlExec);
	}
	
	/**
	 * Method to return id of last multiple insert statements executed
	 *
	 * @param Int $size Count of statements
	 * @return array
	 */
	public function multipleID($size) {
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
		unset($this->sqlExec);
	}
	
	/**
	 * Destroy MySQL connection
	 *
	 * @param none
	 * @return void
	 */
	public function __destruct() {
		sqlite_close($this->sqlLink);
	}
}