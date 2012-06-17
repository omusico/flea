<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $user_obj = new FleaUser($_COOKIE['user_id']);
        $path_obj = new FleaFilePathProcess($user_obj->id);

        $upload_item_name = $_SERVER['HTTP_X_FILE_NAME'];
        $upload_item_icon = file_get_contents("php://input");
        $occ = strrpos($upload_item_name,".");
        $subname = substr($upload_item_name, $occ);
        
        $dbc = connectdb();
        $insert_item = "INSERT INTO item (owner_id,title,content,price,quantity,method_id,category_id,subcategory_id,school_id,school_location_id,create_time,update_time) ".
                            "VALUES('$user_obj->id','尚未填寫品名','尚未填寫商品描述','0','1','1','0','0','$user_obj->school_id','0',NOW(),NOW())";
        mysql_query($insert_item, $dbc);
        $item_id = mysql_insert_id($dbc);
        
        
        
        file_put_contents($path_obj->user_item_path.'/'.$item_id.$subname,$upload_item_icon);
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
        
        $icon_name = $item_id.$subname;
        $update_item = "UPDATE item SET icon='$icon_name' WHERE id='$item_id'";
        mysql_query($update_item, $dbc);

    } else {

    }
?>