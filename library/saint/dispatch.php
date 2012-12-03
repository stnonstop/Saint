<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 03.12.2012
 * Time: 01:06
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class dispatch
{
    /**
     * @param $router router
     */
    public static function dispatcher(router $router){

        $controllerName = $router->getController();
        $actionName     = $router->getAction();

        $controllerClass = $controllerName . 'Controller';
        $actionMethod    = $actionName . 'Action';

        $view   = new view();
        $config = new config();

        if(! isset($config->route[$controllerName])) {
            header::notFound();
        }


        $controller = new $controllerClass($view, $router->getParams());

        if(is_callable(array($controller, $actionMethod)) == false){
            $actionName     = 'index';
            $actionMethod   = $actionName . 'Action';
        }
        //Execute Init Method
        $controller->init();

        //Execute Action Method
        $controller->$actionMethod();

        if($view->getRenderStatus()){
            $viewFile = $view->getViewFile($controllerName, $actionName);
            foreach($view->getVariables() AS $key => $value) {
                $$key = $value;
            }
            include $viewFile;
        }

        //Execute Destroy Method
        $controller->destroy();


    }
}
