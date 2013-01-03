<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 03.12.2012
 * Time: 01:01
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class router
{
    /**
     * @var array();
     */
    private $routeParts = array();
    /**
     * Controller Name
     * @var string
     */
    private $controller;

    /**
     * Action Name
     * @var string
     */
    private $action;

    /**
     * Parameters
     * @var array
     */
    private $params = array();

    public function __construct(){

        $route = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if($route){
            $this->routeParts = explode('/', $route);
            $this->setController();
            $this->setAction();
        }
        $this->setParams();

    }

    private function setController(){

        $controllerNameOrg = $this->routeParts[0];
        $this->controller = str_replace('-', '', $controllerNameOrg);

        $this->params['__ControllerName']    = $this->controller;
        $this->params['__ControllerNameOrg'] = $controllerNameOrg;

        array_shift($this->routeParts);
    }

    private function setAction(){
        $actionNameOrg = null;
        if(! empty($this->routeParts[0])){
            $actionNameOrg = $this->routeParts[0];
            $this->action = str_replace('-', '', $actionNameOrg);
            array_shift($this->routeParts);
        }
        $this->params['__ActionName']        = $this->action;
        $this->params['__ActionNameOrg']     = $actionNameOrg;
    }

    private function setParams(){
        $this->params  = array_merge($this->params, $this->routeParts, $_REQUEST);
    }

    public function getController(){
        if(empty($this->controller)) {
            $this->controller = 'index';
        }
        return $this->controller;
    }

    public function getAction(){
        return $this->action;
    }

    public function getParams(){
        return $this->params;
    }
}
