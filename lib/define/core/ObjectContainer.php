<?php
namespace Define\Core;
use Define\Traits\SingletonTrait;
use Define\Core\IDefine;
use Define\Exceptions\FrameworkException;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * OBJECT CONTAINER
 *
 * Object registry class. Registry pattern.
 * All the instances created will be stored in this container and will be called when need.
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
final class ObjectContainer implements IDefine, \ArrayAccess {
	
	// Container should be singleton.
	use SingletonTrait;
	
	private $registry = [];
	
	/**
	 * Check if an object has been already registered or not.
	 * 
	 * @param String $key Name of the object.
	 * @return boolean
	 */
	public function offsetExists($key) {
		return isset($this->registry[$key]);
	}
	
	/**
	 * Get an object
	 * 
	 * @param String $key Name of the object.
	 * @return Object
	 * @throws FrameworkException if object has not been registered.
	 */
	public function offsetGet($key) {
		if(!isset($this->registry[$key])) {
			throw new FrameworkException("Object for key {$key} has not been set.");
		}
		return $this->registry[$key];
	}
	
	/**
	 * Set an object
	 *
	 * @param String $key Name of the object.
	 * @param Object $value Object to be registered.
	 * @return void
	 * @throws FrameworkException If object has been already registered.
	 */
	public function offsetSet($key, $value) {
		if(isset($this->registry[$key])) {
			throw new FrameworkException("Object for key {$key} has already been set.");
		}
		$this->registry[$key] = $value;
	}
	
	/**
	 * Unset an object from the registry
	 * 
	 * @param String $key Name of the object.
	 * @return void
	 */
	public function offsetUnset($key) {
		unset($this->registry[$key]);
	}
	
	/**
	 * Get all the instances of a particular type.
	 * 
	 * @param Object $instanceof
	 * @param Array $object Array of objects.
	 */
	public function allOffsetGet($instanceof) {
		$objects = array();
		foreach ($this->registry as $value) {
			if($value instanceof $instanceof) {
				$objects[] = $value;
			}
		}
		return $objects;
	}
}	