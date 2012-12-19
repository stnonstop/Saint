<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 03.12.2012
 * Time: 01:34
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class view
{

    /**
     * Determine view visibility
     * @var bool
     */
    private $viewRender = true;

    /**
     * Variable List
     * @var array
     */
    private $variables = array();

    /**
     * Set Variables
     * @param $name string
     * @param $value mixed
     */
    public function __set($name, $value){
        $this->variables[$name] = $value;
    }

    /**
     * Get Variables
     * @return array
     */
    public function getVariables(){
        return $this->variables;
    }

    /**
     * Get Render Status;
     * @return bool
     */
    public function getRenderStatus() {
        return $this->viewRender;
    }

    public function setNoRender(){
        $this->viewRender = false;
    }

    /**
     * Returns View File
     * @param $controllerName string
     * @param $actionName string
     * @return string
     */
    public function getViewFile($controllerName, $actionName){
        return APPLICATION_PATH . DIRECTORY_SEPARATOR. 'views' . DIRECTORY_SEPARATOR . $controllerName . DIRECTORY_SEPARATOR . $actionName .'.phtml';
    }

}
