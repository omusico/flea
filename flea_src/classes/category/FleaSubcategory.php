<?php
class FleaSubcategory {
    //成員函數
    var $id;
    var $category_id;
    var $title;
    var $description;
    var $ordernum;
    var $is_deleted;
    var $create_time;
    var $update_time;
    var $delete_time;

    //建構子
    function __construct($input_subcategory_key){
        $dbc = connectdb();
        $query_subcategory = mysql_query("SELECT * FROM subcategory WHERE id='$input_subcategory_key' LIMIT 1",$dbc);
        while ($query_subcategory_data = mysql_fetch_array($query_subcategory)) {
            $this->id = $query_subcategory_data['id'];
            $this->category_id = $query_subcategory_data['category_id'];
            $this->title = $query_subcategory_data['title'];
            $this->description = $query_subcategory_data['description'];
            $this->ordernum = $query_subcategory_data['ordernum'];
            $this->is_deleted = $query_subcategory_data['is_deleted'];
            $this->create_time = $query_subcategory_data['create_time'];
            $this->update_time = $query_subcategory_data['update_time'];
            $this->delete_time = $query_subcategory_data['delete_time'];
        }
        /* free result set */
        mysql_free_result($query_subcategory);
        unset($dbc);
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->title);
        unset($this->category_id);
        unset($this->description);
        unset($this->ordernum);
        unset($this->is_deleted);
        unset($this->create_time);
        unset($this->modify_time);
        unset($this->delete_time);
    }
}
?>