<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 03.12.2012
 * Time: 03:07
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class header
{
    public static function notFound(){
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    public static function redirect($url, $httpCode = null) {
        if($httpCode == 301) {
            header ('HTTP/1.1 301 Moved Permanently');
        }
        header("Location:" . $url );
        exit;
    }
}
