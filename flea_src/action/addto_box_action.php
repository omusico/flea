<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $user_obj = new FleaUser($_COOKIE['user_id']);
        $box_id = $_POST['box_id'];
        $item_id = $_POST['item_id'];
        $type = $_POST['type'];
        $dbc = connectdb();
        
        
        if(!empty($item_id)&&!empty($type)){
            $box_item_obj = '';
            if($type=='normal'){
                $box_item_obj = new FleaTransactionItem($item_id);
            } else {
                $box_item_obj = new FleaSpecialItem($item_id);
            }
            
            $query_boxitem_in = "INSERT INTO box_item (box_id,item_id,owner_id,type,status,create_time,update_time) ".
                                    "VALUES('$box_id','$item_id','$user_obj->id','$type','for_sale',NOW(),NOW())";
            mysql_query($query_boxitem_in, $dbc);
            $this_boxitem_id = mysql_insert_id();
            $return_info = array(
                        'status' => 'success',
                        'boxitem_id' => $this_boxitem_id,
                        'item_title' => $box_item_obj->title
                    );
            unset($box_item_obj);
        } else {
            $return_info = array(
                        'status' => 'fail'
                    );
        }
    } else {
        $return_info = array(
                        'status' => 'not_login'
                    );
    }
    echo json_encode($return_info);
?>
