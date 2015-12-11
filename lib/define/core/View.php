<?php
namespace Define\Core;
use Define\Core\IDefine;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * VIEW
 *
 * View class for rendering user interface. This should not be final to keep it extendable.
 * Feel free to extend it and implement your own functionalities.
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
class View implements IView, IDefine {
	
	private $vars = array();
		
	/**
	 * {@inheritDoc}
	 * @see \Define\Core\IView::addObject()
	 */
	public function addObject($objectName, $objectValue) {
		$this->vars[$objectName] = $objectValue;
	}

	/**
	 * {@inheritDoc}
	 * @see \Define\Core\IView::render()
	 */
	public function render($page) {
		sizeof($this->vars) ? extract($this->vars) : NULL;
		include VIEW_PATH.$page.'.php';
	}

	/**
	 * {@inheritDoc}
	 * @see \Define\Core\IView::redirect()
	 */
	public function redirect($page) {
		sizeof($this->vars) ? extract($this->vars) : NULL;
		header('location: '.$page);
		exit;
	}

	/**
	 * {@inheritDoc}
	 * @see \Define\Core\IView::redirectWithTime()
	 */
	public function redirectWithTime($page, $time) {
		sizeof($this->vars) ? extract($this->vars) : NULL;
		header("refresh:{$time}; url={$page}");
		exit;
	}

	/**
	 * {@inheritDoc}
	 * @see \Define\Core\IView::addObjectInSession()
	 */
	public function addObjectInSession($objectName, $objectValue) {
		$container = ObjectContainer::getInstance();
		$session = $container->offsetGet('SESSION');
		$session->setData($objectName, $objectValue);
	}

	/**
	 * {@inheritDoc}
	 * @see \Define\Core\IView::removeObjectInSession()
	 */
	public function removeObjectInSession($objectName) {
		$container = ObjectContainer::getInstance();
		$session = $container->offsetGet('SESSION');
		$session->removeData($objectName);
	}
}