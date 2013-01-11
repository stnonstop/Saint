<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adurmaz
 * Date: 21.12.2012
 * Time: 14:40
 * To change this template use File | Settings | File Templates.
 */
//mongo Database Configuration
$dbConfig['mongo']['driverType']    = 'mongo';
$dbConfig['mongo']['serverName']    = 'localhost';
$dbConfig['mongo']['serverPort']    = '27017';
$dbConfig['mongo']['dbSchemaName']  = 'elementalGame';
$dbConfig['mongo']['cacheType']     = 'file';

$dbConfig['mongoGGGame']['driverType']    = 'mongo';
$dbConfig['mongoGGGame']['serverName']    = 'localhost';
$dbConfig['mongoGGGame']['serverPort']    = '27017';
$dbConfig['mongoGGGame']['dbSchemaName']  = 'ggGame';
$dbConfig['mongoGGGame']['cacheType']     = 'file';

$dbConfig['oracle']['driverType']   = 'oracle';
$dbConfig['oracle']['serverName']   = 'localhost';
$dbConfig['oracle']['userName']     = 'username';
$dbConfig['oracle']['password']     = 'password';
$dbConfig['oracle']['SID']          = 'SID';
$dbConfig['oracle']['cacheType']    = 'file';
$dbConfig['oracle']['charSet']      = 'WE8ISO8859P9';
#$dbConfig['oracle']['charSet']      = null;