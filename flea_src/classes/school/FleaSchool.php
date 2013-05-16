<?php
class FleaSchool {
    //成員函數
    var $id;
    var $title;
    var $description;
    var $ordernum;
    var $address;
    var $website;
    var $domain;
    var $is_deleted;
    var $create_time;
    var $update_time;
    var $delete_time;

    //建構子
    function __construct($input_school_key,$type='id'){
        $dbc = connectdb();
        switch($type){
            case 'id':
                $query_school = mysql_query("SELECT * FROM school WHERE id='$input_school_key' LIMIT 1",$dbc);
                while ($query_school_data = mysql_fetch_array($query_school)) {
                    $this->id = $query_school_data['id'];
                    $this->title = $query_school_data['title'];
                    $this->description = $query_school_data['description'];
                    $this->ordernum = $query_school_data['ordernum'];
                    $this->address = $query_school_data['address'];
                    $this->website = $query_school_data['website'];
                    $this->domain = $query_school_data['domain'];
                    $this->is_deleted = $query_school_data['is_deleted'];
                    $this->create_time = $query_school_data['create_time'];
                    $this->update_time = $query_school_data['update_time'];
                    $this->delete_time = $query_school_data['delete_time'];
                }
                /* free result set */
                mysql_free_result($query_school);
            break;
            case 'domain':
                $query_school = mysql_query("SELECT * FROM school WHERE domain='$input_school_key' LIMIT 1",$dbc);
                while ($query_school_data = mysql_fetch_array($query_school)) {
                    $this->id = $query_school_data['id'];
                    $this->title = $query_school_data['title'];
                    $this->description = $query_school_data['description'];
                    $this->ordernum = $query_school_data['ordernum'];
                    $this->address = $query_school_data['address'];
                    $this->website = $query_school_data['website'];
                    $this->domain = $query_school_data['domain'];
                    $this->is_deleted = $query_school_data['is_deleted'];
                    $this->create_time = $query_school_data['create_time'];
                    $this->update_time = $query_school_data['update_time'];
                    $this->delete_time = $query_school_data['delete_time'];
                }
                /* free result set */
                mysql_free_result($query_school);
            break;
        }
        unset($dbc);
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->title);
        unset($this->description);
        unset($this->ordernum);
        unset($this->address);
        unset($this->website);
        unset($this->domain);
        unset($this->is_deleted);
        unset($this->create_time);
        unset($this->modify_time);
        unset($this->delete_time);
    }
}
?>