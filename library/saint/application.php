<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 03.12.2012
 * Time: 00:30
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class application
{

    /**
     * @var router
     */
    protected $router;

    public function __construct() {
        $this->router = new router();
    }

    public function run(){
        dispatch::dispatcher($this->router);
    }
}
