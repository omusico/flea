<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $user_obj = new FleaUser($_COOKIE['user_id']);
        if($user_obj->auth_id>=90){
            $sitem_id = $_POST['sitem_id'];
            $dbc = connectdb();
            if(!empty($sitem_id)){
             
                mysql_query("UPDATE special_item SET is_deleted='1',delete_time=NOW() WHERE id='$sitem_id' LIMIT 1",$dbc);
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
                        'status' => 'not_auth'
                    );
        }
    } else {
        $return_info = array(
                        'status' => 'not_login'
                    );
    }
    echo json_encode($return_info);
?>
