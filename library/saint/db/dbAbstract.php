<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Aziz DURMAZ
 * Date: 21.12.2012
 * Time: 19:00
 * To change this template use File | Settings | File Templates.
 */

namespace saint\db;
abstract class dbAbstract
{

    private static $connections = array();

    protected $options = array();

    protected $dbName;

    public function __construct($dbName, $options) {
        $this->options = $options;
        $this->dbName = $dbName;
    }

    abstract public function get($query, $fetchType, $cacheTime = 0);
    abstract public function execute($query);
    abstract public function getLastInsertedID();
    abstract public function getAffectedRows();

    protected static function getConnection($dbName){
        if(array_key_exists($dbName, self::$connections)) {
            return self::$connections[$dbName];
        }
        return null;
    }

    protected static function setConnection($connection, $dbName){
        self::$connections[$dbName] = $connection;
    }

}
