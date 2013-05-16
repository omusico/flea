<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $item_id = $_POST['item_id'];
        $dbc = connectdb();
        if(!empty($item_id)){
         
            mysql_query("UPDATE item SET is_deleted='1',delete_time=NOW() WHERE id='$item_id' LIMIT 1",$dbc);
            $return_info = array(
                        'status' => 'success'
                    );
        } else {
            $return_info = array(
                        'status' => 'empty_para'
                    );
        }
    } else {
        $return_info = array(
                        'status' => 'not_login'
                    );
    }
    echo json_encode($return_info);
?>
