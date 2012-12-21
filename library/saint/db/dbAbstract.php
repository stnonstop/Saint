<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adurmaz
 * Date: 21.12.2012
 * Time: 11:11
 * To change this template use File | Settings | File Templates.
 */
namespace saint\db;
abstract class dbAbstract
{
    abstract public function get($query);
    abstract public function execute($query);
}
