<?php
class FleaUser {
    //成員函數
    var $id;
    var $account;
    var $invite_email;
    var $school_id;
    var $school_department_id;
    var $nickname;
    var $email;
    var $birthday;
    var $gender;
    var $firstname;
    var $lastname;
    var $about_me;
    var $icon;
    var $contact_number;
    var $is_deleted;
    var $create_time;
    var $update_time;
    var $delete_time;
    var $auth_id;
    var $is_verify;
    var $fb_id;
    var $fb_name;
    var $fb_icon;
    var $fb_profile;
    var $fb_access_token;
    
    //建構子
    function __construct($input_user_key,$type='id'){
        $dbc = connectdb();
        switch($type){
            case 'id':
                $query_user = mysql_query("SELECT * FROM user WHERE id='$input_user_key' LIMIT 1",$dbc);
                while ($query_user_data = mysql_fetch_array($query_user)) {
                    $this->id = $query_user_data['id'];
                    $this->account = $query_user_data['account'];
                    $this->invite_email = $query_user_data['invite_email'];
                    $this->school_id = $query_user_data['school_id'];
                    $this->school_department_id = $query_user_data['school_department_id'];
                    $this->nickname = $query_user_data['nickname'];
                    $this->email = $query_user_data['email'];
                    $this->birthday = $query_user_data['birthday'];
                    $this->gender = $query_user_data['gender'];
                    $this->firstname = $query_user_data['firstname'];
                    $this->lastname = $query_user_data['lastname'];
                    $this->about_me = $query_user_data['about_me'];
                    $this->icon = $query_user_data['icon'];
                    $this->contact_number = $query_user_data['contact_number'];
                    $this->is_deleted = $query_user_data['is_deleted'];
                    $this->create_time = $query_user_data['create_time'];
                    $this->update_time = $query_user_data['update_time'];
                    $this->delete_time = $query_user_data['delete_time'];
                    $this->auth_id = $query_user_data['auth_id'];
                    $this->is_verify = $query_user_data['is_verify'];
                    $this->fb_id = $query_user_data['fb_id'];
                    $this->fb_name = $query_user_data['fb_name'];
                    $this->fb_icon = $query_user_data['fb_icon'];
                    $this->fb_profile = $query_user_data['fb_profile'];
                    $this->fb_access_token = $query_user_data['fb_access_token'];
                }
                /* free result set */
                mysql_free_result($query_user);
            break;
            case 'account':
                $query_user = mysql_query("SELECT * FROM user WHERE account='$input_user_key' LIMIT 1",$dbc);
                while ($query_user_data = mysql_fetch_array($query_user)) {
                    $this->id = $query_user_data['id'];
                    $this->account = $query_user_data['account'];
                    $this->invite_email = $query_user_data['invite_email'];
                    $this->school_id = $query_user_data['school_id'];
                    $this->school_department_id = $query_user_data['school_department_id'];
                    $this->nickname = $query_user_data['nickname'];
                    $this->email = $query_user_data['email'];
                    $this->birthday = $query_user_data['birthday'];
                    $this->gender = $query_user_data['gender'];
                    $this->firstname = $query_user_data['firstname'];
                    $this->lastname = $query_user_data['lastname'];
                    $this->about_me = $query_user_data['about_me'];
                    $this->icon = $query_user_data['icon'];
                    $this->contact_number = $query_user_data['contact_number'];
                    $this->is_deleted = $query_user_data['is_deleted'];
                    $this->create_time = $query_user_data['create_time'];
                    $this->update_time = $query_user_data['update_time'];
                    $this->delete_time = $query_user_data['delete_time'];
                    $this->auth_id = $query_user_data['auth_id'];
                    $this->is_verify = $query_user_data['is_verify'];
                    $this->fb_id = $query_user_data['fb_id'];
                    $this->fb_name = $query_user_data['fb_name'];
                    $this->fb_icon = $query_user_data['fb_icon'];
                    $this->fb_profile = $query_user_data['fb_profile'];
                    $this->fb_access_token = $query_user_data['fb_access_token'];
                }
                /* free result set */
                mysql_free_result($query_user);
            break;
        }
        unset($dbc);
    }
    
