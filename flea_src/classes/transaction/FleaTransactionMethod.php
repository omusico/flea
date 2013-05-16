<?php
class FleaTransactionMethod {
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
    function __construct($input_method_key){
        $dbc = connectdb();
        $query_method = mysql_query("SELECT * FROM method WHERE id='$input_method_key' LIMIT 1",$dbc);
        while ($query_method_data = mysql_fetch_array($query_method)) {
            $this->id = $query_method_data['id'];
            $this->title = $query_method_data['title'];
            $this->description = $query_method_data['description'];
            $this->ordernum = $query_method_data['ordernum'];
            $this->is_deleted = $query_method_data['is_deleted'];
            $this->create_time = $query_method_data['create_time'];
            $this->update_time = $query_method_data['update_time'];
            $this->delete_time = $query_method_data['delete_time'];
        }
        /* free result set */
        mysql_free_result($query_method);
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