<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 06.12.2012
 * Time: 00:15
 * To change this template use File | Settings | File Templates.
 */
namespace saint\errorMessage;
abstract class errorMessageAbstract
{
    static protected $errorMessages = array();
    static protected $errorFunctions = array();

    public final function __constuct(){
        if(empty(self::$errorMessages)){
            self::errorMessages();
        }
    }

    public function __get($name){
        if(isset(self::$errorMessages[$name]) && !isset(self::$errorFunctions[$name])){
            return self::$errorMessages[$name];
        } else {
            $trace = debug_backtrace();
            trigger_error('Class name :'.__CLASS__.' Undefined ErrorName '.$name.' in '.$trace[0]['file'].' on line '. $trace[0]['line'], E_USER_NOTICE);
            return false;
        }
    }

    public function __call($name, $args){
        if(isset(self::$errorFunctions[$name])){
            $errorMessage = self::$errorMessages;
            foreach($args AS $key=>$value){
                $errorMessage = str_replace('#*#args'.$key.'#*#', $value, $errorMessage);
            }
            return $errorMessage;
        } else {
            $trace = debug_backtrace();
            trigger_error(' Undefined ErrorFunc ' . 'Class name :'.__CLASS__ .$name.' in '.$trace[0]['file'].' on line '. $trace[0]['line'], E_USER_NOTICE);
            return false;
        }
    }

    abstract protected function errorMessages();
}
