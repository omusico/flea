<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $user_obj = new FleaUser($_COOKIE['user_id']);
        $message_id = $_POST['message_id'];
        $content = $_POST['content'];
        $message_obj = new FleaMessage($message_id);
        $dbc = connectdb();
        $query_remassage_in = "INSERT INTO reply_message (message_id,sender_id,receiver_id,content,send_time) ".
                                    "VALUES('$message_id','$user_obj->id','$message_obj->sender_id','$content',NOW())";
        mysql_query($query_remassage_in, $dbc);
        $update_message = "UPDATE message SET is_receiver_readed='0',is_sender_readed='0',new_reply_time=NOW() WHERE id='$message_obj->id'";
        mysql_query($update_message, $dbc);
        
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
