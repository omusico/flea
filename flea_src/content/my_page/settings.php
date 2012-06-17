<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $user_obj = new FleaUser($_COOKIE['user_id']);
    $school_obj = new FleaSchool($user_obj->school_id);
    $dbc = connectdb();
    $birthday_array = explode('-',$user_obj->birthday);
?>
<h2>帳號設定</h2>
<div class="block _2u left">
    <div id="settings_form_block">
        <form method="post" id="settings_form" name="settings_form">
            <div class="textfield">
                <label for="invite_email">您的註冊信箱&nbsp;&nbsp;&nbsp;<?=$user_obj->invite_email;?></label>
            </div>
            <div class="textfield-half">
                <label for="account">帳號&nbsp;&nbsp;&nbsp;<?=$user_obj->account;?></label>
            </div>
            <div class="textfield-half">
                <label for="school">學校&nbsp;&nbsp;&nbsp;<?=$school_obj->title?></label>
            </div>
            <div class="textfield">
                <label for="department_id">系所</label>
                <select name="department_id" id="department_id" style="width:90%;">
                    <option value="0">請選擇:</option>
                    <? 
                        $query_school_department_group = mysql_query("SELECT id FROM school_department_group WHERE school_id = '$school_obj->id' AND is_deleted='0' ORDER BY ordernum",$dbc);
                        while ($query_school_department_group_data = mysql_fetch_array($query_school_department_group)) {
                            $school_department_group_obj = new FleaSchoolDepartmentGroup($query_school_department_group_data['id']);
                    ?>
                        <optgroup label="<?=$school_department_group_obj->title?>">
                            <?
                            $query_school_department = mysql_query("SELECT id FROM school_department WHERE school_id = '$school_obj->id' AND group_id='$school_department_group_obj->id' AND is_deleted='0' ORDER BY ordernum",$dbc);
                            while ($query_school_department_data = mysql_fetch_array($query_school_department)) {
                                $school_department_obj = new FleaSchoolDepartment($query_school_department_data['id']);
                            ?>
                            <option value="<?=$school_department_obj->id?>" <? if($school_department_obj->id==$user_obj->school_department_id){ echo 'selected="selected"'; } ?>><?=$school_department_obj->title?></option>
                            <?
                                unset($school_department_obj);
                            }
                            mysql_free_result($query_school_department);
                            ?>
                        </optgroup>
                    <?
                            unset($school_department_group_obj);
                        }
                        mysql_free_result($query_school_department_group);
                    ?>
                </select>
                <span id="department_id_error"></span>
            </div>
            <div class="textfield">
                <label for="nickname">暱稱</label>
                <input type="text" name="nickname" id="nickname" value="<?=$user_obj->nickname?>" class="text">
                <span id="nickname_error"></span>
            </div>
            <div class="textfield">
                <label for="email">連絡用電子郵件信箱</label>
                <input type="text" name="email" class="text" id="email" value="<?=$user_obj->email?>" onkeyup="check_email();">
                <span id="email_error"></span>
            </div>
            <div class="textfield-half">
                <label for="gender">性別</label>
                <select name="gender" id="gender" >
                    <option value="0">請選擇</option>
                    <option value="1" <? if($user_obj->gender=='1'){ echo 'selected="selected"'; } ?>>男性</option>
                    <option value="2" <? if($user_obj->gender=='2'){ echo 'selected="selected"'; } ?>>女性</option>
                </select>
                <span id="gender_error"></span>
            </div>
            <div class="textfield-half">
                <label>生日</label>
                <select name="birth_y" id="birth_y">
                    <option value="0">年:</option>
                    <? for($i=1998; $i>1931; $i--){ ?>
                    <option value="<?=$i?>" <? if($birthday_array[0]==$i){ echo 'selected="selected"'; } ?>><?=$i?></option>
                    <? } ?>
                </select>
                &nbsp;
                <select name="birth_m" id="birth_m">
                    <option value="0">月:</option>
                    <? 
                    for($i=1; $i<=12; $i++){ 
                        $month_value = $i;
                        if($i<10){
                            $month_value = '0'.$i;
                        }
                    ?>
                    <option value="<?=$month_value?>" <? if($birthday_array[1]==$month_value){ echo 'selected="selected"'; } ?>><?=$i?>月</option>
                    <? 
                    } 
                    ?>
                </select>
                &nbsp;
                <select name="birth_d" id="birth_d">
                    <option value="0">日:</option>
                    <? 
                    for($i=1; $i<=31; $i++){ 
                        $day_value = $i;
                        if($i<10){
                            $day_value = '0'.$i;
                        }
                    ?>
                    <option value="<?=$day_value?>" <? if($birthday_array[2]==$day_value){ echo 'selected="selected"'; } ?>><?=$i?>日</option>
                    <? 
                    } 
                    ?>
                </select>
                <span id="birth_error"></span>
            </div>
            <br class="clearboth">
            <h4>您的真實姓名</h4>
            <div class="textfield-half">
                <label for="last_name">姓</label>
                <input type="text" name="last_name" id="last_name" value="<?=$user_obj->lastname?>" class="text">
                <span id="last_name_error"></span>
            </div>
            <div class="textfield-half">
                <label for="first_name">名</label>
                <input type="text" name="first_name" id="first_name" value="<?=$user_obj->firstname?>" class="text">
                <span id="first_name_error"></span>
            </div>
            <div class="textfield">
                <label for="contact_number">連絡電話</label>
                <input type="text" name="contact_number" id="contact_number" value="<?=$user_obj->contact_number?>" class="text">
            </div>
            <div class="textfield">
                <label for="about_me">簡介</label>
                <textarea style="width:90%;" rows="7" cols="40" name="about_me" id="about_me"><?=$user_obj->about_me?></textarea>
            </div>
            <br class="clearboth">
            <br class="clearboth">
            <div>
                <input type="button" value="更新" name="button" onclick="settings_validate();" class="TBbtn butt">
            </div>
            <br class="clearboth">
        </form>	
    </div>
