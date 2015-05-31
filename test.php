<?php
    $array = array();
    
    $a = "Let";
    $b = "us";
    $c = "make";
    $d = "an";
    $e = "array";

    array_push ($array, array($a, $b, $c, $d, $e));

    $a = "Now";
    $b = "let's";
    $c = "undo";
    $d = "the";
    $e = "array";           
    
    array_push ($array, array($a, $b, $c, $d, $e));
    $result = '';
    foreach ($array as $value1)
    {
        foreach ($value1 as $value2)
        $result .= $value2;
    }
    echo $result
    
   
?>