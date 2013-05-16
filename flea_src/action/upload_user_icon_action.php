<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $user_obj = new FleaUser($_COOKIE['user_id']);
        $path_obj = new FleaFilePathProcess($user_obj->id);
        foreach (glob($path_obj->user_icon_path."/".$user_obj->id."*.*") as $user_icon){
            unlink($user_icon);
        }

        $upload_icon_name = $_SERVER['HTTP_X_FILE_NAME'];
        $upload_icon = file_get_contents("php://input");
        $occ = strrpos($upload_icon_name,".");
        $subname = substr($upload_icon_name, $occ);
        
        
        
        file_put_contents($path_obj->user_icon_path.'/'.$user_obj->id.$subname,$upload_icon);
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
        
        $icon_file_name = $user_obj->id.$subname;
        $dbc = connectdb();
        $update_user = "UPDATE user SET icon='$icon_file_name' WHERE id='$user_obj->id'";
        mysql_query($update_user, $dbc);
    } else {

    }
?>