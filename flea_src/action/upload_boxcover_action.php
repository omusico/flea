<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])&&!empty($_COOKIE['edit_box_id'])){
        if (isset($GLOBALS["HTTP_RAW_POST_DATA"]))
        {
            $user_obj = new FleaUser($_COOKIE['user_id']);
            $path_obj = new FleaFilePathProcess($user_obj->id);
            $box_id = $_COOKIE['edit_box_id'];
            // Get the data
            $imageData=$GLOBALS['HTTP_RAW_POST_DATA'];

            // Remove the headers (data:,) part.  
            // A real application should use them according to needs such as to check image type
            $filteredData=substr($imageData, strpos($imageData, ",")+1);

            // Need to decode before saving since the data we received is already base64 encoded
            $unencodedData=base64_decode($filteredData);

            //echo "unencodedData".$unencodedData;

            // Save file.  This example uses a hard coded filename for testing, 
            // but a real application can specify filename in POST variable
            $fp = fopen($path_obj->user_box_path.'/'.$box_id.'.jpg', 'wb' );
            fwrite( $fp, $unencodedData);
            fclose( $fp );
            
            $image_process = new FleaImageProcess();
            $image_process->createBoxCoverSquare($path_obj->user_box_path,$box_id,'.jpg',"18");
            $image_process->createBoxCoverSquare($path_obj->user_box_path,$box_id,'.jpg',"25");
            $image_process->createBoxCoverSquare($path_obj->user_box_path,$box_id,'.jpg',"50");
            $image_process->createBoxCoverSquare($path_obj->user_box_path,$box_id,'.jpg',"75");
            $image_process->createBoxCoverSquare($path_obj->user_box_path,$box_id,'.jpg',"100");
            $image_process->createBoxCoverSquare($path_obj->user_box_path,$box_id,'.jpg',"150");
            $image_process->createBoxCoverSquare($path_obj->user_box_path,$box_id,'.jpg',"200");
            $image_process->createBoxCoverSquare($path_obj->user_box_path,$box_id,'.jpg',"300");
            $image_process->createBoxCoverResize($path_obj->user_box_path,$box_id,'.jpg',"100");
            $image_process->createBoxCoverResize($path_obj->user_box_path,$box_id,'.jpg',"150");
            $image_process->createBoxCoverResize($path_obj->user_box_path,$box_id,'.jpg',"200");
            $image_process->createBoxCoverResize($path_obj->user_box_path,$box_id,'.jpg',"300");
            $image_process->createBoxCoverResize($path_obj->user_box_path,$box_id,'.jpg',"500");
            $image_process->createBoxCoverResize($path_obj->user_box_path,$box_id,'.jpg',"570");
            $image_process->createBoxCoverResize($path_obj->user_box_path,$box_id,'.jpg',"640");
            $image_process->createBoxCoverResize($path_obj->user_box_path,$box_id,'.jpg',"1024");
            
            $icon_file_name = $box_id.'.jpg';
            $dbc = connectdb();
            $update_box = "UPDATE box SET box_cover='$icon_file_name', is_released='1', update_time=NOW() WHERE id='$box_id' LIMIT 1";
            mysql_query($update_box, $dbc);
            unset($user_obj);
            unset($dbc);
            
            $return_info = array(
                        'status' => 'success',
                        'box_id' => $box_id
                    );
        } else {
            $return_info = array(
                        'status' => 'error'
                    );
        }
    } else {
        $return_info = array(
                        'status' => 'not_login'
                    );
    }
    echo json_encode($return_info);
?>