<?
require_once('/var/www/html/flea/flea_src/base_functions.php');
$dbc = connectdb();

$query_item = "SELECT * FROM item WHERE is_deleted!='1'";
$query_box_item_result = mysql_query($query_item, $dbc);
while ($query_box_item_result_data = mysql_fetch_array($query_box_item_result)) {
    $item_obj = new FleaTransactionItem($query_box_item_result_data['id']);
    $owner_obj = new FleaUser($item_obj->owner_id);
    $path_obj = new FleaFilePathProcess($owner_obj->id);
    $item_icon_path = $path_obj->user_item_path.'/'.$item_obj->id;
    echo $item_obj->id.'<br/>';
    if(file_exists($item_icon_path.'.png')){
        echo 'exist '.$item_icon_path.'.png '.'<br/>';
        $item_id = $item_obj->id;
        $subname = '.png';
        
        $icon_name = $item_id.$subname;
        $update_item = "UPDATE item SET icon='$icon_name' WHERE id='$item_id'";
        mysql_query($update_item, $dbc);
        
        $image_process = new FleaImageProcess();
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"18");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"25");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"50");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"75");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"500");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"640");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"1024");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"500");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"640");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"1024");
        
    } else if(file_exists($item_icon_path.'.jpg')) {
        echo 'exist '.$item_icon_path.'.jpg '.'<br/>';
        
        $item_id = $item_obj->id;
        $subname = '.jpg';
        
        $icon_name = $item_id.$subname;
        $update_item = "UPDATE item SET icon='$icon_name' WHERE id='$item_id'";
        mysql_query($update_item, $dbc);
        
        $image_process = new FleaImageProcess();
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"18");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"25");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"50");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"75");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"500");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"640");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"1024");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"500");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"640");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"1024");
        
    } else if(file_exists($item_icon_path.'.gif')) {
        echo 'exist '.$item_icon_path.'.gif '.'<br/>';
        
        $item_id = $item_obj->id;
        $subname = '.gif';
        
        $icon_name = $item_id.$subname;
        $update_item = "UPDATE item SET icon='$icon_name' WHERE id='$item_id'";
        mysql_query($update_item, $dbc);
        
        $image_process = new FleaImageProcess();
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"18");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"25");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"50");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"75");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"500");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"640");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"1024");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"500");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"640");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"1024");
    } else {
        echo 'no exist <br/>';
    }
}


$query_user = "SELECT * FROM user";
$query_user_result = mysql_query($query_user, $dbc);
while ($query_user_result_data = mysql_fetch_array($query_user_result)) {
    $user_obj = new FleaUser($query_user_result_data['id']);
    $occ = strrpos($user_obj->icon,".");
    $subname = substr($user_obj->icon, $occ);
    $path_obj = new FleaFilePathProcess($user_obj->id);
    
    if(!empty($subname)&&$subname!='.c'){
        $image_process = new FleaImageProcess();
        $image_process->createUserIconSquare($path_obj->user_icon_path,$user_obj->id,$subname,"18");
        $image_process->createUserIconSquare($path_obj->user_icon_path,$user_obj->id,$subname,"25");
        $image_process->createUserIconSquare($path_obj->user_icon_path,$user_obj->id,$subname,"50");
        $image_process->createUserIconSquare($path_obj->user_icon_path,$user_obj->id,$subname,"75");
        $image_process->createUserIconSquare($path_obj->user_icon_path,$user_obj->id,$subname,"100");
        $image_process->createUserIconSquare($path_obj->user_icon_path,$user_obj->id,$subname,"150");
        $image_process->createUserIconSquare($path_obj->user_icon_path,$user_obj->id,$subname,"200");
        $image_process->createUserIconSquare($path_obj->user_icon_path,$user_obj->id,$subname,"300");
        $image_process->createUserIconResize($path_obj->user_icon_path,$user_obj->id,$subname,"100");
        $image_process->createUserIconResize($path_obj->user_icon_path,$user_obj->id,$subname,"150");
        $image_process->createUserIconResize($path_obj->user_icon_path,$user_obj->id,$subname,"200");
        $image_process->createUserIconResize($path_obj->user_icon_path,$user_obj->id,$subname,"300");
        $image_process->createUserIconResize($path_obj->user_icon_path,$user_obj->id,$subname,"500");
        $image_process->createUserIconResize($path_obj->user_icon_path,$user_obj->id,$subname,"640");
        $image_process->createUserIconResize($path_obj->user_icon_path,$user_obj->id,$subname,"1024");
        $image_process->createUserIconResizeW($path_obj->user_icon_path,$user_obj->id,$subname,"100");
        $image_process->createUserIconResizeW($path_obj->user_icon_path,$user_obj->id,$subname,"150");
        $image_process->createUserIconResizeW($path_obj->user_icon_path,$user_obj->id,$subname,"200");
        $image_process->createUserIconResizeW($path_obj->user_icon_path,$user_obj->id,$subname,"300");
        $image_process->createUserIconResizeW($path_obj->user_icon_path,$user_obj->id,$subname,"500");
        $image_process->createUserIconResizeW($path_obj->user_icon_path,$user_obj->id,$subname,"640");
        $image_process->createUserIconResizeW($path_obj->user_icon_path,$user_obj->id,$subname,"1024");
        echo $user_obj->id.$subname.' created<br/>';
    }
}

