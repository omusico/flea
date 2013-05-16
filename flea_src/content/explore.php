        <?
        $dbc = connectdb();
        ?>
        <div id="content">
            <div class="inner">
                <div class="block _1u left" id="explore_class">
                    <ul class="menu">
                        <li>
                            <a href="#"><h3>福利格子分類瀏覽</h3></a>
                            <ul class="acitem">
                                <li><a onclick="loadExploreBox('0','0');">最新福利格子</a></li>
                                <li><a onclick="loadExploreBox('1','0');">政治大學格子</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><h3>福利商品分類瀏覽</h3></a>
                            <ul class="acitem">
                                <li><a onclick="loadExploreItem('0','0');">最新福利商品</a></li>
                                <?
                                $query_category = mysql_query("SELECT id FROM category WHERE is_deleted='0' ORDER BY ordernum",$dbc);
                                while ($query_category_data = mysql_fetch_array($query_category)) {
                                    $category_obj = new FleaCategory($query_category_data['id']);
                                ?>
                                <li><a onclick="loadExploreItem('<?=$category_obj->id?>','0');"><?=$category_obj->title?></a></li>
                                <? 
                                    unset($category_obj);
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                    <br class="clearboth">
                    <iframe src="http://www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D218582441497963&amp;width=220&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=true&amp;header=true&amp;height=427" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:220px; height:427px;" allowTransparency="true"></iframe>
                    <br class="clearboth">
                </div>
                <div id="explore_content" class="block _3u right" style="width: 720px;">
                    <form class="searchform"> 
                        <input id="explore_search_input" class="searchfield" type="text" value="Search..." onfocus="if (this.value == 'Search...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search...';}" /> 
                        <input class="searchbutton" type="button" value="Go" onclick="search_explore();" /> 
                    </form> 
                    <br class="clearboth">
                    <div id="explore_result">
                        <h2>最新福利格子</h2>
                        <?
                        $query_box = mysql_query("SELECT id FROM box WHERE is_deleted='0' AND is_released='1' ORDER BY update_time DESC LIMIT 0,10",$dbc);
                        while ($query_box_data = mysql_fetch_array($query_box)) {
                            $box_obj = new FleaBox($query_box_data['id']);
                            $owner_obj = new FleaUser($box_obj->owner_id);
                            ?>
                            <div class="explore_box_main_block left">
                                <div id="explore_box_block<?=$box_obj->id?>" class="explore_box_block">
                                    <a href="/flea/user.php?account=<?=$owner_obj->account?>"><img id="explore_box_cover<?=$box_obj->id?>" src="<?=$box_obj->getBoxCoverR('300')?>" width="300" height="300" onmouseover="seteInfo_none('<?=$box_obj->id?>');" onmouseout="seteInfo_diplay('<?=$box_obj->id?>');" /></a>
                                    <div class="explore_box_block_info" id="explore_box_block_info<?=$box_obj->id?>">
                                        <!--<div id="owner"><img src="<?=$owner_obj->getUserIcon('18')?>" /></div>-->
                                        <span class="title"><?=$box_obj->title?></span>
                                    </div>
                                </div>
                                <div class="owner_block">
                                    <div class="left">
                                        <a href="/flea/user.php?account=<?=$owner_obj->account?>"><img src="<?=$owner_obj->getUserIcon('25');?>" /></a>
                                    </div>
                                    <div class="user_info left">
                                        <a href="/flea/user.php?account=<?=$owner_obj->account?>"><?=$owner_obj->nickname;?></a>
                                    </div>
                                    <br class="clearboth" />
                                </div>
                            </div>
                            <?
                            unset($owner_obj);
                            unset($box_obj);
                        }
                        mysql_free_result($query_box);
                        ?>
                        <div id="load_more_block">
                        <br class="clearboth" />
                        <div class="load_more_block">
                            <div class="load_more_text"><a onclick="loadExploreBox('0','10')">看更多商品</a></div>
                        </div>
                    </div>
                    </div>
                    <br class="clearboth">
                </div>
                <br class="clearboth">
            </div>
        </div>
        <?
        unset($dbc);
        ?>