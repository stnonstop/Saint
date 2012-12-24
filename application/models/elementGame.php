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

        /*
        $this->data = array(
            array(
                'search' => array('Toprak', 'Su'),
                'result' => 'Çamur'
            ),
            array(
                'search' => array('Ateş', 'Su'),
                'result' => 'Buhar'
            ),
            array(
                'search' => array('Ateş', 'Toprak'),
                'result' => 'Lav'
            ),
            array(
                'search' => array('Su', 'Hava'),
                'result' => 'Yağmur'
            ),
            array(
                'search' => array('Yağmur', 'Toprak'),
                'result' => 'Bitki'
            ),
            array(
                'search' => array('Çamur', 'Bitki'),
                'result' => 'Hayat'
            ),
            array(
                'search' => array('Hayat', 'Toprak'),
                'result' => 'İnsan'
            ),
            array(
                'search' => array('İnsan', 'Toprak'),
                'result' => 'Para'
            )
        );*/
    }

    public function mixThem($firstElement, $secondElement){

        $query['collection'] = 'recipies';
        $query['query'] = array(
            '$OR:' => array(
                array(
                    'search' => array($firstElement, $secondElement)
                ),
                array(
                    'search' => array($secondElement, $firstElement)
                )
            )
        );
        $query['fields'] = 'result';
        $result = $this->db->get($query, 'assoc', 180);
        var_dump($result);
        /*
        foreach($this->data AS $recipie){
            $controlArray = array_diff($recipie['search'], $searchRecipie);
            if(count($controlArray) == 0){
                $recipie['addIngredientList'] = $this->addIngredientList($recipie['result']);
                return $recipie;
            }
        }*/
        return false;
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
