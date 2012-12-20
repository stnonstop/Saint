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
            )
        );
    }

    public function mixThem($firstElement, $secondElement){
        $searchRecipie = array($firstElement, $secondElement);
        foreach($this->data AS $recipie){
            $controlArray = array_diff($recipie['search'], $searchRecipie);
            if(count($controlArray) == 0){
                return $recipie;
            }
        }
        return false;
    }
}
