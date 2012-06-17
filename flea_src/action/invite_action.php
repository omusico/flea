<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(isset($_POST['email'])&&!empty($_POST['email'])){
        $email = $_POST['email'];
        $email_array = explode('@',$email);
        if($email_array[1]=='nccu.edu.tw'){
            $dbc = connectdb();
            
            $query_user = "SELECT * FROM user WHERE invite_email='$email'";
            $query_user_result = mysql_query($query_user, $dbc);
            $user_exist_num = mysql_num_rows($query_user_result);
            mysql_free_result($query_user_result);
            
            $query_invite = "SELECT * FROM invitation WHERE invite_email='$email'";
            $query_invite_result = mysql_query($query_invite, $dbc);
            $invite_exist_num = mysql_num_rows($query_invite_result);
            mysql_free_result($query_invite_result);
            
            if($user_exist_num==0&&$invite_exist_num==0){
                $time = time();
                $sid = sha1($time.$email);
                $query_invite_in = "INSERT INTO invitation (invite_email,is_verify,verify_code,create_time) VALUES('$email','0','$sid',NOW())";
                mysql_query($query_invite_in, $dbc);
                $this_invite_id = mysql_insert_id();
                
                //send register mail
                $param = "name=".$email_array[0]."&id=".$this_invite_id."&sid=".$sid;
                $mail_obj = new FleaMail('invite_signup',$email_array[0],$email);
                $mail_obj->send_mail($param);

                $return_info = array(
                        'status' => 'success'
                    );
                
            } else {
                 $return_info = array(
                        'status' => 'exist'
                    );
            }
        } else {
            $return_info = array(
                        'status' => 'not nccu'
                    );
        }
    } else {
        $return_info = array(
                        'status' => 'null'
                    );
    }
    
    echo json_encode($return_info);
?>
