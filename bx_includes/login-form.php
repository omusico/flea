<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $redirect = '';
    if(isset($_GET['redirect'])&&!empty($_GET['redirect'])){
        $redirect = $_GET['redirect'];
    }
?>
<div id="login_box" style="width:460px;">
	<div class="box_title">
        <h3>會員登入</h3>
	</div>
	<form method="post" name="loginform" id="loginform">
        <input type="hidden" name="redirect" value="<?=$redirect?>" />
        <div class="box_body">
            <div>
                Email<br />
                <input name="login_email" type="text" id="login_email" size="20" maxlength="50" />
                <span id="login_email_error"></span>
            </div>
            <div>
                密碼<br />
                <input name="login_passwd" type="password" id="login_passwd" size="20" maxlength="30" />
                <span id="login_passwd_error"></span>
            </div>
            <div id="login_error" class="login-alert clearboth">
                登入失敗！請檢查您所輸入的帳號密碼是否正確。
            </div>
            
            <div id="loginform_bottom_block">
                <a href="#" onclick="call_invite_box()" class="icon_link close"><span class="connect">還未註冊，索取邀請函</span></a>
                <a href="<?=SITE_URL?>/api/facebook/auth_facebook.php" class="icon_link"><span class="connect">帳號已與facebook連結，用facebook登入</span></a>
                <br class="clearboth">
            </div>
        </div>
        <div class="box_foot">
            <input type="button" value="登入" onclick="login_validate();" class="TBbtn butt" /> <input type="button" value="取消" class="TBbtn butt-cancel close" />
        </div> 
	</form>
</div>