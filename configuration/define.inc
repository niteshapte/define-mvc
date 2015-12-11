<?php 
if(!defined('DIRECT_ACCESS')) {
	die("Direct access is forbidden.");
}

/**
 * Global Default values that to be used throughout the project
 *
 * @package Define MVC
 * @author Nitesh Apte
 * @copyright 2014
 * @version 2.0
 * @license GPL v3
 */

#-- SETTING FOR FRAMEWORK STARTS --#

define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']."/");
define('APP_PATH', BASE_PATH . 'application/');
define('CONTROLLER_PATH', APP_PATH . 'controller/');
define('CONTROLLER_PREFIX', '');
define('CONTROLLER_SUFFIX', 'Controller');
define('CONTROLLER_NAMESPACE', 'Application\\Controller\\');	// This is the namespace of the controller that you will define. If you don't want to define, make it blank('')
define('DEFAULT_CONTROLLER', 'Index');
define('DEFAULT_ACTION', 'default');
define('ERROR_CONTROLLER', 'Error');
define('NEED_SLASH', '/');	// Make it blank if you don't need / at the end of your url.
define('ACTION_SUFFIX', 'Action');
define('MODEL_PATH', APP_PATH . 'model/');
define('VIEW_PATH', APP_PATH . 'view/');
define('SEPARATOR', "/"); // It has to be / because in case we are using multi words for controller or action then we need "-"

#-- SETTING FOR FRAMEWORK ENDS --#

########################################################################################################

#-- SETTINGS FOR ERROR AND EXCEPTION HANDLER STARTS --#

define('MODE', 'DEVELOPMENT');
define('APP_ERROR', E_ALL); // Development mode
define('DEBUGGING', TRUE); // Development mode
define('ADMIN_ERROR_MAIL', 'administrator@example.com');
define('SEND_ERROR_MAIL', FALSE);
define('SEND_ERROR_FROM', 'errors@example.com');
define('ERROR_LOGGING', TRUE);
define('LOG_FILE_PATH', BASE_PATH.'logs/error.log'); // Please provide 777 permission to this folder
define('SITE_GENERIC_ERROR_MSG', '<h1>Something wrong, sorry. Error!</h1>');

#-- SETTINGS FOR ERROR AND EXCEPTION HANDLER ENDS --#

########################################################################################################

#-- SETTINGS FOR CACHE --#
define('CACHE', FALSE);
#-- SETTINGS FOR CACHE --#

########################################################################################################

#-- SETTING FOR LOGGER STARTS --#

define('INFO_LOG_PATH', "");
define('DEBUG_LOG_PATH', "");
define('ERROR_LOG_PATH', "");
define('TRACE_LOG_PATH', "");

#-- SETTING FOR LOGGER ENDS --#

########################################################################################################

#-- SETTINGS FOR LOCALIZATION STARTS --#

define('DEFAULT_LANGUAGE', 'en');
define('LOCALIZATION_PATH', APP_PATH.'i18n/');

#-- SETTINGS FOR LOCALIZATION ENDS --#
?>