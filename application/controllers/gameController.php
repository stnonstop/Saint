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

    }

    public function mixajaxAction(){
        $this->view->setNoRender();
        $elementGame = new \models\elementGame();
        $mixtureResult = $elementGame->mixThem($this->userParams['element1'], $this->userParams['element2']);
        $result = array();
        if($mixtureResult === false){
            $result['success'] = false;
        } else {
            $result['success'] = true;
            $result['result'] = $mixtureResult['result'];
            $result['firstElement'] = $mixtureResult['search'][0];
            $result['firstElement'] = $mixtureResult['search'][1];
            //echo $this->userParams['element1'].' ile '.$this->userParams['element2'] . ' birleştirip ' . $mixtureResult['result'] . ' elde ettiniz.';
        }
        echo json_encode($result);
    }
}
