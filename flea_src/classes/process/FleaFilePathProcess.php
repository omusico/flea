<?php

class FleaFilePathProcess{
    //成員函數
    var $data_path = "/var/www/html/fleadata";
    var $data_url = "http://dctlab.nccu.edu.tw/fleadata";
    var $user_data_path = "";
    var $user_data_url = "";
    var $user_icon_path = "";
    var $user_icon_url = "";
    var $user_item_path = "";
    var $user_item_url = "";
    var $user_box_path = "";
    var $user_box_url = "";

    //建構子
    function __construct($input_user_id){
        if(!empty($input_user_id)){
        
            $parent_dir = (floor($input_user_id/30000)+1)*30000;
            if(!file_exists($this->data_path.'/'.$parent_dir)){
                mkdir($this->data_path.'/'.$parent_dir);
                chown($this->user_data_path, "apache");
                chgrp($this->user_data_path, "apache");
            }
            
            $this->user_data_path = $this->data_path.'/'.$parent_dir.'/'.$input_user_id;
            $this->user_data_url = $this->data_url.'/'.$parent_dir.'/'.$input_user_id; 
            if(!file_exists($this->user_data_path)){
                mkdir($this->user_data_path);
                chown($this->user_data_path, "apache");
                chgrp($this->user_data_path, "apache");
            }
            
            $this->user_icon_path = $this->user_data_path.'/user_icon';
            $this->user_icon_url = $this->user_data_url.'/user_icon'; 
            if(!file_exists($this->user_icon_path)){
                mkdir($this->user_icon_path);
                chown($this->user_icon_path, "apache");
                chgrp($this->user_icon_path, "apache");
            }
            
            $this->user_item_path = $this->user_data_path.'/user_item';
            $this->user_item_url = $this->user_data_url.'/user_item'; 
            if(!file_exists($this->user_item_path)){
                mkdir($this->user_item_path);
                chown($this->user_item_path, "apache");
                chgrp($this->user_item_path, "apache");
            }
            
            $this->user_box_path = $this->user_data_path.'/user_box';
            $this->user_box_url = $this->user_data_url.'/user_box'; 
            if(!file_exists($this->user_box_path)){
                mkdir($this->user_box_path);
                chown($this->user_box_path, "apache");
                chgrp($this->user_box_path, "apache");
            }
        }
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
    }
   
}
?>
