<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 03.12.2012
 * Time: 02:03
 * To change this template use File | Settings | File Templates.
 */
namespace saint\controller;
abstract class abstractor
{
    /**
     * @var \saint\view
     */
    protected $view;

    /**
     * @var array
     */
    protected $userParams = array();

    public final function __construct(\saint\view $view, $params) {
        $this->view         = $view;
        $this->userParams   = $params;
    }

    public function init() {
        //OVERWRITE TO USE
    }

    public function destroy(){
        //OVERWRITE TO USE
    }

    abstract public function indexAction();
}
