<? 
if(!empty($_COOKIE['user_id'])){ 
    require_once('/var/www/html/flea/flea_src/base_functions.php');
?>
<h2>最新訊息</h2>
<div>
    <div id="my_news_tabs">
        <ul>
            <li><a href="<?=SITE_URL?>/flea_src/content/my_page/receive_tab.php"><span>收件匣</span></a></li>
            <li><a href="<?=SITE_URL?>/flea_src/content/my_page/send_tab.php"><span>寄件匣</span></a></li>
            <li><a href="<?=SITE_URL?>/flea_src/content/my_page/pending_item_tab.php"><span>待處理商品訂單</span></a></li>
            <li><a href="<?=SITE_URL?>/flea_src/content/my_page/buy_item_tab.php"><span>您已訂購的商品</span></a></li>
            <li><a href="<?=SITE_URL?>/flea_src/content/my_page/follow_item_tab.php"><span>您正追蹤的商品</span></a></li>
        </ul>
    </div>
</div>
<div class="clearboth"></div>
<? } ?>