    function getUserIcon($size='50'){
        $path_obj = new FleaFilePathProcess($this->id);
        if(!empty($this->icon)){
            $occ = strrpos($this->icon,".");
            $subname = substr($this->icon, $occ);
            if($size=='0'){
                $icon_link = $path_obj->user_icon_url.'/'.$this->id.$subname;
            } else {
                $icon_link = $path_obj->user_icon_url.'/'.$this->id.'_'.$size."s".$subname;
            }
        } else {
            if($size=='0'){
                $icon_link = SITE_URL."/images/nopic/nopic.jpg";
            } else {
                $icon_link = SITE_URL.'/images/nopic/nopic_'.$size."s.jpg";
            }
        }
        return $icon_link;
    }
    
    function getUserIconR($size='100'){
        $path_obj = new FleaFilePathProcess($this->id);
        if(!empty($this->icon)){
            $occ = strrpos($this->icon,".");
            $subname = substr($this->icon, $occ);
            if($size=='0'){
                $icon_link = $path_obj->user_icon_url.'/'.$this->id.$subname;
            } else {
                $icon_link = $path_obj->user_icon_url.'/'.$this->id.'_'.$size."r".$subname;
            }
        } else {
            if($size=='0'){
                $icon_link = SITE_URL."/images/nopic/nopic.jpg";
            } else {
                $icon_link = SITE_URL.'/images/nopic/nopic_'.$size."r.jpg";
            }
        }
        return $icon_link;
    }
    
    function getUserIconRW($size='100'){
        $path_obj = new FleaFilePathProcess($this->id);
        if(!empty($this->icon)){
            $occ = strrpos($this->icon,".");
            $subname = substr($this->icon, $occ);
            if($size=='0'){
                $icon_link = $path_obj->user_icon_url.'/'.$this->id.$subname;
            } else {
                $icon_link = $path_obj->user_icon_url.'/'.$this->id.'_'.$size."w".$subname;
            }
        } else {
            if($size=='0'){
                $icon_link = SITE_URL."/images/nopic/nopic.jpg";
            } else {
                $icon_link = SITE_URL.'/images/nopic/nopic_'.$size."r.jpg";
            }
        }
        return $icon_link;
    }
    
    function getBoxItemFollowBtn($type,$item_id,$box_item_id){
        $dbc = connectdb();
        $query_box_item_follow = mysql_query("SELECT * FROM follow_item WHERE box_item_id='$box_item_id' AND follower_id='$this->id' ",$dbc);
        $query_box_item_follow_num = mysql_num_rows($query_box_item_follow);
        mysql_free_result($query_box_item_follow);
        $button_string = '';
        switch ($type){
            case 'small':
                if($query_box_item_follow_num>0){
                    $button_string = '<span>已追蹤</span>';
                } else {
                    $button_string = '<a id="follow_box_item_link'.$box_item_id.'" onclick="follow_box_item(\''.$item_id.'\',\''.$box_item_id.'\');"><span>追蹤</span></a>';
                }
            break;
        }
        unset($dbc);
        return($button_string);
    }
    
    function getBoxItemBuyBtn($type,$item_id,$box_item_id){
        $dbc = connectdb();
        $query_exchange_record = mysql_query("SELECT * FROM exchange_record WHERE box_item_id='$box_item_id' AND buyer_id='$this->id' AND status='pending'",$dbc);
        $query_exchange_record_num = mysql_num_rows($query_exchange_record);
        mysql_free_result($query_exchange_record);
        $button_string = '';
        switch ($type){
            case 'small':
                if($query_exchange_record_num>0){
                    $button_string = '<span>已訂購</span>';
                } else {
                    $button_string = '<a id="buy_box_item_link'.$box_item_id.'" onclick="buy_box_item_box(\''.$item_id.'\',\''.$box_item_id.'\');"><span>購買</span></a>';
                }
            break;
        }
        unset($dbc);
        return($button_string);
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->account);
        unset($this->invite_email);
        unset($this->school_id);
        unset($this->school_department_id);
        unset($this->nickname);
        unset($this->email);
        unset($this->birthday);
        unset($this->gender);
        unset($this->firstname);
        unset($this->lastname);
        unset($this->about_me);
        unset($this->icon);
        unset($this->contact_number);
        unset($this->is_deleted);
        unset($this->create_time);
        unset($this->modify_time);
        unset($this->delete_time);
        unset($this->auth_id);
        unset($this->is_verify);
        unset($this->fb_id);
        unset($this->fb_name);
        unset($this->fb_icon);
        unset($this->fb_profile);
        unset($this->fb_access_token);
    }
}
?>