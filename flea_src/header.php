<?
    $current_page = $_SERVER['SCRIPT_NAME'];
    $current_page_para = $_SERVER['REQUEST_URI'];
    $mypage_array = array("/flea/my.php","/flea/register.php");
    $explorepage_array = array("/flea/explore.php","/flea/user.php","/flea/item.php");
    $user_obj = 'guest';
    if(!empty($_COOKIE['user_id'])){
        $user_obj = new FleaUser($_COOKIE['user_id']);
    }
?>        
        <div id="<? if($current_page=='/flea/index.php'){ echo 'header'; } else { echo 'header_s'; } ?>">
            <div class="inner">
                <div id="logo"><a href="<?=SITE_URL;?>"><span>政!大福利市集</span></a></div>
                <div id="user-status">
                    <p>
                        <!--<a href="#" id="fblogin_button_s"></a>-->
                        <? if($user_obj=='guest'){ ?>
                        <a href="#" onclick="call_invite_box()">申請帳戶</a> | 
                        <a href="#" onclick="call_login_box('&redirect=<?=$current_page?>')">登入</a>
                        <? } else { ?>
                        <a href="/flea/user.php?account=<?=$user_obj->account?>"><img width="18px" src="<?=$user_obj->getUserIcon();?>" style="padding: 0px 5px 5px 0px;"></a>
                        <a href="/flea/user.php?account=<?=$user_obj->account?>" id="member_btn"><?=$user_obj->nickname;?> </a> | 
                        <a href="<?=SITE_URL?>/flea_src/action/logout_action.php">登出</a>
                        <? } ?>
                    </p>
                </div>
                <div id="nav">
                    <ul>
                        <li id="home"><a href="<?=SITE_URL;?>" class="<? if($current_page=='/flea/index.php'){echo 'active';} ?>"><span>Home</span></a></li>
                        <li id="explore"><a href="<?=SITE_URL;?>/explore.php" class="<? if(in_array($current_page,$explorepage_array)){echo 'active';} ?>"><span>Explore</span></a></li>
                        <li id="about"><a href="<?=SITE_URL;?>/about.php" class="<? if($current_page=='/flea/about.php'){echo 'active';} ?>"><span>About</span></a></li>
                        <? if($user_obj=='guest'){ ?>
                        <li id="myfleabox"><a onclick="call_login_box('&redirect=<?=$current_page?>');" class="<? if(in_array($current_page,$mypage_array)){echo 'active';} ?>"><span>my Fleabox</span></a></li>
                        <? } else { ?>
                        <li id="myfleabox"><a href="<?=SITE_URL;?>/my.php" class="<? if(in_array($current_page,$mypage_array)){echo 'active';} ?>"><span>my Fleabox</span></a></li>
                        <? } ?>
                    </ul>
                </div>
                <br class="clearboth">
            </div>
        </div>
        <? 
        if($current_page=='/flea/index.php'){
            $dbc = connectdb();
            $query_box_all = mysql_query("SELECT b.id FROM box b INNER JOIN box_item bi ON (b.id=bi.box_id) INNER JOIN item i  ON (bi.item_id=i.id)  WHERE b.is_deleted='0' AND b.is_released='1' AND bi.status='for_sale' AND i.is_deleted='0' GROUP BY b.id  ORDER BY b.update_time DESC",$dbc);
            $total_box_num = mysql_num_rows($query_box_all);
            mysql_free_result($query_box_all);
        ?>
        <div id="feature_block">
            <div class="inner">
                <div id="shelf_block">
                    <div id="shelf">
                        <img src="<?=SITE_URL;?>/images/slide/new-ribbon.png" width="112" height="112" alt="New Ribbon" id="ribbon">
                        <div id="slides">
                            <div class="slides_container">
                                <div class="slide_boxf">
                                </div>
                                <?
                                    if($total_box_num>0){
                                ?>
                                <div class="slide_box">
                                    <?
                                    $query_box = mysql_query("SELECT b.id FROM box b INNER JOIN box_item bi ON (b.id=bi.box_id) INNER JOIN item i  ON (bi.item_id=i.id)  WHERE b.is_deleted='0' AND b.is_released='1' AND bi.status='for_sale' AND i.is_deleted='0' GROUP BY b.id  ORDER BY b.update_time DESC LIMIT 0,8",$dbc);
                                    while ($query_box_data = mysql_fetch_array($query_box)) {
                                        $box_obj = new FleaBox($query_box_data['id']);
                                        $owner_obj = new FleaUser($box_obj->owner_id);
                                    ?>
                                        <div id="header_box_block<?=$box_obj->id?>" class="header_box_block">
                                            <a href="/flea/user.php?account=<?=$owner_obj->account?>"><img id="header_box_cover<?=$box_obj->id?>" src="<?=$box_obj->getBoxCoverR('300')?>" width="220" height="220" onmouseover="setInfo_none('<?=$box_obj->id?>');" onmouseout="setInfo_diplay('<?=$box_obj->id?>');" /></a>
                                            <div class="header_box_block_info" id="header_box_block_info<?=$box_obj->id?>">
                                                <!--<div id="owner"><img src="<?=$owner_obj->getUserIcon('18')?>" /></div>-->
                                                <span class="title"><?=$box_obj->title?></span>
                                            </div>
                                        </div>
                                    <?
                                        unset($owner_obj);
                                        unset($box_obj);
                                    }
                                    mysql_free_result($query_box);
                                    ?>
                                    <br class="clearboth">
                                </div>
                                <? } ?>
                                <?
                                    if($total_box_num>8){
                                ?>
                                <div class="slide_box">
                                    <?
                                    $query_box = mysql_query("SELECT id FROM box WHERE is_deleted='0' AND is_released='1' ORDER BY update_time DESC LIMIT 8,8",$dbc);
                                    while ($query_box_data = mysql_fetch_array($query_box)) {
                                        $box_obj = new FleaBox($query_box_data['id']);
                                        $owner_obj = new FleaUser($box_obj->owner_id);
                                    ?>
                                        <div id="header_box_block<?=$box_obj->id?>" class="header_box_block">
                                            <a href="/flea/user.php?account=<?=$owner_obj->account?>"><img id="header_box_cover<?=$box_obj->id?>" src="<?=$box_obj->getBoxCoverR('300')?>" width="220" height="220" onmouseover="setInfo_none(<?=$box_obj->id?>);" onmouseout="setInfo_diplay(<?=$box_obj->id?>);" /></a>
                                            <div class="header_box_block_info" id="header_box_block_info<?=$box_obj->id?>">
                                                <!--<div id="owner"><img src="<?=$owner_obj->getUserIcon('18')?>" /></div>-->
                                                <span class="title"><?=$box_obj->title?></span>
                                            </div>
                                        </div>
                                    <?
                                        unset($owner_obj);
                                        unset($box_obj);
                                    }
                                    mysql_free_result($query_box);
                                    ?>
                                    <br class="clearboth">
                                </div>
                                <? } ?>
                                <?
                                    if($total_box_num>16){
                                ?>
                                <div class="slide_box">
                                    <?
                                    $query_box = mysql_query("SELECT id FROM box WHERE is_deleted='0' AND is_released='1' ORDER BY update_time DESC LIMIT 16,8",$dbc);
                                    while ($query_box_data = mysql_fetch_array($query_box)) {
                                        $box_obj = new FleaBox($query_box_data['id']);
                                        $owner_obj = new FleaUser($box_obj->owner_id);
                                    ?>
                                        <div id="header_box_block<?=$box_obj->id?>" class="header_box_block">
                                            <a href="/flea/user.php?account=<?=$owner_obj->account?>"><img id="header_box_cover<?=$box_obj->id?>" src="<?=$box_obj->getBoxCoverR('300')?>" width="220" height="220" onmouseover="setInfo_none(<?=$box_obj->id?>);" onmouseout="setInfo_diplay(<?=$box_obj->id?>);" /></a>
                                            <div class="header_box_block_info" id="header_box_block_info<?=$box_obj->id?>">
                                                <!--<div id="owner"><img src="<?=$owner_obj->getUserIcon('18')?>" /></div>-->
                                                <span class="title"><?=$box_obj->title?></span>
                                            </div>
                                        </div>
                                    <?
                                        unset($owner_obj);
                                        unset($box_obj);
                                    }
                                    mysql_free_result($query_box);
                                    ?>
                                    <br class="clearboth">
                                </div>
                                <? } ?>
                            </div>
                            <a href="#" class="prev"><img src="<?=SITE_URL;?>/images/slide/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
                            <a href="#" class="next"><img src="<?=SITE_URL;?>/images/slide/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
                        </div>
                        <img src="<?=SITE_URL;?>/images/slide/example-frame.png" width="1184" height="542" alt="Example Frame" id="frame">
                    </div>
                </div>
            </div>
        </div>
        <div id="top_shade"></div>
        <? 
        } 
        ?>