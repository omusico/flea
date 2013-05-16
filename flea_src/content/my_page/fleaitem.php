<? if(!empty($_COOKIE['user_id'])){ ?>
<?
require_once('/var/www/html/flea/flea_src/base_functions.php');
?>
<h2>福利商品管理</h2>
<div id="item_upload_block">
    <div id="file_uplaoder">
        <h3>新增商品</h3>
        <p>
            <input id="files-upload" accept="image/*" type="file" multiple />
        </p>
        <p id="drop-area">
            <span class="drop-instructions">或直接拖放圖片到此以上傳圖片</span>
            <span class="drop-over">把圖片放進來!</span>
        </p>
        <div id="file-list">
        </div>
    </div>
    <? require_once('/var/www/html/flea/js/html5_uploader_js.php');?>
    <h3>目前所有商品</h3>
    <div id="item_container_block">   
        <? require_once('/var/www/html/flea/flea_src/action/get_itemlist_block_action.php'); ?>
    </div>
</div>
<div class="clearboth"></div>
<? } ?>