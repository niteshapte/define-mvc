<?php
namespace Define\Core;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * IVIEW
 *
 * View interface for View implementation.
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
interface IView {
	
	/**
	 * Add objects for display in UI or to carry forward.
	 * 
	 * @param string $objectName
	 * @param mixed $objectValue
	 * @return void
	 */
	public function addObject($objectName, $objectValue);
	
	/**
	 * Renders an UI page
	 * 
	 * @param string $page Name of the UI page
	 * @return void
	 */
	public function render($page);
	
	/**
	 * Redirects to an UI page
	 * 
	 * @param string $page Name of the UI page
	 * @return void
	 */
	public function redirect($page);
	
	/**
	 * Redirects to a page after a certain time period
	 * 
	 * @param string $page Name of the UI page
	 * @param int $time Time period
	 */
	public function redirectWithTime($page, $time);
	
	/**
	 * Add object to session to retrieve on UI
	 * 
	 * @param string $objectName
	 * @param mixed $objectValue
	 * @return void
	 */
	public function addObjectInSession($objectName, $objectValue);
	
	/**
	 * Removes an object for UI added to session
	 * 
	 * @param string $objectName
	 * @return boolean
	 */
	public function removeObjectInSession($objectName);
	
}