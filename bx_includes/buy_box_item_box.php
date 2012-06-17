<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $viewer_id = new FleaUser($_COOKIE['user_id']);
    $item_id = $_GET['item_id'];
    $box_item_id = $_GET['box_item_id'];
    $item_obj = new FleaTransactionItem($item_id);
    $method_obj = new FleaTransactionMethod($item_obj->method_id);
    $school_obj = new FleaSchool($item_obj->school_id);
    $location_obj = new FleaSchoolLocation($item_obj->school_location_id);
    $dbc = connectdb();
?>
<div id="buy_box_item_box" style="width:600px;">
	<div class="box_title">
        <h3>購買「<?=$item_obj->title?>」</h3>
	</div>
    <div class="box_body">   
	<form method="post" id="buy_box_item_form" name="buy_box_item_form">
        <input type="hidden" name="item_id" id="buy_item_id" value="<?=$item_obj->id?>" />
        <input type="hidden" name="box_item_id" id="buy_box_item_id" value="<?=$box_item_id?>" />
        <div id="buy_form_item_block">
            <div id="buy_form_item_icon_block">
                <img src="<?=$item_obj->getItemIcon('200')?>" />
            </div>
            <div id="buy_form_item_info_block">
                <div id="item_sub">
                    <div id="title"><h2><?=$item_obj->title?></h2></div>
                    <div class="left" id="price">
                        <h4>價格</h4>
                        <div id="price_text">$ <?=$item_obj->price?></div>
                    </div>
                    <div class="left" id="btns">
                        <div class="btn_item">
                            交易方式: <?=$method_obj->title?>
                        </div>
                        <div class="btn_item">
                            交易學校: <?=$school_obj->title?>
                        </div>
                        <div class="btn_item">
                            交易地點: <?=$location_obj->title?>
                        </div>
                    </div>
                    <div class="clearboth"></div>
                </div>
                <div>
                    <div class="textfield" style="display:none;">
                        <label for="contact_name">聯絡人名稱</label>
                        <input type="text" name="contact_name" id="contact_name" value="<?=$viewer_id->lastname.$viewer_id->firstname?>" class="text">
                        <span id="contact_name_error"></span>
                    </div>
                    <div class="textfield">
                        <label for="contact_number">聯絡人電話</label>
                        <input type="text" name="contact_number" id="contact_number" value="<?=$viewer_id->contact_number?>" class="text">
                        <span id="contact_number_error"></span>
                    </div>
                    <div class="textfield">
                        <label for="message_content"></label>
                        <textarea style="width:90%;" rows="4" name="message_content" id="message_content">我想購買您的「<?=$item_obj->title?>」，請快跟我聯絡吧!</textarea>
                        <br/>
                        <span id="message_content_error"></span>
                    </div>
                </div>
            </div>
            <br class="clearboth" />
        </div>
	</form>
    </div>
    <div class="box_foot">
        <input type="button" value="送出" onclick="buy_box_validate();" class="TBbtn butt" /> <input type="button" value="取消" class="TBbtn butt-cancel close" />
    </div> 
</div>
<? } else {?>
<? require_once('/var/www/html/flea/bx_includes/alert_box.php'); ?>
<? }?>