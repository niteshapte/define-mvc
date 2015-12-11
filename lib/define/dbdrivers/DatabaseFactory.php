<?php
namespace Define\DBDrivers;
use Define\Core\ObjectContainer;
use Define\Exceptions\FrameworkException;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * DATABASE FACTORY
 *
 * Database factory class for retriving the instance of the database driver class.
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
class DatabaseFactory {
	
	/**
	 * Returns the instance of type IDatabase and also makes connection.
	 * 
	 * @param string $databaseType
	 * @throws FrameworkException
	 * @return Instance of IDatabase
	 */
	public static function create($databaseType = 'MYSQLI') {
		$container = ObjectContainer::getInstance();
		$bean = $container->offsetGet($databaseType);
		$instance = NULL;
		switch ($databaseType) {
			case 'MYSQL':
				$instance = MYSQLDriver::getInstance();
			break;
			
			case 'MYSQLI':
				$instance = MYSQLIDriver::getInstance();
			break;
				
			case 'PDO':
				$instance = PDODriver::getInstance();
			break;
			
			case 'ORACLE':
				$instance = ORACLEDriver::getInstance();
			break;
			
			case 'MSSQL':
				$instance = MSSQLDriver::getInstance();
			break;
			
			case 'PGSQL':
				$instance = POSTGREDriver::getInstance();
			break;
			
			case 'SQLITE':
				$instance = SQLITEDriver::getInstance();
			break;
			
			case 'MARIA':
				
			break;
			
			case 'MONGO':
				
			break;
			
			default:
				throw new FrameworkException("Unsupported database driver {$databaseType}");	
			
		}
		if(!$instance instanceof IDatabase) {
			throw new FrameworkException("Make sure {$databaseType} Driver class is of type IDatabase");
		}
		$instance->getConnection($bean);
		return $instance;
	}
}