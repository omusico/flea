<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $invitation_id = $_POST['invitation_id'];
    $verify_code = $_POST['verify_code'];
    $account = $_POST['account'];
    $invite_email = $_POST['invite_email'];
    $school_id = $_POST['school_id'];
    $school_department_id = $_POST['department_id'];
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $password = $_POST['password1'];
    $birth_y = $_POST['birth_y'];
    $birth_m = $_POST['birth_m'];
    $birth_d = $_POST['birth_d'];
    $birthday = $birth_y.'-'.$birth_m.'-'.$birth_d;
    $gender = $_POST['gender'];
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    
    $dbc = connectdb();
            
    $query_user = "SELECT * FROM user WHERE invite_email='$email'";
    $query_user_result = mysql_query($query_user, $dbc);
    $user_exist_num = mysql_num_rows($query_user_result);
    mysql_free_result($query_user_result);
    
    if($user_exist_num>0){
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".SITE_URL."/hint.php?mid=account_exist");
    } else {
        $update_invitation = "UPDATE invitation SET is_verify='1' WHERE invite_email='$invite_email'";
        mysql_query($update_invitation, $dbc);
        
        $insert_user = "INSERT INTO user ".
                            "(account,invite_email,school_id,school_department_id,nickname,email,".
                            "password,birthday,gender,firstname,lastname,create_time,update_time,is_verify) VALUES ".
                            "('$account','$invite_email','$school_id','$school_department_id','$nickname','$email',".
                            "'$password','$birthday','$gender','$firstname','$lastname',NOW(),NOW(),'1')";
        mysql_query($insert_user, $dbc);
        $user_id = mysql_insert_id($dbc);
        $cookie_process_obj = new FleaCookieProcess();
        $cookie_process_obj->set_cookie($user_id);
        
        header("Location: ".SITE_URL."/my.php");
    }
?>
