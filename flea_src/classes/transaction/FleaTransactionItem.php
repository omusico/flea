<?php
class FleaTransactionItem {
    //成員函數
    var $id;
    var $owner_id;
    var $title;
    var $content;
    var $icon;
    var $price;
    var $quantity;
    var $method_id;
    var $category_id;
    var $subcategory_id;
    var $school_id;
    var $school_location_id;
    var $is_released;
    var $is_deleted;
    var $create_time;
    var $update_time;
    var $delete_time;

    //建構子
    function __construct($input_item_key){
        $dbc = connectdb();
        $query_item = mysql_query("SELECT * FROM item WHERE id='$input_item_key' LIMIT 1",$dbc);
        while ($query_item_data = mysql_fetch_array($query_item)) {
            $this->id = $query_item_data['id'];
            $this->owner_id = $query_item_data['owner_id'];
            $this->title = $query_item_data['title'];
            $this->content = $query_item_data['content'];
            $this->icon = $query_item_data['icon'];
            $this->price = $query_item_data['price'];
            $this->quantity = $query_item_data['quantity'];
            $this->method_id = $query_item_data['method_id'];
            $this->category_id = $query_item_data['category_id'];
            $this->subcategory_id = $query_item_data['subcategory_id'];
            $this->school_id = $query_item_data['school_id'];
            $this->school_location_id = $query_item_data['school_location_id'];
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
        $path_obj = new FleaFilePathProcess($this->owner_id);
        $icon_link = $path_obj->user_item_url.'/'.$this->id.'_'.$size."s.png";
        return $icon_link;
    }
    
    function getItemIconR($size='100'){
        $path_obj = new FleaFilePathProcess($this->owner_id);
        $icon_link = $path_obj->user_item_url.'/'.$this->id.'_'.$size."r.png";
        return $icon_link;
    }
    
    function getItemIconRW($size='100'){
        $path_obj = new FleaFilePathProcess($this->owner_id);
        $icon_link = $path_obj->user_item_url.'/'.$this->id.'_'.$size."w.png";
        return $icon_link;
    }
    
    function getItemIconSmart($size='100'){
        $path_obj = new FleaFilePathProcess($this->owner_id);
        $icon_path = $path_obj->user_item_path.'/'.$this->icon;
        list($width, $height, $type, $attr)=getimagesize($icon_path);
        
        $icon_link = '';
        if($height>$width){
            $icon_link = $this->getItemIconR($size);
        } else {
            $icon_link = $this->getItemIconRW($size);
        }
        return $icon_link;
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->owner_id);
        unset($this->title);
        unset($this->content);
        unset($this->icon);
        unset($this->price);
        unset($this->quantity);
        unset($this->method_id);
        unset($this->category_id);
        unset($this->subcategory_id);
        unset($this->school_id);
        unset($this->school_location_id);
        unset($this->is_released);
        unset($this->is_deleted);
        unset($this->create_time);
        unset($this->update_time);
        unset($this->delete_time);
    }
}
?>