<?php
class FleaCookieProcess{
    //成員函數
    
    //建構子
    function __construct(){
    }
    
    function clear_cookie(){
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                if($name=='email' || $name=='user_id'){
                    setcookie($name, '', time()-60000, '/',".dctlab.nccu.edu.tw");
                    setcookie($name, '', time()-60000, '/');
                }
            }
        }
    }
    
    function set_cookie($user_id,$mode='default'){
        $user_obj = new FleaUser($user_id);
        setcookie("invite_email", $user_obj->invite_email,0,"/",".dctlab.nccu.edu.tw");
        setcookie("account", $user_obj->account,0,"/",".dctlab.nccu.edu.tw");
        setcookie("user_id", $user_obj->id,0,"/",".dctlab.nccu.edu.tw");
    }

    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
    
    }
   
}
?>