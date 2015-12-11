<?php 
namespace Define\DBDrivers;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

class MONGODBDriver implements IDatabase {
	
	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::getConnection()
	 */
	public function getConnection(DatabaseBean $bean) {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::executeSql()
	 */
	public function executeSql($query, $parameter = array()) {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::beginTransaction()
	 */
	public function beginTransaction() {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::commitTransaction()
	 */
	public function commitTransaction() {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::rollbackTransaction()
	 */
	public function rollbackTransaction() {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::fetchAssoc()
	 */
	public function fetchAssoc() {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::fetchArray()
	 */
	public function fetchArray() {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::fetchObject()
	 */
	public function fetchObject() {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::affectedRows()
	 */
	public function affectedRows() {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::lastID()
	 */
	public function lastID() {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::multipleID()
	 */
	public function multipleID($size) {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Define\DBDrivers\IDatabase::freeResult()
	 */
	public function freeResult() {
		// TODO: Auto-generated method stub

	}

}