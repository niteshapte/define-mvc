<?php
namespace Define\DBDrivers;
use Define\DBDrivers\IDatabase;
use PDO;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * PDO DRIVER
 *
 * PDO class
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
class PDODriver implements IDatabase {

	use SingletonTrait;
	
	private $pdoObject;
	
	private $prepareStatement;
	
	/**
	 * Method for connecting to database
	 *
	 * @param none
	 * @return void
	 */
	public function getConnection(DatabaseBean $bean) {
		$this->pdoObject = new \PDO($bean->getDbType().":host=".$bean->getHost().";dbname=".$bean->getDb().";charset=utf8", $bean->getUser(), $bean->getPass(), array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	
	/**
	 * Execute a sql query
	 *
	 * @param String $query
	 * @return Object
	 */
	public function executeSql($query, $parameter = array()) {
		$this->prepareStatement = $this->pdoObject->prepare($query);
		for($i = 0; $i < sizeof($parameter); $i++) {
			$this->prepareStatement->bindParam(":x".intval($i+1), $parameter[$i]);
		}
		$this->prepareStatement->execute();
		return $this;
	}
	
	/**
	 * Begin the transaction
	 *
	 * @param none
	 * @return void
	 */
	public function beginTransaction() {
		$this->pdoObject->beginTransaction();
		return $this;
	}
	
	/**
	 * Commit the transaction
	 *
	 * @param none
	 * @return void
	 */
	public function commitTransaction() {
		$this->pdoObject->commit();
		return $this;
	}
	
	/**
	 * Rolls back the transaction
	 *
	 * @param none
	 * @return void
	 */
	public function rollbackTransaction() {
		$this->pdoObject->rollBack();
		return $this;
	}
	
	/**
	 * Fetch associative array
	 *
	 * @param none
	 * @return void
	 */
	public function fetchAssoc() {
		$result = $this->prepareStatement->fetchAll(PDO::FETCH_ASSOC);
		$this->freeResult();
		return $result;
	}
	
	/**
	 * Fetch enumerated array
	 *
	 * @param none
	 * @return void
	 */
	public function fetchArray() {
		$result = $this->prepareStatement->fetchAll(PDO::FETCH_BOTH);
		$this->freeResult();
		return $result;
	}
	
	/**
	 * Fetch Object instead of array
	 *
	 * @param none
	 * @return void
	 */
	public function fetchObject() {
		$result = $this->prepareStatement->fetchAll(PDO::FETCH_OBJ);
		$this->freeResult();
		return $result;
	}
	
	/**
	 * Fetch the number of affected rows
	 *
	 * @param none
	 * @return int number of rows
	 */
	public function affectedRows() {
		return $this->prepareStatement->rowCount();
	}
	
	/**
	 * Fetch the last inserted id
	 *
	 * @param noe
	 * @return int last row id of table
	 */
	public function lastID() {
		return intval($this->pdoObject->lastInsertId());
	}
	
	/**
	 * Fetch the ids of last entry
	 *
	 * @param int $size
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
	 * Frees the database result
	 *
	 * @param none
	 * @return void
	 */
	public function freeResult() {
		$this->prepareStatement->closeCursor();
	}
	
	
	public function __destruct() {
		$this->pdoObject = null;
	}
}