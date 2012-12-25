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
        $recipie = $this->db->get($query, 'assoc', 180);
        $recipie['addIngredientList'] = $this->addIngredientList($recipie['result']);
        return $recipie;

    }

    public function getIngredientList() {
        if( $this->sessionContainer->ingredientList == null){
            $this->sessionContainer->ingredientList = array();
        }
        return $this->sessionContainer->ingredientList;
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
}
