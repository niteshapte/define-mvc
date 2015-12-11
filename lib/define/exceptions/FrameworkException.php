<?php
namespace Define\Exceptions;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * FRAMEWORK EXCEPTION
 *
 * Custom Exception class for the framework
 *  
 * @category Define
 * @package Exceptions
 * @author Nitesh Apte <me@niteshapte.com>
 * @copyright 2015 Nitesh Apte
 * @since 1.0.0
 * @version 1.0.2
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
class FrameworkException extends \Exception implements IException { 
	
	/**
	 * Override the constructor
	 * 
	 * @param string $message
	 * @param number $code
	 */
	public function __construct($message = null, $code = 0)	{
		$this->code = $code;
		if (!$message) {
			throw new $this('Unknown '. get_class($this));
		}
		parent::__construct($message, $code);
	}
	
	/**
	 * {@inheritDoc}
	 * @see Exception::__toString()
	 */
	public function __toString() {
		return $this->formatMessage(get_class($this), $this->message, $this->file, $this->line, $this->getTraceAsString(), $this->code);
	}
	
	/**
	 * Customize the message
	 * 
	 * @param string $class
	 * @param string $msg
	 * @param string $file
	 * @param string $line
	 * @param string $trace
	 * @param int $code
	 * @return string
	 */
	private function formatMessage($class, $msg, $file, $line, $trace, $code) {
		$css = <<<EOT
		<style>
		.errormessage {
			margin:0px;padding:0px;
			width:100%;
		}
		.errormessage table{
		    border-collapse: collapse;
		    border-spacing: 0;
			width:100%;
			margin:0px;padding:0px;
		}
		.errormessage tr:last-child td:last-child {
			-moz-border-radius-bottomright:0px;
			-webkit-border-bottom-right-radius:0px;
			border-bottom-right-radius:0px;
		}
		.errormessage table tr:first-child td:first-child {
			-moz-border-radius-topleft:0px;
			-webkit-border-top-left-radius:0px;
			border-top-left-radius:0px;
		}
		.errormessage table tr:first-child td:last-child {
			-moz-border-radius-topright:0px;
			-webkit-border-top-right-radius:0px;
			border-top-right-radius:0px;
		}
		.errormessage tr:last-child td:first-child{
			-moz-border-radius-bottomleft:0px;
			-webkit-border-bottom-left-radius:0px;
			border-bottom-left-radius:0px;
		}
		.errormessage tr:hover td{
	
		}
		.errormessage tr:nth-child(odd){
			background-color:#e5e5e5;
		}
		.errormessage tr:nth-child(even) {
			background-color:#ffffff;
		}.errormessage td {
			vertical-align:middle;
			border:1px solid #000000;
			border-width:0px 1px 1px 0px;
			text-align:left;
			padding:5px;
			font-size:12px;
			font-family:Arial;
			font-weight:normal;
			color:#000000;
		}.errormessage tr:last-child td{
			border-width:0px 1px 0px 0px;
		}.errormessage tr td:last-child{
			border-width:0px 0px 1px 0px;
		}.errormessage tr:last-child td:last-child{
			border-width:0px 0px 0px 0px;
		}
		.errorhead {
			font: 20px Arial;
			margin: 5px 0 10px 0;
			font-weight: bold;
		}
		</style>
EOT;
		$message = "<title>Website Generic Exception - {$msg}</title><div class='errorhead'>Website Generic Exception</div><div class='errormessage'><table border=1>";
		$message .= "<tr><td><b>ERROR NO : </b></td><td><font color='red'>{$code}</font></td></tr>";
		$message .= "<tr><td><b>CLASS NAME : </b></td><td><i><b><font color='red'>{$class}</font></b></i></td></tr>";
		$message .= "<tr><td><b>TEXT : </b></td><td><font color='red'>{$msg}</font></td></tr>";
		$message .= "<tr><td><b>LOCATION : </b></td><td><font color='red'>{$file}</font>, <b>line</b> {$line}, at ".date("F j, Y, g:i a")."</td></tr>";
		$message .= "<tr><td width='120px'><b>Showing Backtrace : </b></td><td>{$trace} </td></tr></table></div>";
		$webMessage = str_replace("#", "<br />", $message);
		return $css.$webMessage;
	}
}