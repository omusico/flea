<?php
class FleaSpecialItem {
    //成員函數
    var $id;
    var $title;
    var $description;
    var $icon;
    var $special_category_id;
    var $subcategory_id;
    var $is_released;
    var $is_deleted;
    var $create_time;
    var $update_time;
    var $delete_time;

    //建構子
    function __construct($input_item_key){
        $dbc = connectdb();
        $query_item = mysql_query("SELECT * FROM special_item WHERE id='$input_item_key' LIMIT 1",$dbc);
        while ($query_item_data = mysql_fetch_array($query_item)) {
            $this->id = $query_item_data['id'];
            $this->title = $query_item_data['title'];
            $this->description = $query_item_data['description'];
            $this->icon = $query_item_data['icon'];
            $this->category_id = $query_item_data['special_category_id'];
            $this->is_released = $query_item_data['is_released'];
            $this->is_deleted = $query_item_data['is_deleted'];
            $this->create_time = $query_item_data['create_time'];
            $this->update_time = $query_item_data['update_time'];
            $this->delete_time = $query_item_data['delete_time'];
        }
        /* free result set */
        mysql_free_result($query_item);
        unset($dbc);
    }
    
    function getItemIcon($size='50'){
        $icon_link = SITE_DATA_SPECIALITEM_URL.'/'.$this->id.'_'.$size."s.png";
        return $icon_link;
    }
    
    function getItemIconR($size='100'){
        $icon_link = SITE_DATA_SPECIALITEM_URL.'/'.$this->id.'_'.$size."r.png";
        return $icon_link;
    }
    
    function getItemIconRW($size='100'){
        $icon_link = SITE_DATA_SPECIALITEM_URL.'/'.$this->id.'_'.$size."w.png";
        return $icon_link;
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->title);
        unset($this->description);
        unset($this->icon);
        unset($this->special_category_id);
        unset($this->is_released);
        unset($this->is_deleted);
        unset($this->create_time);
        unset($this->modify_time);
        unset($this->delete_time);
    }
}
?>