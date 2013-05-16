<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $follow_id = $_POST['follow_id'];

        $dbc = connectdb();
        $update_follow_item = "UPDATE follow_item SET is_deleted='1',delete_time=NOW() WHERE id='$follow_id'";
        mysql_query($update_follow_item, $dbc);
        
        unset($dbc);
        
        $return_info = array(
                        'status' => 'success'
                    );
    } else {
        $return_info = array(
                        'status' => 'not_login'
                    );
    }
    echo json_encode($return_info);
?>
