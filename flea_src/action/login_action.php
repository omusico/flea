<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(isset($_POST['email'])&&!empty($_POST['email'])&&isset($_POST['password'])&&!empty($_POST['password'])){
        $dbc = connectdb();
        $save_email = addslashes($_POST['email']);
        $save_password = addslashes($_POST['password']);  
        $query_user = "SELECT id FROM user WHERE invite_email='$save_email' AND password='$save_password' LIMIT 1";
        $query_user_result = mysql_query($query_user, $dbc);
        $user_exist_num = mysql_num_rows($query_user_result);
        if($user_exist_num==1){
            $user_id = 0;
            while ($query_user_result_data = mysql_fetch_array($query_user_result)) {
                $user_id = $query_user_result_data['id'];
            }
            $cookie_process_obj = new FleaCookieProcess();
            $cookie_process_obj->set_cookie($user_id);
            unset($cookie_process_obj);
            
            $return_info = array(
                        'status' => 'success'
                    );
        } else {
            $return_info = array(
                        'status' => 'error'
                    );
        }
        mysql_free_result($query_user_result);
    } else {
        $return_info = array(
                        'status' => 'null'
                    );
    }
    
    echo json_encode($return_info);
?>
