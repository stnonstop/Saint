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
    public function __construct() {
        session_start();
    }
}
