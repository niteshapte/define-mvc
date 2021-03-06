<?php
namespace Define\Core;
use Define\Utilities\Session;
use Define\Utilities\Localization;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * BASE CONTROLLER
 *
 * Base controller class. This will have the most commonly used objects 
 * initialized for use in corresponding controller classes.
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
abstract class BaseController implements IDefine {
	
	/**
	 * View object
	 * @var View $view
	 */
	protected $view;
	
	/**
	 * Session object
	 * @var Session $session
	 */
	protected $session;
	
	/**
	 * Localiztion language
	 * @var Localization $lang
	 */
	protected $lang;
	
	/**
	 * Object container instance
	 * @var ObjectContainer $container
	 */
	protected $container = null;
	
	/**
	 * Get the instances of the object that were stored in container. 
	 * 
	 * @param none
	 * @return void
	 */
	public function __construct() {
		$this->view = new View();
		$this->container = ObjectContainer::getInstance();
		$this->session = $this->container->offsetGet('SESSION');
		$this->lang = $this->container->offsetGet('LOCALIZATION');
	}
}