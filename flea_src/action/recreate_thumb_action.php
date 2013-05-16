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

        $image_process = new FleaImageProcess();
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"18");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"25");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"50");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"75");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconSquare($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"500");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"640");
        $image_process->createItemIconResize($path_obj->user_item_path,$item_id,$subname,"1024");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"100");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"150");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"200");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"300");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"500");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"640");
        $image_process->createItemIconResizeW($path_obj->user_item_path,$item_id,$subname,"1024");
    }

?>
<div id="item_icon_block<?=$item_obj->id?>" class="item_icon_block left">
    <span class="polaroids <?=rand_polaroids();?>"><img id="item_icon" src="<?=$item_obj->getItemIconRW('200');?>?<?=time();?>" width="200" /></span>
</div>
<? 
    unset($image_process);
    unset($dbc);
    unset($item_obj);
    unset($owner_obj);
    unset($path_obj);
} 
?>