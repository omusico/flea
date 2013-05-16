<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $user_obj = new FleaUser($_COOKIE['user_id']);
        $item_id = $_POST['item_id'];
        $box_item_id = $_POST['box_item_id'];
        $dbc = connectdb();
        
        
        if(!empty($item_id)&&!empty($box_item_id)){
            
            $query_box_item_follow = mysql_query("SELECT * FROM follow_item WHERE box_item_id='$box_item_id' AND follower_id='$user_obj->id' ",$dbc);
            $query_box_item_follow_num = mysql_num_rows($query_box_item_follow);
            mysql_free_result($query_box_item_follow);
            if($query_box_item_follow_num==0){
                
                $item_obj = new FleaTransactionItem($item_id);
                $owner_obj = new FleaUser($item_obj->owner_id);
                
                if($owner_obj->id==$user_obj->id){
                    $return_info = array(
                            'status' => 'follow_self_error'
                        );
                
                } else {
                    $query_follow_boxitem_in = "INSERT INTO follow_item (follower_id,item_id,box_item_id,create_time) ".
                                                "VALUES('$user_obj->id','$item_id','$box_item_id',NOW())";
                    mysql_query($query_follow_boxitem_in, $dbc);

                    $message_title = addslashes($user_obj->nickname . '已追蹤您的「' . $item_obj->title . '」');
                    $message_content = addslashes($user_obj->nickname . '已追蹤您的「' . $item_obj->title . '」，或許他會買您的商品喔!');
                    $query_message_in = "INSERT INTO message (sender_id,receiver_id,title,content,send_time,new_reply_time) ".
                                                "VALUES('$user_obj->id','$owner_obj->id','$message_title','$message_content',NOW(),NOW())";
                    mysql_query($query_message_in, $dbc);
                    
                    $param = "owner_name=".$owner_obj->nickname."&viewer_name=".$user_obj->nickname."&item_name=".$item_obj->title;
                    $mail_obj = new FleaMail('follow_box_item',$owner_obj->nickname,$owner_obj->email);
                    $mail_obj->send_mail($param);
                    unset($mail_obj);
                    
                    $return_info = array(
                            'status' => 'success'
                        );
                }
                
                unset($item_obj);
                unset($owner_obj);
                
                
                
            } else {
                $return_info = array(
                            'status' => 'exist'
                        );
            }
            
            

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
