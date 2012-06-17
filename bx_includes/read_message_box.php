<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $message_id = $_GET['message_id'];
    $type = $_GET['type'];
    $message_obj = new FleaMessage($message_id);
    $sender_obj = new FleaUser($message_obj->sender_id);
    $dbc = connectdb();
    if($type=='receive') {
        $update_message = "UPDATE message SET is_receiver_readed='1' WHERE id='$message_obj->id'";
    } else {
        $update_message = "UPDATE message SET is_sender_readed='1' WHERE id='$message_obj->id'";
    }
    
    mysql_query($update_message, $dbc);
?>
<div id="receive_message_box" style="width:600px; max-height: 560px; overflow: none;">
	<div class="box_title">
        <h3><?=$message_obj->title?></h3>
	</div>
    <div class="box_body" style="max-height: 475px;">
        <div style="margin:10px; 0px; border-bottom:#ccc dotted 1px; padding-bottom: 10px;">
            <div style="float:left; width:50px;">
                <a href="<?=SITE_URL?>/user.php?account=<?=$sender_obj->account?>">
                    <img border="0" align="absmiddle" src="<?=$sender_obj->getUserIcon('50')?>">
                </a>
            </div>
            <div style="float:right; width:450px;">
                <div style="margin-bottom:10px;">
					寄件人：<a href="<?=SITE_URL?>/user.php?account=<?=$sender_obj->account?>"><?=$sender_obj->nickname?></a><br>
                    <?=showDateTime($message_obj->send_time)?>
                </div>
                <div style="margin-bottom:10px;">
                    <?=nl2br($message_obj->content)?>
                </div>
            </div>
            <div style="text-align:center;">
                <div class="textfield" style="padding:10px;">
                    <label for="message_content"></label>
                    <textarea style="width:90%;" rows="4" name="message_content" id="message_content"></textarea>
                    <br/>
                    <span id="message_content_error"></span>
                </div>
                <input type="button" onclick="reply_message('<?=$message_obj->id?>',$('#message_content').val());" value="回覆" class="TBbtn butt" />
            </div>
        </div>
        <br class="clearboth" />
        <?
        $query_remessage = "SELECT id FROM reply_message WHERE message_id='$message_obj->id' ORDER BY send_time DESC";
        $query_remessage_result = mysql_query($query_remessage, $dbc);
        $remessage_num = mysql_num_rows($query_remessage_result);
        if($remessage_num>0){
        ?>
        <h3>所有回覆信件</h3>
        
        <?
        while ($query_remessage_result_data = mysql_fetch_array($query_remessage_result)) {
            $remessage_obj = new FleaReMessage($query_remessage_result_data['id']);
            $resender_obj = new FleaUser($remessage_obj->sender_id);
        ?>
        <div style="margin:10px; 0px; border-bottom:#ccc dotted 1px;">
            <div style="float:left; width:50px;">
                <a href="<?=SITE_URL?>/user.php?account=<?=$resender_obj->account?>">
                    <img border="0" align="absmiddle" src="<?=$resender_obj->getUserIcon('50')?>">
                </a>
            </div>
            <div style="float:right; width:450px;">
                <div style="margin-bottom:10px;">
                    寄件人：<a href="<?=SITE_URL?>/user.php?account=<?=$resender_obj->account?>"><?=$resender_obj->nickname?></a><br>
                    <?=showDateTime($remessage_obj->send_time)?>
                </div>
                <div style="margin-bottom:10px;">
                    <?=nl2br($remessage_obj->content)?>
                </div>
            </div>
            <br class="clearboth" />
        </div>
        <?
            unset($remessage_obj);
            unset($resender_obj);
        }
        ?>
       
        <br class="clearboth" />
        <?
        }
        mysql_free_result($query_remessage_result);
        ?>
    </div>
    <div class="box_foot">
            <input type="button" value="關閉" class="TBbtn butt close" />
    </div> 
</div>
<?
    unset($message_obj);
    unset($sender_obj);
?>
<? } else {?>
<? require_once('/var/www/html/flea/bx_includes/alert_box.php'); ?>
<? }?>