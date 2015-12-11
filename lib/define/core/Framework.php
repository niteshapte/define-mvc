<?php
namespace Define\Core;
use Define\Traits\SingletonTrait;
use Define\Utilities\ErrorExceptionHandler;
use Define\Utilities\Localization;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * FRAMEWORK
 *
 * Starting point of application. Initializes the application.
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
final class Framework implements IDefine {
	
	// Singleton class
	use SingletonTrait;
	
	/**
	 * Initialize the necessary stuffs for running the application
	 * 
	 * @param none
	 * @return void
	 */
	private function __construct() {
		ErrorExceptionHandler::getInstance();
		$this->removeMagicQuotes();
		$this->unRegisterGlobals();
		$this->loadLocalization();
	}
	
	/**
	 * Initialize working of Router
	 * 
	 * @param Router $router
	 * @param array $option
	 * @return void
	 */
	public function init(Router $router, array $option = array()) {
		$router->init($option);
		$router->run();
	}
	
	private function removeMagicQuotes() {
		if(\get_magic_quotes_gpc()) {
			$_GET = $this->stripSlashesDeep($_GET);
			$_POST = $this->stripSlashesDeep($_POST);
			$_COOKIE = $this->stripSlashesDeep($_COOKIE);
		}
	}
	
	private function unRegisterGlobals() {
		if (\ini_get('register_globals')) {
			$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
			foreach ($array as $value) {
				foreach ($GLOBALS[$value] as $key => $var) {
					if ($var === $GLOBALS[$key]) {
						unset($GLOBALS[$key]);
					}
				}
			}
		}
	}
	
	private function stripSlashesDeep($value) {
		$value = is_array($value) ? array_map(array($this,'strip_slashes_deep'), $value) : stripslashes($value);
		return $value;
	}
	
	private function loadLocalization() {
	//	$temp = \explode('-', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$locObj = Localization::getInstance();
		//	$language = include $locObj->loadLanguage(trim(strtolower($temp[0])));
		$language = include $locObj->loadLanguage(\trim(\strtolower('en')));
		ObjectContainer::getInstance()->offsetSet('LOCALIZATION', $language);
	}
}