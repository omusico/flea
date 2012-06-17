<?php
class FleaSchoolDepartmentGroup {
    //成員函數
    var $id;
    var $school_id;
    var $title;
    var $description;
    var $ordernum;
    var $website;
    var $is_deleted;
    var $create_time;
    var $update_time;
    var $delete_time;

    //建構子
    function __construct($input_department_group_key){
        $dbc = connectdb();
        $query_school = mysql_query("SELECT * FROM school_department_group WHERE id='$input_department_group_key' LIMIT 1",$dbc);
        while ($query_school_data = mysql_fetch_array($query_school)) {
            $this->id = $query_school_data['id'];
            $this->school_id = $query_school_data['school_id'];
            $this->title = $query_school_data['title'];
            $this->description = $query_school_data['description'];
            $this->ordernum = $query_school_data['ordernum'];
            $this->website = $query_school_data['website'];
            $this->is_deleted = $query_school_data['is_deleted'];
            $this->create_time = $query_school_data['create_time'];
            $this->update_time = $query_school_data['update_time'];
            $this->delete_time = $query_school_data['delete_time'];
        }
        /* free result set */
        mysql_free_result($query_school);
        unset($dbc);
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->school_id);
        unset($this->title);
        unset($this->description);
        unset($this->ordernum);
        unset($this->website);
        unset($this->is_deleted);
        unset($this->create_time);
        unset($this->modify_time);
        unset($this->delete_time);
    }
}
?>