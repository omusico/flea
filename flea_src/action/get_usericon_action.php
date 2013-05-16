<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $icon_size = '200';
        if(isset($_GET['size'])){
            $icon_size = $_GET['size'];
        }
        $user_obj = new FleaUser($_COOKIE['user_id']);
        $user_icon = $user_obj->getUserIcon($icon_size).'?'.time();
        $return_info = array(
                        'status' => 'success',
                        'user_icon' => $user_icon
                    );
    } else {
        $return_info = array(
                        'status' => 'not_login'
                    );
    }
    
    echo json_encode($return_info);
?>
