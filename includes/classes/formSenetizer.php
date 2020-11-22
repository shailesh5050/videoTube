<?php 
class formSenetizer{
    public static function senetizedFormString($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
        $inputText = strtolower($inputText);
        $inputText = ucfirst($inputText);
        return $inputText;
    
    }

    public static function senetizedFormUsername($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
        
        return $inputText;
    
    }

    public static function senetizedFormEmail($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
        
        return $inputText;
    
    }

    public static function senetizedFormPassword($inputText){
        $inputText = strip_tags($inputText);
        
        return $inputText;
    
    }
}

?>