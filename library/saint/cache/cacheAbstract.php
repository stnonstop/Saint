<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Aziz DURMAZ
 * Date: 21.12.2012
 * Time: 20:12
 * To change this template use File | Settings | File Templates.
 */
namespace saint\cache;
abstract class cacheAbstract
{
    protected $options = array();

    public function __construct($options) {
        $this->options = $options;
    }

    abstract public function get($key, $expire = 0);
    abstract public function set($key, $value, $expire = 0);
    abstract public function delete($key);
}
