<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adurmaz
 * Date: 21.12.2012
 * Time: 09:55
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class db
{

    public function __construct($dbName){
        $config = new config();
        if(empty($config->db[$dbName])){

        }
    }

    public function get($query, $fetchType='assoc', $cacheTimeOut)
    {
        // TODO: Implement get() method.
    }

    public function execute($query)
    {
        // TODO: Implement execute() method.
    }
}
