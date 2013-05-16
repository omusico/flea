<?php
class FleaSchoolLocation {
    //成員函數
    var $id;
    var $school_id;
    var $title;
    var $description;
    var $ordernum;
    var $address;
    var $is_deleted;
    var $create_time;
    var $update_time;
    var $delete_time;

    //建構子
    function __construct($input_schoollocation_key){
        $dbc = connectdb();
        $query_school_location = mysql_query("SELECT * FROM school_location WHERE id='$input_schoollocation_key' LIMIT 1",$dbc);
        while ($query_query_school_location_data = mysql_fetch_array($query_school_location)) {
            $this->id = $query_query_school_location_data['id'];
            $this->school_id = $query_query_school_location_data['school_id'];
            $this->title = $query_query_school_location_data['title'];
            $this->description = $query_query_school_location_data['description'];
            $this->ordernum = $query_query_school_location_data['ordernum'];
            $this->address = $query_query_school_location_data['address'];
            $this->is_deleted = $query_query_school_location_data['is_deleted'];
            $this->create_time = $query_query_school_location_data['create_time'];
            $this->update_time = $query_query_school_location_data['update_time'];
            $this->delete_time = $query_query_school_location_data['delete_time'];
        }
        /* free result set */
        mysql_free_result($query_school_location);
        unset($dbc);
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->school_id);
        unset($this->title);
        unset($this->category_id);
        unset($this->description);
        unset($this->ordernum);
        unset($this->address);
        unset($this->is_deleted);
        unset($this->create_time);
        unset($this->modify_time);
        unset($this->delete_time);
    }
}
?>