<?php
use Define\Core\ObjectContainer;
use Define\Core\Framework;
use Define\Utilities\Session;
use Define\DBDrivers\DatabaseBean;
use Define\Utilities\Logger;
use Define\Core\Router;

ob_start();
session_start();
session_regenerate_id();
define("DIRECT_ACCESS", TRUE);

# set the include path #
# Core classes of framework - Start #
###########################################################################################################################
set_include_path(get_include_path().PATH_SEPARATOR."lib/define/core");
set_include_path(get_include_path().PATH_SEPARATOR."lib/define/dbdrivers");
set_include_path(get_include_path().PATH_SEPARATOR."lib/define/helpers");
set_include_path(get_include_path().PATH_SEPARATOR."lib/define/utilities");
set_include_path(get_include_path().PATH_SEPARATOR."lib/define/traits");
set_include_path(get_include_path().PATH_SEPARATOR."lib/define/exceptions");
set_include_path(get_include_path().PATH_SEPARATOR."lib/vendors/phpmailer");
set_include_path(get_include_path().PATH_SEPARATOR."lib/vendors/tmdb");
###########################################################################################################################
# Core classes of framework - End   #

# Classes for your application - Start  #
###########################################################################################################################
set_include_path(get_include_path().PATH_SEPARATOR."application/controller");	// Controllers for your application goes here
set_include_path(get_include_path().PATH_SEPARATOR."application/model/service");		// Service for your application goes here
set_include_path(get_include_path().PATH_SEPARATOR."application/model/service/impl");	// Service implementation
set_include_path(get_include_path().PATH_SEPARATOR."application/model/dao");
set_include_path(get_include_path().PATH_SEPARATOR."application/model/dao/impl");
set_include_path(get_include_path().PATH_SEPARATOR."application/bean");
###########################################################################################################################
# Classes for your application - End    #

# Settings for framework - Start #
###########################################################################################################################
include_once 'configuration/define.inc';
###########################################################################################################################
# Settings for framework - End #

# Settings for Application - Start #
###########################################################################################################################
include_once 'configuration/application.inc';
###########################################################################################################################
# Settings for Application - End #

/**
 * Autoload method for dynamically loading classes.
 *
 * @param object $object Name of Class
 * @return void
 */
function __autoload($object) {
	$split = explode("\\", $object);
	$className = end($split);
	require_once("{$className}.php");
}

$container = ObjectContainer::getInstance();
$container->offsetSet('FRAMEWORK', Framework::getInstance()); 	// Create the instance of framework and let your handlers initialized.
$container->offsetSet('SESSION', Session::getInstance());
$container->offsetSet('MYSQLI', new DatabaseBean("MYSQLI", "localhost", "root", "nitesha", "phpmyadmin", 3306));
//$container->offsetSet('ORACLE', new DatabaseBean("ORACLE", "localhost", "root", "nitesha", "thebookmarker", "3306"));
$container->offsetSet('LOGGER', Logger::getInstance());

//$container->offsetSet('MYSQLI-2', new DatabaseBean("MYSQLI", "localhost", "root", "nitesha", "musicplus", "3306")); // another mysql database
//$container->offsetSet('PDO', new DatabaseBean("mysql", "localhost", "root", "nitesha", "musicplus", "3306"));

# Do this when site is in maintenance or offline - Start #
###########################################################################################################################

/* $default = array(
 'controller' => 'Error',
 'action'	 => 'default',
 'params'	=> array('408')
 ); */

###########################################################################################################################
# Do this when site is in maintenance or offline - End #

$default = array();
$container->offsetGet('FRAMEWORK')->init(Router::getInstance(), $default);
?>