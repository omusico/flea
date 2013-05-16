        <div id="content">
            <div class="inner">
                <?
                $dbc = connectdb();
                $owner_obj = new FleaUser($_GET['account'],'account');
                $viewer_obj = 'guest';
                if(!empty($_COOKIE['user_id'])){
                    $viewer_obj = new FleaUser($_COOKIE['user_id']);
                }
                ?>
                <div class="block _1u left">
                    <div id="user_page_side_block">
                        <div class="user_page_big_icon">
                            <span class="polaroids <?=rand_polaroids();?>">
                                <a href="/flea/user.php?account=<?=$owner_obj->account?>"><img id="user_icon" src="<?=$owner_obj->getUserIconRW('200');?>" width="200" /></a>
                            </span>
                        </div>
                        <br class="clearboth">
                        <h3 class="username"><a href="/flea/user.php?account=<?=$owner_obj->account?>"><?=$owner_obj->nickname;?></a></h3>
                        <dl>
                          <dt>加入時間:</dt><dd><?=$owner_obj->create_time;?></dd>
                        </dl>
                        <div class="hr_line"></div>
                        <div id="about_me_block">
                            <h4>關於我:</h4>
                            <?=$owner_obj->about_me;?>			
                        </div>
                        <div class="hr_line"></div>
                        <div class="user_page_side_like">
                            <fb:like href="<?=SITE_URL?>/user.php?account=<?=$owner_obj->account;?>" send="false" width="220" show_faces="true" font=""></fb:like>
                        </div>
                    </div>
                </div>
                <div class="block _3u right" style="width: 720px;">
                    <?
                    $query_box = "SELECT id FROM box WHERE owner_id='$owner_obj->id' AND is_deleted='0'";
                    $query_box_result = mysql_query($query_box, $dbc);
                    $box_exist_num = mysql_num_rows($query_box_result);
                    if($box_exist_num>0){
                    ?>
                    <h2>福利格子 <?=$owner_obj->account;?></h2>
                    <?
                        while ($query_box_result_data = mysql_fetch_array($query_box_result)) {
                            $box_obj = new FleaBox($query_box_result_data['id']);
                            ?>
                            <div id="box_block<?=$box_obj->id?>" class="box_block">
                                <div id="box_cover<?=$box_obj->id?>" class="box_cover_block">
                                    <img id="box_cover_img<?=$box_obj->id?>" src="<?=$box_obj->getBoxCoverR('640')?>" class="box_cover" width="570" />
                                </div>
                            </div>
                            <br class="clearboth" />
                            <h3>上架商品</h3>
                            <div id="box_items_block<?=$box_obj->id?>">
                                <?
                                $query_box_item = "SELECT bi.id,bi.item_id FROM box_item bi INNER JOIN item it ON (bi.item_id=it.id) WHERE bi.box_id='$box_obj->id' AND bi.type='normal' AND bi.status!='is_deleted' AND bi.status!='paid' AND it.is_deleted='0' ORDER BY bi.id DESC";
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
                            </div>
                            <?
                            unset($box_obj);
                        }
                        mysql_free_result($query_box_result);
                        ?>
                        <?
                    } else {
                    ?>
                    <h2>尚未有福利格子上架商品</h2>
                    <?
                    }
                    ?>
                </div>
                <br class="clearboth">
                <?
                unset($owner_obj);
                unset($dbc);
                ?>
            </div>
        </div>