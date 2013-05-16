<?php
class FleaBox {
    //成員函數
    var $id;
    var $owner_id;
    var $title;
    var $content;
    var $box_cover;
    var $is_released;
    var $is_deleted;
    var $create_time;
    var $update_time;
    var $delete_time;

    //建構子
    function __construct($input_box_key){
        $dbc = connectdb();
        $query_box = mysql_query("SELECT * FROM box WHERE id='$input_box_key' LIMIT 1",$dbc);
        while ($query_box_data = mysql_fetch_array($query_box)) {
            $this->id = $query_box_data['id'];
            $this->owner_id = $query_box_data['owner_id'];
            $this->title = $query_box_data['title'];
            if($this->title=='福利格子尚未命名'){
                $owner_obj = new FleaUser($this->owner_id);
                $this->title = "福利格子 ".$owner_obj->account;
            }
            $this->content = $query_box_data['content'];
            $this->box_cover = $query_box_data['box_cover'];
            $this->is_released = $query_box_data['is_released'];
            $this->is_deleted = $query_box_data['is_deleted'];
            $this->create_time = $query_box_data['create_time'];
            $this->update_time = $query_box_data['update_time'];
            $this->delete_time = $query_box_data['delete_time'];
        }
        /* free result set */
        mysql_free_result($query_box);
        unset($dbc);
    }
    
    function getBoxCover($size='50'){
        $path_obj = new FleaFilePathProcess($this->owner_id);
        if(!empty($this->box_cover)){
            $occ = strrpos($this->box_cover,".");
            $subname = substr($this->box_cover, $occ);
            if($size=='0'){
                $cover_link = $path_obj->user_box_url.'/'.$this->id.$subname;
            } else {
                $cover_link = $path_obj->user_box_url.'/'.$this->id.'_'.$size."s".$subname;
            }
        } else {
            if($size=='0'){
                $cover_link = SITE_URL."/images/noboxpic/nopboxic.png";
            } else {
                $cover_link = SITE_URL.'/images/noboxpic/noboxpic_'.$size."s.png";
            }
        }
        return $cover_link;
    }
    
    function getBoxCoverR($size='50'){
        $path_obj = new FleaFilePathProcess($this->owner_id);
        if(!empty($this->box_cover)){
            $occ = strrpos($this->box_cover,".");
            $subname = substr($this->box_cover, $occ);
            if($size=='0'){
                $cover_link = $path_obj->user_box_url.'/'.$this->id.$subname;
            } else {
                $cover_link = $path_obj->user_box_url.'/'.$this->id.'_'.$size."r".$subname;
            }
        } else {
            if($size=='0'){
                $cover_link = SITE_URL."/images/noboxpic/noboxpic.png";
            } else {
                $cover_link = SITE_URL.'/images/noboxpic/noboxpic_'.$size."r.png";
            }
        }
        return $cover_link;
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->owner_id);
        unset($this->title);
        unset($this->content);
        unset($this->box_cover);
        unset($this->is_released);
        unset($this->is_deleted);
        unset($this->create_time);
        unset($this->modify_time);
        unset($this->delete_time);
    }
}
?>