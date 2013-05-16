<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $exchange_id = $_POST['exchange_id'];
        $exchange_obj = new FleaExchangeRecord($exchange_id);
        $dbc = connectdb();
        $update_box_item = "UPDATE box_item SET status='paid',update_time=NOW() WHERE id='$exchange_obj->box_item_id'";
        mysql_query($update_box_item, $dbc);
        $update_exchange = "UPDATE exchange_record SET status='paid',paid_time=NOW() WHERE id='$exchange_obj->id'";
        mysql_query($update_exchange, $dbc);
        
        unset($dbc);
        unset($exchange_obj);
        
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
