<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 06.12.2012
 * Time: 00:17
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class debugger
{
    protected static $time = 0;

    public static function timeDiff($message = null){
        $time = time();
        $timeDiff = $time - self::$time;
        self::$time = $time;
        return $message . ' ' . $timeDiff . ' sn. <br />';
    }

    public static function dump($mixed){
        echo '<pre>';
        var_dump($mixed);
        echo '</pre>';
    }
}
