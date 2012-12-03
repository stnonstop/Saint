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
     * Controller Name
     * @var string
     */
    protected $controller;

    /**
     * Action Name
     * @var string
     */
    protected $action;

    /**
     * Parameters
     * @var array
     */
    protected $params = array();

    public function __construct(){

        $route = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if($route){
            $routeParts = explode('/', $route);

            $controllerNameOrg = $routeParts[0];
            $this->controller = str_replace('-', '', $controllerNameOrg);

            array_shift($routeParts);

            $actionNameOrg = null;
            if(! empty($routeParts[0])){
                $actionNameOrg = $routeParts[0];
                $this->action = str_replace('-', '', $actionNameOrg);

                array_shift($routeParts);
            }

            $routeParts = array_merge($routeParts, $_GET);
            $this->params = $routeParts;
            $this->params['__ActionName']        = $this->action;
            $this->params['__ActionNameOrg']     = $actionNameOrg;
            $this->params['__ControllerName']    = $this->controller;
            $this->params['__ControllerNameOrg'] = $controllerNameOrg;

        }

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
