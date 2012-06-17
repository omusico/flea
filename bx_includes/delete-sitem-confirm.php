<? if(!empty($_COOKIE['user_id'])){ ?>
    <?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $user_obj = new FleaUser($_COOKIE['user_id']);
    if($user_obj->auth_id>=90){
    ?>
        <?
            $sitem_id = '';
            if(isset($_GET['sitem_id'])&&!empty($_GET['sitem_id'])){
                $sitem_id = $_GET['sitem_id'];
                $sitem_obj = new FleaSpecialItem($sitem_id);
            }
        ?>
        <div id="delete_sitem_box" style="width:420px;">
            <div class="box_title">
                <h3>刪除商品</h3>
            </div>
            <div class="box_body">
                <form method="post" name="delete_sitem_form" id="delete_sitem_form">
                    <input type="hidden" name="sitem_id" value="<?=$sitem_id?>" />
                    <div id="box_confirm_message">
                        <p>
                            您確認要刪除「<?=$sitem_obj->title?>」?
                        </p>
                    </div>
                </form>
            </div>
            <div class="box_foot">
                <input type="button" value="確定" onclick="delete_sitem(<?=$sitem_obj->id?>);" class="TBbtn butt" /> <input type="button" value="取消" class="TBbtn butt-cancel close" />
            </div> 
        </div>
    <? } else {?>
    <? require_once('/var/www/html/flea/bx_includes/alert_box.php'); ?>
    <? }?> 
<? } else {?>
<? require_once('/var/www/html/flea/bx_includes/alert_box.php'); ?>
<? }?>