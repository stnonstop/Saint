<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Aziz DURMAZ
 * Date: 02.12.2012
 * Time: 00:42
 */

ini_set('display_errors', 1);

//DEFINE APPLICATION PATH
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'application');

//DEFINE APPLICATION ENVIRONMENT
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_PATH') : 'production' ));

//ENSURE INCLUDE PATHS
set_include_path(implode(PATH_SEPARATOR,array(
    realpath(APPLICATION_PATH . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'library'),
    realpath(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'controllers'),
    realpath(APPLICATION_PATH),
    get_include_path()
)));

function saintAutoLoader($className){
    $classFile = str_replace('\\', DIRECTORY_SEPARATOR, ltrim($className, '\\')) . '.php';
    require_once $classFile;
}

spl_autoload_register('saintAutoLoader');

$application = new saint\application();

$application->run();