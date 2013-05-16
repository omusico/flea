<?php
	require_once('/var/www/html/flea/flea_src/base_functions.php');
    require_once('/var/www/html/library/facebook-php-sdk/src/facebook.php');
    $type = $_GET['type'];
    $i = $_GET['i'];
    $s = $_GET['s'];
    
    // Create our Application instance (replace this with your appId and secret).
     $facebook = new Facebook(array(
      'appId'  => '218582441497963',
      'secret' => 'b0d781007828e3874e5828e95b487f45',
      'cookie' => true,
    ));

    $rollback_uri = SITE_URL."/api/facebook/auth_facebook.php".
                    "?type=".$type."&i=".$i."&s=".$s;
	
    $session = $facebook->getSession();

    $me = null;
    // Session based API call.
    if ($session) {
      try {
        $uid = $facebook->getUser();
        $me = $facebook->api('/me');
      } catch (FacebookApiException $e) {
        error_log($e);
      }
    } else {//user not login
        echo "no session";
        header("Location: ".$rollback_uri); 
        exit;
    }
    
    $access_token = $session['access_token'];
    $fb_uid = $session['uid'];

    unset($facebook);
    unset($session);
    
    // login or logout url will be needed depending on current user state.
    if ($me) {//user has login
    
        $email = $me['email'];
        $fb_name = addslashes($me['name']);
        $pic_big = "http://graph.facebook.com/".$fb_uid."/picture?type=large";
        unset($me);
        
        
        if(!empty($email)){
            $dbc = connectdb();
            $fb_profile = file_get_contents('https://graph.facebook.com/'.$fb_uid.'?access_token='.$access_token);
            $sp_obj = new FleaStringProcess();
            $fb_profile_utf8 = $sp_obj->unicode_to_utf8($fb_profile);
            $fb_profile_safe = mysql_real_escape_string(nl2br($fb_profile_utf8));
            echo $fb_profile_safe.'<br/>';
            
            //查詢是否已在站上
            if(!empty($_COOKIE['user_id'])){// update user data
                $user_obj = new FleaUser($_COOKIE['user_id']);
                $update_user = "UPDATE user SET fb_id='$fb_uid',fb_name='$fb_name',fb_icon='$pic_big',fb_profile='$fb_profile_safe',fb_access_token='$access_token' WHERE id='$user_obj->id'";
                mysql_query($update_user, $dbc);
                echo mysql_error($dbc);
                $fw_url = SITE_URL."/my.php#settings";
            } else {// create account or login
                $query_fb_uid = mysql_query("SELECT id FROM user WHERE fb_id='$fb_uid' LIMIT 1", $dbc);
                $user_exist_num = mysql_num_rows($query_fb_uid);
                if($user_exist_num>=1){//login
                    while ($query_fb_uid_data = mysql_fetch_array($query_fb_uid)) {
                        $cookie_process_obj = new FleaCookieProcess();
                        $cookie_process_obj->set_cookie($query_fb_uid_data['id']);
                        unset($cookie_process_obj);
                        $fw_url = SITE_URL."/my.php";
                    }
                } else {//create_account
                    if(isset($_GET['i'])&&isset($_GET['s'])&&!empty($_GET['i'])&&!empty($_GET['s'])){
                        $invitation_id = $_GET['i'];
                        $verify_code = $_GET['s'];
                        $query_invitaiton = "SELECT invite_email,is_verify FROM invitation WHERE id='$invitation_id' AND verify_code='$verify_code' AND is_verify='0'";
                        $query_invitaiton_result = mysql_query($query_invitaiton, $dbc);
                        $invite_email = '';
                        $is_verify = 0;
                        while ($query_invitaiton_result_data = mysql_fetch_array($query_invitaiton_result)) {
                            $invite_email = $query_invitaiton_result_data['invite_email'];
                            $is_verify = $query_invitaiton_result_data['is_verify'];
                        }
                        $invitation_exist_num = mysql_num_rows($query_invitaiton_result);
                        mysql_free_result($query_invitaiton_result);

                        if($invitation_exist_num>0) {//create
                            $email_array = explode('@',$invite_email);
                            $account = $email_array[0];
                            $school_obj = new FleaSchool($email_array[1],'domain');
                            $school_id = $school_obj->id;
                            $password = 'fb_'.$fb_uid.time();
                            
                            $user_fb_data = json_decode($fb_profile_utf8, true);
                            $birthday_a = explode('/',$user_fb_data['birthday']);
                            $birthday = $birthday_a['2'].'-'.$birthday_a['0'].'-'.$birthday_a['1'];
                            if($user_fb_data['gender']=='male'){
                                $gender = '1';
                            } else if($user_fb_data['gender']=='female'){
                                $gender = '2';
                            } else {
                                $gender = '0';
                            }
                            $firstname = $user_fb_data['first_name'];
                            $lastname = $user_fb_data['last_name'];
                            
                            $update_invitation = "UPDATE invitation SET is_verify='1' WHERE invite_email='$invite_email'";
                            mysql_query($update_invitation, $dbc);
                            
                            $insert_user = "INSERT INTO user ".
                                                "(account,invite_email,school_id,school_department_id,nickname,email,".
                                                "password,birthday,gender,firstname,lastname,create_time,update_time,is_verify,".
                                                "fb_id,fb_name,fb_icon,fb_profile,fb_access_token) VALUES ".
                                                "('$account','$invite_email','$school_id','0','$fb_name','$email',".
                                                "'$password','$birthday','$gender','$firstname','$lastname',NOW(),NOW(),'1',".
                                                "'$fb_uid','$fb_name','$pic_big','$fb_profile_utf8','$access_token')";
                            
                            
                            mysql_query($insert_user, $dbc);
                            $user_id = mysql_insert_id($dbc);
                            $cookie_process_obj = new FleaCookieProcess();
                            $cookie_process_obj->set_cookie($user_id);
                            
                            $path_obj = new FleaFilePathProcess($user_id);
                            $facebook_usericon = file_get_contents($pic_big);
                            file_put_contents($path_obj->user_icon_path."/".$user_id.".jpg",$facebook_usericon);
                            
                            $image_process = new FleaImageProcess();
                            $image_process->createUserIconSquare($path_obj->user_icon_path,$user_id,".jpg","18");
                            $image_process->createUserIconSquare($path_obj->user_icon_path,$user_id,".jpg","25");
                            $image_process->createUserIconSquare($path_obj->user_icon_path,$user_id,".jpg","50");
                            $image_process->createUserIconSquare($path_obj->user_icon_path,$user_id,".jpg","75");
                            $image_process->createUserIconSquare($path_obj->user_icon_path,$user_id,".jpg","100");
                            $image_process->createUserIconSquare($path_obj->user_icon_path,$user_id,".jpg","150");
                            $image_process->createUserIconSquare($path_obj->user_icon_path,$user_id,".jpg","200");
                            $image_process->createUserIconSquare($path_obj->user_icon_path,$user_id,".jpg","300");
                            $image_process->createUserIconResize($path_obj->user_icon_path,$user_id,".jpg","100");
                            $image_process->createUserIconResize($path_obj->user_icon_path,$user_id,".jpg","150");
                            $image_process->createUserIconResize($path_obj->user_icon_path,$user_id,".jpg","200");
                            $image_process->createUserIconResize($path_obj->user_icon_path,$user_id,".jpg","300");
                            $image_process->createUserIconResize($path_obj->user_icon_path,$user_id,".jpg","500");
                            $image_process->createUserIconResize($path_obj->user_icon_path,$user_id,".jpg","640");
                            $image_process->createUserIconResize($path_obj->user_icon_path,$user_id,".jpg","1024");
                            
                            $icon_file_name = $user_id.".jpg";
                            $dbc = connectdb();
                            $update_user = "UPDATE user SET icon='$icon_file_name' WHERE id='$user_id'";
                            mysql_query($update_user, $dbc);
                            
                            $fw_url = SITE_URL."/my.php#settings";
                        } else {
                            $fw_url = SITE_URL."/404.php";
                        }
                    } else {
                        $fw_url = SITE_URL."/404.php";
                    }
                }
                mysql_free_result($query_fb_uid);
            }
            //header("Location: ".$fw_url);
            
            
        }else{
            echo "empty email";
            //header("Location: ".$rollback_uri); 
            exit;
        }
    
    } else {//user not login
        echo "not login";
        //header("Location: ".$rollback_uri); 
        exit;
    }

?>