<?php
namespace Application\Controller;
use Application\Controller\ApplicationController;

/**
 * ERROR CONTROLLER
 *
 * Controller for error
 *  
 * @category Application
 * @package Controller
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
class ErrorController extends ApplicationController {
	
	/**
	 * Action for all errors
	 * 
	 * @param number $error
	 * @return void
	 */
	public function defaultAction($error = 404) {

		switch ($error) {
			case 400:
				$this->view->addObject("error", $this->lang['400']);
			break;
			
			case 401:
				$this->view->addObject("error", $this->lang['401']);
			break;
			
			case 402:
				$this->view->addObject("error", $this->lang['402']);
			break;
			
			case 403:
				$this->view->addObject("error", $this->lang['403']);
			break;
			
			case 408:
				$this->view->addObject("error", $this->lang['408']);
			break;
			
			case 415:
				$this->view->addObject("error", $this->lang['415']);
			break;
			
			case 500:
				$this->view->addObject("error", $this->lang['500']);
			break;
			
			case 502:
				$this->view->addObject("error", $this->lang['502']);
			break;
			
			case 503:
				$this->view->addObject("error", $this->lang['503']);
			break;
				
			case 404:
			default:
				$this->view->addObject("error", $this->lang['404']);
			break;
		}
		$this->view->addObject("title", $error);
		$this->view->render('error');
	}
}