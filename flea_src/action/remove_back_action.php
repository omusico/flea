<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $item_id = $_POST['item_id'];
    $item_obj = new FleaTransactionItem($item_id);
    $owner_obj = new FleaUser($item_obj->owner_id);
    $path_obj = new FleaFilePathProcess($owner_obj->id);
    $item_icon_path = $path_obj->user_item_path.'/'.$item_obj->icon;
    if(file_exists($item_icon_path)){
    
        $occ = strrpos($item_obj->icon,".");
        $subname = substr($item_obj->icon, $occ);
        
        $icon_name = $item_id.'.png';

        $image_process = new FleaImageProcess();
        $image_process->removeBack($item_icon_path,$path_obj->user_item_path,$item_id);
        
        $dbc = connectdb();
        $update_item = "UPDATE item SET icon='$icon_name' WHERE id='$item_id'";
        mysql_query($update_item, $dbc);
        
        
        unset($image_process);
        unset($dbc);
        unset($item_obj);
        unset($owner_obj);
        unset($path_obj);
        
        $return_info = array(
                                'status' => 'success'
                            );
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