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

    /**
     * @var view
     */
    protected $view;

    /**
     * @var config
     */
    protected $config;

    public function __construct() {
        $this->router = new router();
        $this->config = new config();
        $this->view   = new view();
    }

    public function run(){
        dispatcher::dispatch($this->router, $this->config, $this->view);
    }
}
