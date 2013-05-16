<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $type = $_GET['type'];
?>
<div id="login_box" style="width:420px;">
	<div class="box_title">
        <h3>
        <? 
            switch($type){ 
                default:
        ?>
            服務說明
        <?
                break;
            }
        ?>
        </h3>
	</div>
	<form method="post" name="inviteform" id="inviteform" action="<?=SITE_URL;?>/flea_src/action/get_invite_action.php">
        <div class="box_body">
        <? 
            switch($type){ 
                case 'follow_item_deleted':
        ?>
            <p>
                已停止追蹤此物品!
            </p>
        <?        
                break;
                case 'exchange_complete':
        ?>
            <p>
                已完成此筆交易!
            </p>
        <?        
                break;
                case 'message_replyed':
        ?>
            <p>
                訊息已經送出!
            </p>
        <?        
                break;
                case 'search_value_error':
        ?>
            <p>
                要輸入關鍵字才能進行搜尋喔!
            </p>
        <?        
                break;
                case 'box_item_buyed_error':
        ?>
            <p>
                已有人訂購此物品，請挑挑別的吧！
            </p>
        <?        
                break;
                case 'box_item_buy_self_error':
        ?>
            <p>
                您無法訂購自己的物品。
            </p>
        <?        
                break;
                case 'box_item_follow_self_error':
        ?>
            <p>
                您無法追蹤自己的物品。
            </p>
        <?        
                break;
                case 'box_item_buyed':
        ?>
            <p>
                已經完成訂購。
            </p>
        <?
                break;
                case 'box_item_followed':
        ?>
            <p>
                已經加入追蹤。
            </p>
        <?
                break;
                case 'error':
        ?>
            <p>
                發生錯誤，請重試。
            </p>
        <?
                break;
                case 'settings_success':
        ?>
            <p>
                帳戶資料已更新。
            </p>
        <?
                break;
                case 'invite_success':
        ?>
            <p>
                索取邀請函成功，請至您的政大信箱開啟邀請函以完成帳戶驗證及註冊。
            </p>
        <?
                break;
                case 'invite_fail':
        ?>
            <p>
                您已索取過邀請函或帳號已存在。
            </p>
        <?
                break;
                case 'construct':
        ?>
            <div class="service-des">
                此部分仍在建制中，敬請期待!
            </div>
        <?
                break;
                default:
        ?>
            <div class="service-des">
                發生錯誤，請重試。
            </div>
        <?
                break;
            }
        ?>
        </div>
        <div class="box_foot">
            <input type="button" value="關閉" class="TBbtn butt close" />
        </div> 
	</form>
</div>