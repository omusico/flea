        <div id="content">
            <div class="inner">
                <?
                $dbc = connectdb();
                $item_obj = new FleaTransactionItem($_GET['item_id']);
                $owner_obj = new FleaUser($item_obj->owner_id);
                $box_item_obj = new FleaBoxItem($_GET['box_item_id']);
                $method_obj = new FleaTransactionMethod($item_obj->method_id);
                $school_obj = new FleaSchool($item_obj->school_id);
                $location_obj = new FleaSchoolLocation($item_obj->school_location_id);
                
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
                    <h2><?=$item_obj->title?></h2>
                    <h3><a href="/flea/user.php?account=<?=$owner_obj->account?>">回到福利格子 <?=$owner_obj->account;?></a></h3>
                    <div class="item_page_icon">
                        <div class="restrict_block">
                            <span class="polaroids">
                                <img id="item_icon" src="<?=$item_obj->getItemIconRW('500');?>" />
                            </span>
                        </div>
                    </div>
                    <br class="clearboth">
                    <div id="buy_item_info_block">
                        <div id="item_sub">
                            <div id="title"><h2><?=$item_obj->title?></h2></div>
                            <div class="left" id="price">
                                <h4>價格</h4>
                                <div id="price_text">$ <?=$item_obj->price?></div>
                                <div class="func_block">
                                <?
                                if($box_item_obj->status=='for_sale'){
                                    if($viewer_obj=='guest'){
                                    ?>
                                    <a onclick="call_login_box()"><span>購買</span></a>
                                    <?
                                    } else {
                                        echo $viewer_obj->getBoxItemBuyBtn('small',$item_obj->id,$box_item_obj->id);
                                    }
                                }
                                ?>
                                </div>
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
                            <div class="left" id="item_content_block">
                                <?=$item_obj->content?>
                            </div>
                            <div class="clearboth"></div>
                        </div>
                    </div>
                    <div class="clearboth"></div>
                    <div class="user_page_item_like">
                        <fb:like href="<?=SITE_URL;?>/item.php?item_id=<?=$item_obj->id?>&box_item_id=<?=$box_item_obj->id?>" send="false" width="720" show_faces="true" font=""></fb:like>
                    </div>
                    <div class="clearboth"></div>
                    <fb:comments href="<?=SITE_URL?>/item.php?item_id=<?=$item_obj->id?>&amp;box_item_id=<?=$box_item_obj->id?>" num_posts="10" width="720"></fb:comments>
                    <div class="clearboth"></div>
                </div>
                <br class="clearboth">
                <?
                unset($viewer_obj);
                unset($item_obj);
                unset($owner_obj);
                unset($box_item_obj);
                unset($dbc);
                ?>
            </div>
        </div>