<?php 

class Validator {
    static function isNumber($input){
        return is_numeric($input);
    }

    static function isNotNull($input){
        return $input!==null;
    }

    static function matchesRegex($input,$regex){
         preg_match($regex, $input, $matches);
         return count($matches) == 0;
    }
}

?>