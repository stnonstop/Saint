<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 19.12.2012
 * Time: 20:20
 * To change this template use File | Settings | File Templates.
 */
class gameController extends saint\controller\controllerAbstract
{

    public function indexAction()
    {
        // TODO: Implement indexAction() method.
    }

    public function mixajaxAction(){
        $this->view->setNoRender();
        $elementGame = new \models\elementGame();
        $mixtureResult = $elementGame->mixThem($this->userParams['element1'], $this->userParams['element2']);
        if($mixtureResult === false){
            echo 'beceriksiz....';
        } else {
            echo $this->userParams['element1'].' ile '.$this->userParams['element2'] . ' birleştirip ' . $mixtureResult['result'] . ' elde ettiniz.';
        }
    }
}
