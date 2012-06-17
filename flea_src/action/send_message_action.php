<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $user_obj = new FleaUser($_COOKIE['user_id']);
        $receiver_id = $_POST['receiver_id'];
        $message_title = addslashes($_POST['message_title']);
        $message_content = addslashes($_POST['message_content']);
        
        $dbc = connectdb();
      
        $query_message_in = "INSERT INTO message (sender_id,receiver_id,title,content,send_time,new_reply_time) ".
                                "VALUES('$user_obj->id','$receiver_id','$message_title','$message_content',NOW(),NOW())";
        
        mysql_query($query_message_in, $dbc);
        
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
