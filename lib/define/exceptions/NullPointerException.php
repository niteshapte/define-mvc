<?php
namespace Define\Exceptions;

if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

class NullPointerException extends FrameworkException { }