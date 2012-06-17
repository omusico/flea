        <div id="content">
            <div class="inner">
                <? if(!empty($_COOKIE['user_id'])){ ?>
                <div class="block _1u left">
                    <div class="profile_block">
                        <a href="/flea/user.php?account=<?=$user_obj->account?>"><img src="<?=$user_obj->getUserIcon();?>" class="userpic"></a> 
                        <h3 class="username"><a href="/flea/user.php?account=<?=$user_obj->account?>"><?=$user_obj->nickname;?></a></h3> 
                        <div class="clearboth"></div> 
                    </div>
                    <div class="user_links">
                        <div class="item"><a id="message_page" onclick="loadAjaxContent('message');" href="#message">最新訊息</a></div>
                        <div class="item"><a id="transaction_page" onclick="loadAjaxContent('transaction');" href="#transaction">交易紀錄</a></div>
                        <div class="item"><a id="settings_page" onclick="loadAjaxContent('settings');" href="#settings">帳戶設定</a></div>
                        <div class="item"><a id="fleabox_page" onclick="loadAjaxContent('fleabox');" href="#fleabox">福利格子管理</a></div>
                        <div class="item"><a id="fleaitem_page" onclick="loadAjaxContent('fleaitem');" href="#fleaitem">福利商品管理</a></div>
                        <div class="item"><a id="fleaitem_page" href="/flea/user.php?account=<?=$user_obj->account?>">前往個人首頁</a></div>
                    </div>
                    <?
                    if($user_obj->auth_id>=90){
                    ?>
                    <h3>管理員功能</h3>
                    <div class="user_links">
                        <div class="item"><a id="specialitem_page" onclick="loadAjaxContent('specialitem');" href="#specialitem">福利元件管理</a></div>
                    </div>
                    <?
                    }
                    ?>
                    <? 
                    if(!empty($user_obj->fb_id)){
                        $facebook_data_obj = json_decode($user_obj->fb_profile);
                    ?>
                    <div id="fb_connect_side_block">
                        <h3>臉書連結</h3>
                        <p>你的政!大福利市集目前與臉書帳號連結:</p>
                        <div class="fb_inner_block">
                            <div id="facebook_connect_side_profile_block">
                                <img src="http://graph.facebook.com/<?=$user_obj->fb_id?>/picture?type=square"> 
                                <a href="<?=$facebook_data_obj->link?>"><?=$user_obj->fb_name?></a>
                            </div>
                        </div>
                    </div>
                    <? } else { ?>
                    <div>
                        <h4>現在就連結你的臉書帳號！</h4>
                        <p>你知道嗎？在政!大福利市集上使用臉書帳號登入，可以得到更豐富有趣的互動體驗！馬上<a onclick="loadAjaxContent('settings');">連結臉書帳戶</a>，也別忘了邀請更多朋友一起登入政!大福利市集喔！</p>
                    </div>
                    <? } ?>
                </div>
                <div id="my_main_content" class="block _3u right">
                    <? require_once(SITE_DOC.'/flea_src/content/my_page/message.php'); ?>
                </div>
                <br class="clearboth">
                <? } ?>
            </div>
        </div>