$query_item = "SELECT * FROM special_item WHERE is_deleted!='1'";
$query_box_item_result = mysql_query($query_item, $dbc);
while ($query_box_item_result_data = mysql_fetch_array($query_box_item_result)) {
    $sitem_id = $query_box_item_result_data['id'];
    $item_icon_path = SITE_DATA_SPECIALITEM_DOC.'/'.$sitem_id;
    echo $sitem_id.'<br/>';
    if(file_exists($item_icon_path.'.png')){
        echo 'exist '.$item_icon_path.'.png '.'<br/>';
        $subname = '.png';
        
        $icon_name = $sitem_id.$subname;
        $update_item = "UPDATE special_item SET icon='$icon_name' WHERE id='$sitem_id'";
        mysql_query($update_item, $dbc);
        
        $image_process = new FleaImageProcess();
        $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"18");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"25");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"50");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"75");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"100");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"150");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"200");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"300");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"100");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"150");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"200");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"300");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"500");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"640");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"1024");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"100");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"150");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"200");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"300");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"500");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"640");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"1024");
        
    } else if(file_exists($item_icon_path.'.jpg')) {
        echo 'exist '.$item_icon_path.'.jpg '.'<br/>';
        $subname = '.jpg';
        
        $icon_name = $sitem_id.$subname;
        $update_item = "UPDATE special_item SET icon='$icon_name' WHERE id='$sitem_id'";
        mysql_query($update_item, $dbc);
        
        $image_process = new FleaImageProcess();
        $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"18");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"25");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"50");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"75");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"100");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"150");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"200");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"300");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"100");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"150");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"200");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"300");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"500");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"640");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"1024");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"100");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"150");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"200");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"300");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"500");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"640");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"1024");
        
    } else if(file_exists($item_icon_path.'.gif')) {
        echo 'exist '.$item_icon_path.'.gif '.'<br/>';
        $subname = '.gif';
        
        $icon_name = $sitem_id.$subname;
        $update_item = "UPDATE special_item SET icon='$icon_name' WHERE id='$sitem_id'";
        mysql_query($update_item, $dbc);
        
        $image_process = new FleaImageProcess();
        $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"18");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"25");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"50");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"75");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"100");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"150");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"200");
            $image_process->createSItemIconSquare(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"300");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"100");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"150");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"200");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"300");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"500");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"640");
            $image_process->createSItemIconResize(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"1024");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"100");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"150");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"200");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"300");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"500");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"640");
            $image_process->createSItemIconResizeW(SITE_DATA_SPECIALITEM_DOC,$sitem_id,$subname,"1024");
    } else {
        echo 'no exist <br/>';
    }
}
?>