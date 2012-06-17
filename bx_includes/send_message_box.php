<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $receiver_id = $_GET['receiver_id'];
    $receiver_obj = new FleaUser($receiver_id);
?>
<div id="send_message_box" style="width:600px; max-height: 560px; overflow: none;">
	<div class="box_title">
        <h3>發送訊息給<?=$receiver_obj->nickname?></h3>
	</div>
    <div class="box_body" style="max-height: 475px;">
        <div style="margin:10px; 0px; border-bottom:#ccc dotted 1px; padding-bottom: 10px;">
            <div style="float:left; width:50px;">
                <a href="<?=SITE_URL?>/user.php?account=<?=$receiver_obj->account?>">
                    <img border="0" align="absmiddle" src="<?=$receiver_obj->getUserIcon('50')?>">
                </a>
            </div>
            <div style="float:right; width:450px;">
                <div style="margin-bottom:10px;">
					收件人：<a href="<?=SITE_URL?>/user.php?account=<?=$receiver_obj->account?>"><?=$receiver_obj->nickname?></a><br>
                    <input type="hidden"  name="receiver_id" value="<?=$receiver_obj->id?>" type="text" id="receiver_id" />
                </div>
            </div>
            <br class="clearboth" />
            <div>
                <div>
                    主旨<br />
                    <input style="width:90%;" name="message_title" type="text" id="message_title" />
                    <span id="message_title_error"></span>
                </div>
                <div>
                     訊息<br />
                    <textarea style="width:90%;" rows="4" name="message_content" id="message_content"></textarea>
                    <br/>
                    <span id="message_content_error"></span>
                </div>
            </div>
            <br class="clearboth" />
        </div>
        <br class="clearboth" />
    </div>
    <div class="box_foot">
            <input type="button" value="送出" onclick="send_message();" class="TBbtn butt" /> <input type="button" value="關閉" class="TBbtn butt close" />
    </div> 
</div>
<?
    unset($message_obj);
    unset($sender_obj);
?>
<? } else {?>
<? require_once('/var/www/html/flea/bx_includes/alert_box.php'); ?>
<? }?>