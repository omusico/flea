<?php
class FleaBoxItem {
    //成員函數
    var $id;
    var $box_id;
    var $item_id;
    var $owner_id;
    var $type;
    var $status;
    var $top;
    var $left;
    var $height;
    var $width;
    var $zindex;
    var $create_time;
    var $update_time;
    var $delete_time;

    //建構子
    function __construct($input_boxitem_key){
        $dbc = connectdb();
        $query_box_item = mysql_query("SELECT * FROM box_item WHERE id='$input_boxitem_key' LIMIT 1",$dbc);
        while ($query_box_item_data = mysql_fetch_array($query_box_item)) {
            $this->id = $query_box_item_data['id'];
            $this->box_id = $query_box_item_data['box_id'];
            $this->item_id = $query_box_item_data['item_id'];
            $this->owner_id = $query_box_item_data['owner_id'];
            $this->type = $query_box_item_data['type'];
            $this->status = $query_box_item_data['status'];
            $this->top = $query_box_item_data['top'];
            $this->left = $query_box_item_data['left'];
            $this->height = $query_box_item_data['height'];
            $this->width = $query_box_item_data['width'];
            $this->zindex = $query_box_item_data['z-index'];
            $this->create_time = $query_box_item_data['create_time'];
            $this->update_time = $query_box_item_data['update_time'];
            $this->delete_time = $query_box_item_data['delete_time'];
        }
        /* free result set */
        mysql_free_result($query_box_item);
        unset($dbc);
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->box_id);
        unset($this->item_id);
        unset($this->owner_id);
        unset($this->type);
        unset($this->status);
        unset($this->top);
        unset($this->left);
        unset($this->height);
        unset($this->width);
        unset($this->zindex);
        unset($this->create_time);
        unset($this->update_time);
        unset($this->delete_time);
    }
}
?>