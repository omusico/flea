<?
    require_once('/var/www/html/flea/flea_src/classes/flea.inc');
?>
<div id="login_box" style="width:420px;">
	<div class="box_title">
        <h3>索取邀請函</h3>
	</div>
	<form method="post" name="inviteform" id="inviteform">
        <div class="box_body">
            <div>
                請輸入政大電子郵件地址<br />
                <input name="email" type="text" id="email" size="20" maxlength="50" />
                <span id="email_error"></span>
            </div>
            <div class="service-des">
                政!大福利市集是提供給政大學生的線上物品交易平台，為保障您的交易品質所以需要透過您的政大電子郵件地址來註冊喔!
            </div>
        </div>
        <div class="box_foot">
            <input type="button" value="送出" onclick="invite_validate();" class="TBbtn butt" /> <input type="button" value="取消" class="TBbtn butt-cancel close" />
        </div> 
	</form>
</div>