<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    
    if(!empty($_COOKIE['user_id'])){
        $school_department_id = $_POST['department_id'];
        $nickname = addslashes($_POST['nickname']);
        $email = $_POST['email'];
        $birth_y = $_POST['birth_y'];
        $birth_m = $_POST['birth_m'];
        $birth_d = $_POST['birth_d'];
        $birthday = $birth_y.'-'.$birth_m.'-'.$birth_d;
        $gender = $_POST['gender'];
        $firstname = $_POST['first_name'];
        $lastname = $_POST['last_name'];
        $contact_number = $_POST['contact_number'];
        $about_me = addslashes($_POST['about_me']);
        
        $user_id = $_COOKIE['user_id'];
        $dbc = connectdb();
        
        $update_user = "UPDATE user SET ".
                            "school_department_id='$school_department_id',nickname='$nickname',email='$email',birthday='$birthday',gender='$gender',firstname='$firstname',lastname='$lastname',".
                            "contact_number='$contact_number',about_me='$about_me',update_time=NOW() WHERE id='$user_id'";
        mysql_query($update_user, $dbc);

        $return_info = array(
                        'status' => 'success'
                    );
    } else {
        $return_info = array(
                        'status' => 'fail'
                    );
    }
    
    echo json_encode($return_info);
?>
