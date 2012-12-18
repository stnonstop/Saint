<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 03.12.2012
 * Time: 01:06
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class dispatcher
{
    /**
     * @param router $router
     * @param config $config
     * @param view $view
     */
    public static function dispatch(router $router, config $config, view $view){

        $controllerName = $router->getController();
        $actionName     = $router->getAction();

        $controllerClass = $controllerName . 'Controller';
        $actionMethod    = $actionName . 'Action';

        if(! isset($config->route[$controllerName])) {
            header::notFound();
        }

        try {
           $controller = new $controllerClass($view, $router->getParams());
        } catch(\Exception $e) {
            header::notFound();
        }

        if(($controller instanceof \saint\controller\controllerAbstract) === false){
            header::notFound();
        }


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
