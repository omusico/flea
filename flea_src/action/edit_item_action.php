<?php
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    if(!empty($_COOKIE['user_id'])){
        $item_id = $_POST['item_id'];
        $item_title = addslashes($_POST['item_title']);
        $item_content = addslashes($_POST['item_content']);

        $price = $_POST['price'];
        $school_id = $_POST['school_id'];
        $school_location_id = $_POST['school_location_id'];
        $category_id = $_POST['category_id'];
        $subcategory_id = $_POST['subcategory_id'];
        
        $dbc = connectdb();
        
        $update_item = "UPDATE item SET ".
                            "title='$item_title',content='$item_content',price='$price',school_id='$school_id',school_location_id='$school_location_id',category_id='$category_id',subcategory_id='$subcategory_id',is_released='1',".
                            "update_time=NOW() WHERE id='$item_id'";
        mysql_query($update_item, $dbc);

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
