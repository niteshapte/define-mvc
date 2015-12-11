<?php
namespace Define\DBDrivers;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * IDATABASE
 *
 * Interface declaring the methods that to be followed for database interaction.
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
interface IDatabase {
	
	/**
	 * Method for connecting to database
	 *
	 * @param none
	 * @return void
	 */
	public function getConnection(DatabaseBean $bean);
	
	/**
	 * Execute a sql query
	 *
	 * @param String $query
	 * @return Object
	 */
	public function executeSql($query, $parameter = array());
	
	/**
	 * Begin the transaction
	 *
	 * @param none
	 * @return void
	 */
	public function beginTransaction();
	
	/**
	 * Commit the transaction
	 *
	 * @param none
	 * @return void
	 */
	public function commitTransaction();
	
	/**
	 * Rolls back the transaction
	 *
	 * @param none
	 * @return void
	 */
	public function rollbackTransaction();
	
	/**
	 * Fetch associative array
	 *
	 * @param none
	 * @return void
	 */
	public function fetchAssoc();
	
	/**
	 * Fetch enumerated array
	 *
	 * @param none
	 * @return void
	 */
	public function fetchArray();
	
	/**
	 * Fetch Object instead of array
	 *
	 * @param none
	 * @return void
	 */
	public function fetchObject();
	
	/**
	 * Fetch the number of affected rows
	 *
	 * @param none
	 * @return int number of rows
	 */
	public function affectedRows();
	
	/**
	 * Fetch the last inserted id
	 *
	 * @param noe
	 * @return int last row id of table
	 */
	public function lastID();
	
	/**
	 * Fetch the ids of last entry
	 *
	 * @param int $size
	 */
	public function multipleID($size);
	
	/**
	 * Frees the database result
	 *
	 * @param none
	 * @return void
	 */
	public function freeResult();
}