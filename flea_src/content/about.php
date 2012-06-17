        <?
        $dbc = connectdb();
        ?>
        <div id="content">
            <div class="inner">
                <div class="block _3u left">
                    <h2>關於我們 - 政!大福利市集團隊</h2>
                    <div id="about_blcok">
                        <h3>Welcome Flea!</h3>
                        <p>『政！大福利市集』是政大學生的專屬市集。在這裡你(妳)有自己的櫃子，風格自由佈置、打點，販售你(妳)的商品無論是流行單品、實用設計、二手寶貝、團購好物或是獨一無二的創意手工製品。這是屬於政大學生的交易分享平台，實用與挖寶兼具的社群買賣生活圈。想知道有什麼好康嗎？快來尋找驚喜吧！</p>
                        <h3>關於創辦人 Ane/Fukuball/Jin</h3>
                        <p>企劃、設計與程式，三個不同邏輯的腦袋，兜在一起會產生甚麼樣的化學作用？反應過程是雞同鴨講，是天馬行空，是僵持不下，是可能無限。對數位內容的好奇與網路應用的熱情是我們的共同語言，在政大的好多山好多水的工作環境，畫下未來生活的一篇篇草圖。<br/><br/>如果你(妳)對『政！大福利市集』有任何興趣、疑惑、非說不可的建議，歡迎隨時<a href="<?=SITE_URL;?>/about.php">與我們連絡</a>！</p>
                    </div>
                    <h3>共同創辦人</h3>
                    <?
                    $query_auth_user = mysql_query("SELECT id FROM user WHERE auth_id = '99' ORDER BY nickname",$dbc);
                    while ($query_auth_user_data = mysql_fetch_array($query_auth_user)) {
                        $user_obj = new FleaUser($query_auth_user_data['id']);
                        $school_obj = new FleaSchool($user_obj->school_id);
                        $school_dep_obj = new FleaSchoolDepartment($user_obj->school_department_id);
                        ?>
                        <div class="auth_user_block">
                            <div class="auth_user_icon_block left">
                                <span class="polaroids <?=rand_polaroids();?>"><a href="/flea/user.php?account=<?=$user_obj->account?>"><img id="user_icon" src="<?=$user_obj->getUserIcon('200');?>" width="200" /></a></span>
                            </div>
                            <div class="auth_user_des_block right">
                                <h3><a href="/flea/user.php?account=<?=$user_obj->account?>"><?=$user_obj->nickname;?></a></h3>
                                <h3><?=$school_obj->title?> <?=$school_dep_obj->title?></h3>
                                <p>
                                    <?=$user_obj->about_me;?>
                                </p>
                            </div>
                            <br class="clearboth">
                        </div>
                        <?
                        unset($user_obj);
                    }
                    mysql_free_result($query_auth_user);
                    ?>
                    <br class="clearboth">
                    <fb:comments href="http://dctlab.nccu.edu.tw/flea/about.php" num_posts="5" width="700"></fb:comments>
                </div>
                <div class="block _1u right">
                    <iframe src="http://www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D218582441497963&amp;width=220&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=true&amp;header=true&amp;height=427" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:220px; height:427px;" allowTransparency="true"></iframe>
                    <br class="clearboth">
                    <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fdct.nccu&amp;width=220&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=true&amp;header=true&amp;height=427" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:220px; height:427px;" allowTransparency="true"></iframe>
                    <br class="clearboth">
                </div>
                <br class="clearboth">
            </div>
        </div>
        <?
        unset($dbc);
        ?>