<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
     if(!empty($_COOKIE['user_id'])){
        $user_obj = new FleaUser($_COOKIE['user_id']);
        if($user_obj->auth_id>=90){
            
            $sitem_id = $_POST['sitem_id'];
            $sitem_title = addslashes($_POST['sitem_title']);
            $sitem_content = addslashes($_POST['sitem_content']);
            $scategory_id = $_POST['scategory_id'];
            
            $dbc = connectdb();
            
            $update_sitem = "UPDATE special_item SET ".
                                "title='$sitem_title',description='$sitem_content',special_category_id='$scategory_id',is_released='1',".
                                "update_time=NOW() WHERE id='$sitem_id' LIMIT 1";
            mysql_query($update_sitem, $dbc);

            $return_info = array(
                            'status' => 'success'
                        );
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
