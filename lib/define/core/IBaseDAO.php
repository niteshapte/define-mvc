<?php
namespace Define\Core;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * IBASE-DAO
 *
 * DAO itself a separate entity, hence exhibit separate functionality.
 *  
 * @category Define
 * @package Core
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
interface IBaseDAO { 
	
	/**
	 * Returns the instance of a database driver based on the database type. Also, make connection when called.
	 *
	 * @param string $databaseType
	 * @return Instance of IDatabase
	 */
	public function getDatabaseInstance($databaseType);
}