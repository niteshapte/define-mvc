<?php
namespace Define\IUtilities;
use Define\Utilities\IUtilities;

if(!defined('DIRECT_ACCESS')) {
	die('Direct access is forbidden.');
}

if(!defined('PASSWORD_BCRYPT')) {
	define('PASSWORD_BCRYPT', 1);
	define('PASSWORD_DEFAULT', PASSWORD_BCRYPT);
}

/**
 * PASSWORD HELPER
 *
 * Password Helper class that uses a compatibility library with PHP 5.5's simplified password hashing API. (located in the vendor directory)
 * passes data to password compatibility library, this will add compatability up for php 5.5 at which point the built in functions will be used instead.
 *  
 * @category Define
 * @package Utilities
 * @author David Carr - dave@simplemvcframework.com
 * @copyright 2015
 * @version 2.2
 * @since unknown
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
class PasswordHelper implements IUtilities {
	
	/**
	 * Hash the password using the specified algorithm
	 *
	 * @param string $password The password to hash
	 * @param int    $algo     The algorithm to use (Defined by PASSWORD_* constants)
	 * @param array  $options  The options for the algorithm to use
	 *
	 * @return string|false The hashed password, or false on error.
	 */
	public static function make($password, $algo = PASSWORD_BCRYPT, array $options = array()) {
		return password_hash($password, $algo, $options);
	}
	
	/**
	 * Get information about the password hash. Returns an array of the information
	 * that was used to generate the password hash.
	 *
	 * array(
	 *    'algo' => 1,
	 *    'algoName' => 'bcrypt',
	 *    'options' => array(
	 *        'cost' => 10,
	 *    ),
	 * )
	 *
	 * @param string $hash The password hash to extract info from
	 *
	 * @return array The array of information about the hash.
	 */
	public static function getInfos($hash) {
		return password_get_info($hash);
	}
	
	/**
	 * Determine if the password hash needs to be rehashed according to the options provided
	 *
	 * If the answer is true, after validating the password using password_verify, rehash it.
	 *
	 * @param string $hash    The hash to test
	 * @param int    $algo    The algorithm used for new password hashes
	 * @param array  $options The options array passed to password_hash
	 *
	 * @return boolean True if the password needs to be rehashed.
	 */
	public static function needsRehash($hash, $algo = PASSWORD_BCRYPT, array $options = array()) {
		return password_needs_rehash($hash, $algo, $options);
	}
	
	/**
	 * Verify a password against a hash using a timing attack resistant approach
	 *
	 * @param string $password The password to verify
	 * @param string $hash     The hash to verify against
	 *
	 * @return boolean If the password matches the hash
	 */
	public static function verify($password, $hash)	{
		return password_verify($password, $hash);
	}
}