<?php
namespace Define\Utilities;
use Define\Traits\SingletonTrait;
use Define\Exceptions\FrameworkException;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * LOGGER
 *
 * Logger class for info, debug, error, trace
 *  
 * @category Define
 * @package Utilities
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
class Logger implements IUtilities {
	
	use SingletonTrait;
	
	/**
	 * Logs info messages
	 * 
	 * @param string $message
	 * @return void
	 */
	public function info($message) {
		error_log($message, 3, INFO_LOG_PATH);
	}
	
	/**
	 * Logs debug messages
	 *
	 * @param string $message
	 * @return void
	 */
	public function debug($message) {
		error_log($message, 3, DEBUG_LOG_PATH);
	}
	
	/**
	 * Logs error messages
	 * 
	 * @param string $message
	 * @param FrameworkException $fe
	 * @return void
	 */
	public function error($message, FrameworkException $fe) {
		error_log($message. " Error: ".$fe->getMessage(), 3, ERROR_LOG_PATH);
	}
	
	/**
	 * Logs trace messages
	 * 
	 * @param string $message
	 * @param FrameworkException $fe
	 * @return void
	 */
	public function trace($message, FrameworkException $fe) {
		error_log($message." Trace: ".$fe->getTraceAsString(), 3, TRACE_LOG_PATH);
	}
}