</div>
<div class="block _1u right">
    <div id="user_icon_block">
        <span class="polaroids"><img id="user_icon" src="<?=$user_obj->getUserIcon('200');?>" width="200" /></span>
        <br class="clearboth">
        <div id="file_uplaoder">
            <h3>更換大頭照</h3>
            <p>
                <input id="files-upload" accept="image/*" type="file" multiple />
            </p>
            <p id="drop-area">
                <span class="drop-instructions">或直接拖放圖片到此以上傳圖片</span>
                <span class="drop-over">已放入圖片!</span>
            </p>
            <div id="file-list">
            </div>
        </div>
        <? require_once('/var/www/html/flea/js/html5_uploader_js.php');?>
        <br class="clearboth">
        <? 
        if(!empty($user_obj->fb_id)){
            $facebook_data_obj = json_decode($user_obj->fb_profile);
        ?>
        <div id="fb_connect_block">
			<h3>臉書連結</h3>
            <p>你的政!大福利市集目前與臉書帳號連結:</p>
            <div class="fb_inner_block">
                <div id="facebook_connect_profile_block">
                    <img src="http://graph.facebook.com/<?=$user_obj->fb_id?>/picture?type=square"> 
                    <a href="<?=$facebook_data_obj->link?>"><?=$user_obj->fb_name?></a>
                </div>
            </div>
        </div>
        <? } else { ?>
        <div class="fblogin_block">
            <h3><span>Facebook連結 </span><a id="fblogin_button" href="<?=SITE_URL?>/api/facebook/auth_facebook.php"></a></h3>
        </div>
        <? } ?>
        <br class="clearboth">
    </div>
    <br class="clearboth">
</div>
<div class="clearboth"></div>
<? } ?>