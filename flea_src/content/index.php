        <?
        $viewer_obj = 'guest';
        if(!empty($_COOKIE['user_id'])){
            $viewer_obj = new FleaUser($_COOKIE['user_id']);
        }
        ?>
        <div id="content">
            <div class="inner">
                <div id="guarantee">
                  <h3>Welcome Flea!</h3>
                  <p>『政！大福利市集』是政大學生的專屬市集。在這裡你(妳)有自己的櫃子，風格自由佈置、打點，販售你(妳)的商品無論是流行單品、實用設計、二手寶貝、團購好物或是獨一無二的創意手工製品。這是屬於政大學生的交易分享平台，實用與挖寶兼具的社群買賣生活圈。想知道有什麼好康嗎？快來尋找驚喜吧！</p>
                  <h3>關於創辦人 Ane/Fukuball/Jin</h3>
                  <p>企劃、設計與程式，三個不同邏輯的腦袋，兜在一起會產生甚麼樣的化學作用？反應過程是雞同鴨講，是天馬行空，是僵持不下，是可能無限。對數位內容的好奇與網路應用的熱情是我們的共同語言，在政大的好多山好多水的工作環境，畫下未來生活的一篇篇草圖。<br/>如果你(妳)對『政！大福利市集』有任何興趣、疑惑、非說不可的建議，歡迎隨時<a href="<?=SITE_URL;?>/about.php">與我們連絡</a>！</p>
                </div>
                <div id="home_item_block">
                    <?
                    $dbc = connectdb();
                    $query_box_item = "SELECT bi.id,bi.item_id FROM box_item bi INNER JOIN box b ON (bi.box_id=b.id) INNER JOIN item i ON (bi.item_id=i.id) WHERE bi.type='normal' AND bi.status!='is_deleted' AND bi.status!='paid' AND b.is_released='1' AND b.is_deleted='0' AND i.is_deleted='0' ORDER BY bi.id DESC LIMIT 0,40";
                    $query_box_item_result = mysql_query($query_box_item, $dbc);
                    while ($query_box_item_result_data = mysql_fetch_array($query_box_item_result)) {
                        $box_item_id = $query_box_item_result_data['id'];
                        $box_item_obj = new FleaBoxItem($box_item_id);
                        $item_obj = new FleaTransactionItem($query_box_item_result_data['item_id']);
                        $box_owner_obj = new FleaUser($item_obj->owner_id);
                    ?>
                    <div class="home_box_item_merch">
                        <div class="polaroids_noshadow">
                            <a href="/flea/item.php?item_id=<?=$item_obj->id?>&box_item_id=<?=$box_item_id?>"><img src="<?=$item_obj->getItemIcon('200')?>" onmouseover="setboxiteminfo_diplay('<?=$box_item_id?>');" /></a>
                            <div class="home_box_item_merch_info" id="home_box_item_merch_info<?=$box_item_id?>" onmouseout="setboxiteminfo_none('<?=$box_item_id?>');">
                                <span class="content"><?=$item_obj->content?></span>
                            </div>
                            <? if($box_item_obj->status=='pending'){ ?>
                            <div class="box_item_buyed_alert">
                                已有人訂購
                            </div>
                            <? } ?>
                        </div>
                        <br class="clearboth" />
                        <div class="info_block">
                            <div class="info_title"><a href="/flea/item.php?item_id=<?=$item_obj->id?>&box_item_id=<?=$box_item_id?>"><?=$item_obj->title?></a></div>
                        </div>
                        <div class="func_block">
                            <div class="left">
                                <a onclick="call_item_icon_box('&box_item_id=<?=$box_item_id?>&item_id=<?=$item_obj->id?>')"><span>看大圖</span></a>
                            </div>
                            <div class="right">
                                <?
                                if($viewer_obj=='guest'){
                                ?>
                                <a onclick="call_login_box()"><span>追蹤</span></a>
                                <?
                                } else {
                                    echo $viewer_obj->getBoxItemFollowBtn('small',$item_obj->id,$box_item_id);
                                }
                                ?>
                                <?
                                if($box_item_obj->status=='for_sale'){
                                    if($viewer_obj=='guest'){
                                    ?>
                                    <a onclick="call_login_box()"><span>購買</span></a>
                                    <?
                                    } else {
                                        echo $viewer_obj->getBoxItemBuyBtn('small',$item_obj->id,$box_item_id);
                                    }
                                }
                                ?>
                            </div>
                            <br class="clearboth" />
                        </div>
                        <div class="owner_block">
                            <div class="left">
                                <a href="/flea/user.php?account=<?=$box_owner_obj->account?>"><img src="<?=$box_owner_obj->getUserIcon('25');?>" /></a>
                            </div>
                            <div class="user_info left">
                                <a href="/flea/user.php?account=<?=$box_owner_obj->account?>"><?=$box_owner_obj->nickname;?></a>
                            </div>
                            <br class="clearboth" />
                        </div>
                        <br class="clearboth" />
                    </div>
                    <?
                       unset($box_item_obj);
                       unset($box_owner_obj); 
                       unset($item_obj);
                    }
                    mysql_free_result($query_box_item_result);
                    ?>
                    <div id="load_more_block">
                        <br class="clearboth" />
                        <div class="load_more_block">
                            <div class="load_more_text"><a onclick="loadItemMore('0','40')">看更多商品</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?
        unset($viewer_obj);
        ?>