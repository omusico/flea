<?php
    if(!empty($_COOKIE['user_id'])){ 
        require_once('/var/www/html/flea/flea_src/base_functions.php');
        $user_obj = new FleaUser($_COOKIE['user_id']);
        if($user_obj->auth_id>=90){

            $upload_sitem_name = $_SERVER['HTTP_X_FILE_NAME'];
            $upload_sitem_icon = file_get_contents("php://input");
            $occ = strrpos($upload_sitem_name,".");
            $subname = substr($upload_sitem_name, $occ);
            
            $dbc = connectdb();
            $insert_sitem = "INSERT INTO special_item (title,description,special_category_id,create_time,update_time) ".
                                "VALUES('尚未填寫元件名稱','尚未填寫元件描述','0',NOW(),NOW())";
            mysql_query($insert_sitem, $dbc);
            $sitem_id = mysql_insert_id($dbc);
            
            
            file_put_contents(SITE_DATA_SPECIALITEM_DOC.'/'.$sitem_id.$subname,$upload_sitem_icon);
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

            $icon_name = $sitem_id.$subname;
            $update_item = "UPDATE special_item SET icon='$icon_name' WHERE id='$sitem_id'";
            mysql_query($update_item, $dbc);
        } else {

        }
    } else {
    
    }
?>