<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 21.12.2012
 * Time: 20:11
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class cache extends cache\cacheAbstract
{
    /**
     * @var cache\cacheAbstract
     */
    private $cache;

    private static $cacheLayers = array('memcache','file');

    public function __construct($layer, $options){
        $this->cache = self::factory($layer, $options);
    }

    public function get($key, $expire = 0)
    {
        return $this->cache->get($key, $expire);
    }

    public function set($key, $value, $expire = 0)
    {
        return $this->cache->set($key, $value, $expire);
    }

    public function delete($key)
    {
        return $this->cache->delete($key);
    }

    private static function factory($layer, $options){
        if(! in_array($layer, self::$cacheLayers)) {
            throw new \Exception('Invalid Cache Layer!');
        }
        $cacheClass = '\\saint\\cache\\'.$layer;
        return new $cacheClass($options);
    }
}
