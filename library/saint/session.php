<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adurmaz
 * Date: 20.12.2012
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class session
{

    protected $_nameSpace;

    public function __construct() {
        session_start();
        //@todo: Buraya session start validasyonlarý konulabilinir.
    }

    public function __set($name, $value){
        $_SESSION[$name] = $value;
    }

    public function &__get($name){
        return $_SESSION[$name];
    }
}
