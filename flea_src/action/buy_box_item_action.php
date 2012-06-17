<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $user_obj = new FleaUser($_COOKIE['user_id']);
        $item_id = $_POST['item_id'];
        $box_item_id = $_POST['box_item_id'];
        $contact_name = $_POST['contact_name'];
        $contact_number = $_POST['contact_number'];
        $message_content = $_POST['message_content'];
        $dbc = connectdb();
        
        
        if(!empty($item_id)&&!empty($box_item_id)){
            
            $query_box_item_buy = mysql_query("SELECT * FROM exchange_record WHERE box_item_id='$box_item_id'",$dbc);
            $query_box_item_buy_num = mysql_num_rows($query_box_item_buy);
            mysql_free_result($query_box_item_buy);
            if($query_box_item_buy_num==0){
                
                $item_obj = new FleaTransactionItem($item_id);
                $owner_obj = new FleaUser($item_obj->owner_id);
                
                if($owner_obj->id==$user_obj->id){
                    $return_info = array(
                            'status' => 'buy_self_error'
                        );
                
                } else {
                    $box_item_obj = new FleaBoxItem($box_item_id);
                    if($box_item_obj->status=='pending' || $box_item_obj->status=='paid'){
                        $return_info = array(
                                'status' => 'buyed'
                            );
                    } else {
                        $query_buy_boxitem_in = "INSERT INTO exchange_record (box_item_id,item_id,buyer_id,owner_id,method_id,contact_name,contact_number,price_sum,quantity,order_time,status) ".
                                                    "VALUES('$box_item_id','$item_obj->id','$user_obj->id','$owner_obj->id','$item_obj->method_id','$contact_name','$contact_number','$item_obj->price','1',NOW(),'pending')";
                        mysql_query($query_buy_boxitem_in, $dbc);
                        mysql_query("UPDATE box_item SET status='pending',update_time=NOW() WHERE id='$box_item_id' LIMIT 1",$dbc);
                        if(!empty($contact_number)){
                            mysql_query("UPDATE user SET contact_number='$contact_number' WHERE id='$user_obj->id' LIMIT 1",$dbc);
                        }
                        $message_title = $user_obj->nickname."已訂購您的「".$item_obj->title."」";
                        $query_message_in = "INSERT INTO message (sender_id,receiver_id,title,content,send_time,new_reply_time) ".
                                                    "VALUES('$user_obj->id','$owner_obj->id','$message_title','$message_content',NOW(),NOW())";
                        mysql_query($query_message_in, $dbc);
                        
                        $param = "owner_name=".$owner_obj->nickname."&viewer_name=".$user_obj->nickname."&item_name=".$item_obj->title;
                        $mail_obj = new FleaMail('buy_box_item',$user_obj->nickname,$owner_obj->email);
                        $mail_obj->send_mail($param);
                        unset($mail_obj);
                        
                        $param = "owner_name=".$owner_obj->nickname."&viewer_name=".$user_obj->nickname."&item_name=".$item_obj->title;
                        $mail_obj = new FleaMail('ibuy_box_item',$user_obj->nickname,$user_obj->email);
                        $mail_obj->send_mail($param);
                        unset($mail_obj);
                        
                        $return_info = array(
                                'status' => 'success'
                            );
                    }
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
