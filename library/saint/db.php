<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adurmaz
 * Date: 21.12.2012
 * Time: 09:55
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class db extends db\dbAbstract
{
    /**
     * @var array
     */
    private static $dbConnections = array();

    /**
     * @var config
     */
    private $config;

    /**
     * @var cache
     */
    private static $cache;

    private static $dbDrivers = array('mongo','mysql');

    protected $dbName;

    public function __construct($dbName){
        $this->dbName = $dbName;
        $this->config = new config();
        if(! array_key_exists($this->dbName, self::$dbConnections)){
            $dbConfigList = $this->config->db;
            self::$dbConnections = self::factory($this->dbName, $dbConfigList);
        }
    }

    private static function factory($dbName, $dbConfigList){
        if(! array_key_exists($dbName,$dbConfigList) || $dbConfigList[$dbName]['driverType'] == ''){
            throw new \Exception('Undefined database config');
        } elseif(! in_array($dbConfigList[$dbName]['driverType'], self::$dbDrivers)){
            throw new \Exception('Undefined database driver type');
        }

        $className = 'db\\'.$dbConfigList[$dbName]['driverType'];
        return new $className($dbName, $dbConfigList[$dbName]);

    }

    public function get($query, $fetchType, $cacheTime = 0)
    {
        $result = null;

        if($cacheTime > 0){
            $cacheKey = $this->getQueryCacheKey($query, $fetchType);
            $result = $this->getCache($cacheKey, $cacheTime);
        }

        if($result == null){
            $result = self::$dbConnections[$this->dbName]->get($query, $fetchType, $cacheTime);
            if($cacheTime > 0){
                $this->setCache($cacheKey, $result, $cacheTime);
            }
        }
        return $result;

    }

    public function execute($query)
    {
        return self::$dbConnections[$this->dbName]->execute($query);
    }

    public function getLastInsertedID()
    {
        return self::$dbConnections[$this->dbName]->getLastInsertedID();
    }

    public function getAffectedRows()
    {
        return self::$dbConnections[$this->dbName]->getAffectedRows();
    }

    private  function getQueryCacheKey($query, $fetchType){
        return 'db_'.md5($query.'|'.$fetchType);
    }

    private function getCache($key, $expire){
        $cache = $this->checkCacheStatus();
        if($cache !== false){
            return $cache->get($key, $expire);
        }
        return null;
    }

    private function setCache($key, $value, $expire){
        $cache = $this->checkCacheStatus();
        if($cache !== false) {
            return $cache->set($key, $value, $expire);
        }
        return null;
    }

    /**
     * @return cache
     */
    private function checkCacheStatus(){
        if (! isset (self::$cache[$this->dbName])) {

            $cacheLayer = $this->config->db[$this->dbName]['cacheType'];
            if($cacheLayer != '') {
                $options['serialize'] = true;
                self::$cache[$this->dbName] = new cache($this->config->db[$this->dbName]['cacheType'],$options);
            } else {
                return false;
            }
        }
        return self::$cache[$this->dbName];
    }
}
