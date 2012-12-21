<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 03.12.2012
 * Time: 02:59
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class config
{

    private static $configs = array();

    public function __construct(){
        if(! self::$configs) {
            $routeConfig = array();
            include APPLICATION_PATH . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'route.config.inc.php';
            self::$configs['route'] = $routeConfig;
            include APPLICATION_PATH . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'db.config.inc.php';
            self::$configs['db']    = $dbConfig;
        }

    }

    public function __get($name){
        return self::$configs[$name];
    }

}
