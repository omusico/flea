<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $boxitem_id = $_POST['boxitem_id'];
        $dbc = connectdb();
        if(!empty($boxitem_id)){
         
            $query_box_item = "SELECT item_id,type FROM box_item WHERE id='$boxitem_id'";
            $query_box_item_result = mysql_query($query_box_item, $dbc);
            while ($query_box_item_result_data = mysql_fetch_array($query_box_item_result)) {
                $box_item_obj = '';
                $item_type = '';
                if($query_box_item_result_data['type']=='normal'){
                    $box_item_obj = new FleaTransactionItem($query_box_item_result_data['item_id']);
                    $item_type = 'nitem';
                } else {
                    $box_item_obj = new FleaSpecialItem($query_box_item_result_data['item_id']);
                    $item_type = 'sitem';
                }
            }
            mysql_free_result($query_box_item_result);
         
            mysql_query("UPDATE box_item SET status='is_deleted',delete_time=NOW() WHERE id='$boxitem_id' LIMIT 1",$dbc);
            $return_info = array(
                        'status' => 'success',
                        'item_id' =>$box_item_obj->id,
                        'item_src' =>$box_item_obj->getItemIconR('100'),
                        'item_type' =>$item_type
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
