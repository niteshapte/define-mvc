<?php
namespace Define\DBDrivers;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * DATABASE BEAN
 *
 * Contains the database connection information
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
class DatabaseBean {
	
	/**
	 * Database type
	 * @var string
	 */
	private $dbType;
	
	/**
	 * Database hostname
	 * @var string
	 */
	private $host;
	
	/**
	 * Username
	 * @var string
	 */
	private $user;
	
	/**
	 * Password
	 * @var string
	 */
	private $pass;
	
	/**
	 * Database name
	 * @var string
	 */
	private $db;
	
	/**
	 * Port number
	 * @var int
	 */
	private $port;
	
	/**
	 * Set the database configuration values
	 * 
	 * @param string $dbType Type of database. mysql or oracle, etc.
	 * @param string $host Host name
	 * @param string $user Username
	 * @param string $pass Password
	 * @param string $db Database/schema
	 * @param int $port Port number
	 */
	public function __construct($dbType = "", $host = "", $user = "", $pass = "", $db = "", $port = '') {
		$this->dbType 	= $dbType;
		$this->host 	= $host;
		$this->user 	= $user;
		$this->pass 	= $pass;
		$this->db 		= $db;
		$this->port 	= $port;
	}

	/**
	 * Get the database type
	 * 
	 * @param none
	 * @return string
	 */
	public function getDbType() {
		return $this->dbType;
	}
	
	/**
	 * Set the database type
	 * 
	 * @param string $dbType
	 * @return void
	 */
	public function setDbType($dbType) {
		$this->dbType = $dbType;
	}
	
	/**
	 * Get the hostname
	 * 
	 * @param none
	 * @return string
	 */
	public function getHost() {
		return $this->host;
	}
	
	/**
	 * Set the hostname
	 * 
	 * @param string $host
	 * @return void
	 */
	public function setHost($host) {
		$this->host = $host;
	}
	
	/**
	 * Get the username
	 * 
	 * @param none
	 * @return string
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * Set the username
	 * 
	 * @param string $user
	 * @return void
	 */
	public function setUser($user) {
		$this->user = $user;
	}
	
	/**
	 * Get the username
	 *
	 * @param none
	 * @return string
	 */
	public function getPass() {
		return $this->pass;
	}
	
	/**
	 * Set the password
	 *
	 * @param string $pass
	 * @return void
	 */
	public function setPass($pass) {
		$this->pass = $pass;
	}
	
	/**
	 * Get the database name / schema name
	 *
	 * @param none
	 * @return string
	 */
	public function getDb() {
		return $this->db;
	}
	
	/**
	 * Set the database name
	 *
	 * @param string $db
	 * @return void
	 */
	public function setDb($db) {
		$this->db = $db;
	}
	
	/**
	 * Get the port number
	 *
	 * @param none
	 * @return int
	 */
	public function getPort() {
		return $this->port;
	}
	
	/**
	 * Set the port number
	 * 
	 * @param int $port
	 * @return void
	 */
	public function setPort($port) {
		$this->port = $port;
	}
}