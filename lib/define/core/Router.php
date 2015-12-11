<?php
namespace Define\Core;
use Define\Core\IDefine;
use Define\Traits\SingletonTrait;
use Define\Exceptions\FrameworkException;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * ROUTER
 *
 * Framework Router
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
final class Router implements IRouter, IDefine {
	
	use SingletonTrait; // Yes, it will be singleton
	
	const DEFAULT_CONTROLLER 	= DEFAULT_CONTROLLER;
	const DEFAULT_ACTION     	= DEFAULT_ACTION;
	private $controller    		= self::DEFAULT_CONTROLLER;
	private $action        		= self::DEFAULT_ACTION;
	private $params        		= array();
	
	/**
	 * @see \Define\Core\IRouter::init()
	 */
	public function init(array $options = array()) {
		empty($options) ? $this->doSetup() : $this->get($options);
	}
	
	/**
	 * Set controller, action and parameters
	 * 
	 * @param array $options Parameters
	 * @return void
	 */
	private function get(array $options = array()) {
		isset($options["controller"]) && $options['controller'] != '' ? $this->setController($options["controller"]) : CONTROLLER_NAMESPACE . $this->controller;
		isset($options["action"]) ? $this->setAction($options["action"]) : $this->action;
		isset($options["params"]) ? $this->setParams($options["params"]) : $this->params;
	}
	
	/**
	 * @see Define\Core.IRouter::doSetup()
	 */
	public function doSetup() {
		$path = parse_url(filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL), PHP_URL_PATH);
		
		substr($path, -1) != NEED_SLASH ? $this->setController(ERROR_CONTROLLER) : $path = trim($path, '/');
		
		$path = preg_replace('/[^a-zA-Z0-9]\//', "", $path);
		
		@list($controller, $action, $params) = explode(SEPARATOR, $path, 3);
		
		!empty($controller) ? $this->setController($controller) : $this->setController($this->controller);
		!empty($action) ? $this->setAction($action) : $this->setAction($this->action);
		!empty($params) ? $this->setParams(explode("-", $params)) : $this->setParams($this->params);
	}
	
	/**
	 * @see Define\Core.IRouter::setController()
	 */
	public function setController($controller) {
		//For the name with 2 or more words. For example - /nitesh-apte/someaction/. Controller name will be NiteshApteController
		$controller = \str_replace("-", "", \mb_convert_case(\mb_strtolower($controller), \MB_CASE_TITLE, "UTF-8"));
		$this->controller = CONTROLLER_NAMESPACE . CONTROLLER_PREFIX . $controller . CONTROLLER_SUFFIX;
		$file = CONTROLLER_PATH . CONTROLLER_PREFIX . $controller . CONTROLLER_SUFFIX.'.php';

        if (!\file_exists($file)) {
        	$this->controller = CONTROLLER_NAMESPACE . CONTROLLER_PREFIX . ERROR_CONTROLLER . CONTROLLER_SUFFIX;
        }
        return $this;
	}
	
	/**
	 * @see Define\Core.IRouter::setAction()
	 */
	public function setAction($action) {
		$action = str_replace("-", "", \mb_convert_case(\mb_strtolower($action), \MB_CASE_TITLE, "UTF-8"));
		$reflector = new \ReflectionClass($this->controller);
		$this->action = lcfirst($action . ACTION_SUFFIX);
		if (!$reflector->hasMethod($this->action)) {
			$this->controller = CONTROLLER_NAMESPACE . CONTROLLER_PREFIX . ERROR_CONTROLLER . CONTROLLER_SUFFIX;
			$this->action = self::DEFAULT_ACTION . ACTION_SUFFIX;
		}
		return $this;
	}
	
	/**
	 * @see Define\Core.IRouter::setParams()
	 */
	public function setParams(array $params) {
		$this->params = $params;
		return $this;
	}
	
	/**
	 * @see Define\Core.IRouter::run()
	 */
	public function run() {
		try {
			$controller = new $this->controller();
			if(!$controller instanceof BaseController) {
				throw new FrameworkException("Controller {$this->controller} is not of type Define\Core\BaseController.", 1003);
			}
			\call_user_func_array(array($controller, $this->action), $this->params);
		} catch (FrameworkException $e) {
			echo $e;
		}		
	}
}