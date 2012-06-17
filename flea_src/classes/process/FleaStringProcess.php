<?php

class FleaStringProcess{
    //成員函數
    
    //建構子
    function __construct(){
    }
    
    private static function getUnicodeChar($str) {
        $bs = split('\u',$str);
        $c = "";
        for($i = 1; $i < count($bs); $i++) {
        $c .= chr(hexdec(substr($bs[$i],2)));
        $c .= chr(hexdec(substr($bs[$i],0,2)));
        }
        return $c;
    }

    //將\uXXXX\uXXXX…等的unicode编碼形式轉換成utf8
    private static function unicodeEncode2utf8($str) {
        $c = FleaStringProcess::getUnicodeChar($str[0]);
        return iconv("UTF-16","UTF-8",$c);
    }
    
    function unicode_to_utf8($str){
        return preg_replace_callback("/\\\u(.{4})/","FleaStringProcess::unicodeEncode2utf8",$str);
    }


    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){

    }
   
}
?>