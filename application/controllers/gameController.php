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
        $sessionContainer = new \saint\session();

        $mongoDB = new \saint\db('mongo');
        $elementGame = new \models\elementGame($sessionContainer, $mongoDB);
        $this->view->ingredientList = $elementGame->getIngredientList();
        $this->view->ingredientCount = count($this->view->ingredientList);
    }

    public function addrecipieAction()
    {

    }

    public function mixajaxAction(){
        $this->view->setNoRender();
        $sessionContainer = new \saint\session();
        $mongoDB = new \saint\db('mongo');
        $elementGame = new \models\elementGame($sessionContainer, $mongoDB);
        $mixtureResult = $elementGame->mixThem($this->userParams['element1'], $this->userParams['element2']);
        $result = array();
        if($mixtureResult === false){
            $result['success'] = false;
        } else {
            $result['success'] = true;
            $result['result'] = $mixtureResult['result'];
            $result['addIngredientList'] = $mixtureResult['addIngredientList'];
        }
        echo json_encode($result);
    }
}
