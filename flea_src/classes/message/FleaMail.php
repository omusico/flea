<?php
class FleaMail{
    //成員函數
    var $mail_type;
    var $mail_header;
    var $mail_from;
    var $mail_from_name;
    var $mail_to;
    var $mail_to_name;
    
    //建構子
    function __construct($type,$to_name='',$to='',$from_name='DCT',$from='nccu.dct.tw@gmail.com'){
        $this->mail_type = $type;
        $this->mail_header = "MIME-Version: 1.0\n".
                             "Content-type: multipart/alternative; boundary=\"===============0719144586==\"\n".
                             "From:=?UTF-8?B?".base64_encode($from_name)."?= <".$from.">\n";
        $this->mail_from = $from;
        $this->mail_from_name = $from_name;
        $this->mail_to = $to;
        $this->mail_to_name = $to_name;
    }
    
    function send_mail($params){
    
         switch ($this->mail_type){
            case 'invite_signup':
                $subject = "NCCU Flea 帳戶啟動通知"; 
                $mail_subject = "=?UTF-8?B?".base64_encode($subject)."?=";
                $get_url = SITE_URL."/mail_template/signup.php?".$params;                
                $mail_content = file_get_contents($get_url);
                mail($this->mail_to, $mail_subject, $mail_content, $this->mail_header);
            break;
            case 'follow_box_item':
                $subject = "NCCU Flea 物品追蹤通知"; 
                $mail_subject = "=?UTF-8?B?".base64_encode($subject)."?=";
                $get_url = SITE_URL."/mail_template/follow_box_item_note.php?".$params;                
                $mail_content = file_get_contents($get_url);
                mail($this->mail_to, $mail_subject, $mail_content, $this->mail_header);
            break;
            case 'buy_box_item':
                $subject = "NCCU Flea 物品訂購通知"; 
                $mail_subject = "=?UTF-8?B?".base64_encode($subject)."?=";
                $get_url = SITE_URL."/mail_template/buy_box_item_note.php?".$params;                
                $mail_content = file_get_contents($get_url);
                mail($this->mail_to, $mail_subject, $mail_content, $this->mail_header);
            break;
            case 'ibuy_box_item':
                $subject = "NCCU Flea 物品訂購通知"; 
                $mail_subject = "=?UTF-8?B?".base64_encode($subject)."?=";
                $get_url = SITE_URL."/mail_template/ibuy_box_item_note.php?".$params;                
                $mail_content = file_get_contents($get_url);
                mail($this->mail_to, $mail_subject, $mail_content, $this->mail_header);
            break;
        }
    }

    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->mail_type);
        unset($this->mail_header);
        unset($this->mail_from);
        unset($this->mail_from_name);
        unset($this->mail_to);
        unset($this->mail_to_name);
    }
   
}
?>