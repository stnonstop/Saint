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

    public function __construct(){
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
        );
    }

    public function mixThem($firstElement, $secondElement){
        $searchRecipie = array($firstElement, $secondElement);
        foreach($this->data AS $recipie){
            $controlArray = array_diff($recipie['search'], $searchRecipie);
            if(count($controlArray) == 0){
                $recipie['addIngredientList'] = $this->addIngredientList($recipie['result']);
                return $recipie;
            }
        }
        return false;
    }

    public function getIngredientList() {
        if(! isset($_SESSION['ingredientList'])){
            $_SESSION['ingredientList'] = array();
        }
        return $_SESSION['ingredientList'];
    }

    protected function addIngredientList($ingredient){
        if(! isset($_SESSION['ingredientList'])){
            $_SESSION['ingredientList'] = array();
        }
        if(in_array($ingredient, $_SESSION['ingredientList'])) {
            return false;
        } else {
            $_SESSION['ingredientList'][] = $ingredient;
            return true;
        }
    }
}
