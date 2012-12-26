<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 26.12.2012
 * Time: 01:01
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class stringUtil
{
    private static $fixCharacters = array(
        'c2' => array ( 'a0' => ' ',
            'bd' => '½'
        )
    );

    private static $fix3Characters = array(
        'e2' => array ( '80' => array('93' => '-') )
    );


    public static function utf8Fix($utf8String) {

        $stringLen = strlen($utf8String);
        $output = '';

        for($i=0; $i< $stringLen; $i++) {
            if(array_key_exists(bin2hex($utf8String[$i]), self::$fixCharacters)) {
                $output .=  self::$fixCharacters[bin2hex($utf8String[$i])][bin2hex($utf8String[$i+1])];
                $i++;
            } elseif(array_key_exists(bin2hex($utf8String[$i]), self::$fix3Characters)) {
                $output .=  self::$fix3Characters[bin2hex($utf8String[$i])][bin2hex($utf8String[$i+1])][bin2hex($utf8String[$i+2])];
                $i = $i+2;
            } else {
                $output .= $utf8String[$i];
            }
        }

        return $output;

    }

}
