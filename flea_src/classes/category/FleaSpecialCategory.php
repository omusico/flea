<?php
class FleaSpecialCategory {
    //成員函數
    var $id;
    var $title;
    var $description;
    var $ordernum;
    var $is_deleted;
    var $create_time;
    var $update_time;
    var $delete_time;

    //建構子
    function __construct($input_category_key){
        $dbc = connectdb();
        $query_category = mysql_query("SELECT * FROM special_category WHERE id='$input_category_key' LIMIT 1",$dbc);
        while ($query_category_data = mysql_fetch_array($query_category)) {
            $this->id = $query_category_data['id'];
            $this->title = $query_category_data['title'];
            $this->description = $query_category_data['description'];
            $this->ordernum = $query_category_data['ordernum'];
            $this->is_deleted = $query_category_data['is_deleted'];
            $this->create_time = $query_category_data['create_time'];
            $this->update_time = $query_category_data['update_time'];
            $this->delete_time = $query_category_data['delete_time'];
        }
        /* free result set */
        mysql_free_result($query_category);
        unset($dbc);
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->title);
        unset($this->description);
        unset($this->ordernum);
        unset($this->is_deleted);
        unset($this->create_time);
        unset($this->modify_time);
        unset($this->delete_time);
    }
}
?>