<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 19.12.2012
 * Time: 22:58
 * To change this template use File | Settings | File Templates.
 */
namespace models;
class elementGame
{
    protected $data;

    /**
     * @var \saint\session
     */
    protected $sessionContainer;

    /**
     * @var \saint\db
     */
    protected $db;

    public function __construct(\saint\session $session, \saint\db $db){

        $this->sessionContainer = $session;
        $this->db = $db;
    }

    public function mixThem($firstElement, $secondElement){

        $recipie = $this->getRecipie($firstElement, $secondElement ,180);
        if($recipie['result'] != null){
            $recipie['addIngredientList'] = $this->addIngredientList($recipie['result']);
            return $recipie;
        } else {
            return false;
        }
    }

    public function addRecipie($firstElement, $secondElement, $newElement){

        $ingredient = $this->getIngredient($firstElement);
        if($ingredient['result'] != $firstElement) {
            return array('status' => 'unknown ingredient');
        }

        $ingredient = $this->getIngredient($secondElement);
        if($ingredient['result'] != $secondElement) {
            return array('status' => 'unknown ingredient');
        }

        $recipieControl = $this->getRecipie($firstElement,$secondElement,0);
        if($recipieControl['result'] != '') {
            return array('status'=>'Already exist', 'element' => $recipieControl['result']);
        }
        $this->setRecipie($firstElement,$secondElement,$newElement);
        return array('status'=>'Added');
    }

    public function getRecipieList(){
        $query['collection'] = 'recipies';
        $query['query'] = array();
        $query['fields'] = array();
        return $this->db->get($query, 'assocArray', 0);
    }

    protected function getRecipie($firstElement, $secondElement, $cacheTime){
        $query['collection'] = 'recipies';
        $query['query'] = array(
            '$or' => array(
                array(
                    'search' => array($firstElement, $secondElement)
                ),
                array(
                    'search' => array($secondElement, $firstElement)
                )
            )
        );
        $query['fields'] = array('result'=>1, '_id' => 0);
        return $this->db->get($query, 'assoc', $cacheTime);
    }

    protected function setRecipie($firstElement, $secondElement, $newElement){
        $query['collection'] = 'recipies';
        $query['data'] = array(
            'search' => array($firstElement, $secondElement),
            'result' => $newElement
        );
        $this->db->execute($query);
    }

    protected function addIngredientList($ingredient){
        if( $this->sessionContainer->ingredientList == null){
            $this->sessionContainer->ingredientList = array();
        }
        if(in_array($ingredient, $this->sessionContainer->ingredientList)) {
            return false;
        } else {
            array_push($this->sessionContainer->ingredientList,$ingredient);
            return true;
        }
    }

    public function getIngredientList() {
        if( $this->sessionContainer->ingredientList == null){
            $this->sessionContainer->ingredientList = array();
        }
        return $this->sessionContainer->ingredientList;
    }

    protected function getIngredient($element){
        $query['collection'] = 'recipies';
        $query['query'] = array('result' => $element);
        $query['fields'] = array('result'=>1, '_id' => 0);
        return $this->db->get($query, 'assoc', 0);
    }
}
