<?php
namespace Define\Utilities;
use Define\Traits\SingletonTrait;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * SESSION
 *
 * Manages interactions with $ _SESSION variable
 *  
 * @category Define
 * @package Utilities
 * @author David Unay Santisteban <slavepens@gmail.com>, Nitesh Apte <me@niteshapte.com>
 * @copyright 2015
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
final class Session implements IUtilities {
	
	use SingletonTrait;
	
	private $sessionStarted = FALSE;
	
	/**
	 * Start the session
	 * 
	 * @param none
	 * @return void
	 */
	public function sessionStart() {
		// if no session exist, start the session
		if (session_id() == '') {
			session_start();
		}
	}
	
	/**
	 * Gets the values â€‹â€‹stored in a session variable.
	 * 
	 * @param string $index
	 * @return mixed
	 */
	public function getData($index = null) {
		$session = array();
		foreach($_SESSION as $key => $value) {
			if(isset($value)) {
				$session[$key] = $value;
			}
		}
		if($index){
			return $session[$index];
		}
		return $session;
	}
	
	/**
	 * Check if a value has been saved in session
	 * 
	 * @param string $index
	 * @return boolean
	 */
	public function hasData($index) {
		return !empty($_SESSION[$index]) ? true : false;
	}
	 
	/**
	 * Set a session variable.
	 * 
	 * @param string $index
	 * @param mixed $value
	 * @return boolean
	 */
	public function setData($index, $value) {
		if(!isset($index) && !isset($value)) {
			return FALSE;
		}
		$_SESSION[$index] = $value;
	}
	 
	/**
	 * Returns the session ID.
	 * 
	 * @param string $id
	 * @return string
	 */
	public function sessionId($id = null) {
		return session_id($id);
	}
	
	/**
	 * Remove a value from session
	 * 
	 * @param string $index
	 * @return void
	 */
	public function removeData($index) {
		$_SESSION[$index] = null;
	}
	
	/**
	 * Regenerate session
	 * 
	 * @param none
	 * @return void
	 */
	public function regenerate()	{
		session_regenerate_id(TRUE);
		return session_id();
	}
	 
	/**
	 * Returns the session state.
	 * 
	 * @return array
	 */
	public function sessionStatus() {
		return session_status();
	}
	 
	/**
	 * Purge custom session variables.
	 * 
	 * @return boolean
	 */
	public function sessionPurge() {
		return session_unset();
	}
	 
	/**
	 * Destroy the FULL session.
	 * 
	 * @return boolean
	 */
	public function sessionDestroy() {
		return session_destroy();
	}
}