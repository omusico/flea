<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $icon_size = '200';
        if(isset($_GET['size'])){
            $icon_size = $_GET['size'];
        }
        $box_id = $_GET['box_id'];
        $box_obj = new FleaBox($box_id);
        $box_cover = $box_obj->getBoxCoverR($icon_size).'?'.time();
        $return_info = array(
                        'status' => 'success',
                        'box_cover' => $box_cover
                    );
    } else {
        $return_info = array(
                        'status' => 'not_login'
                    );
    }
    
    echo json_encode($return_info);
?>
