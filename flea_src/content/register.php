        <div id="content">
            <div class="inner">
                <h2>註冊/基本資料填寫</h2>
                <? 
                    $email_array = explode('@',$invite_email);
                    $user_temp_account = $email_array[0];
                    $school_obj = new FleaSchool($email_array[1],'domain'); 
                ?>
                <div class="block _3u left">
                    <h3>現在就加入我們的行列！</h3>
                    <h3>方法一</h3>
                    <div class="fblogin_block">
                        <h3><span>使用Facebook進行註冊 </span><a id="fblogin_button" href="<?=SITE_URL?>/api/facebook/auth_facebook.php?i=<?=$invitation_id;?>&s=<?=$verify_code;?>"></a></h3>
                    </div>
                    <div class="service-des">
                        推薦您使用Facebook進行註冊，使用Facebook註冊可以擁用許多強大的功能，也可以得到更多的樂趣，坐擁Facebook的人氣也為您的Flea帶來錢氣!
                    </div>
                    <br class="clearboth">
                    <h3>方法二</h3>
                    <div class="signupform_btn_block">
                        <h3><span>自行填寫資料進行註冊 </span><a id="signupform_btn_button" href="#"></a></h3>
                    </div>
                    <div class="service-des">
                        尚無Facebook帳號的朋友可以自行填寫註冊表單以取得帳戶，雖然步驟較為繁瑣，但詳細的資料才能讓您的物品交易有保障喔!
                    </div>
                    <div id="signup_form_block">
                        <h4>請填寫以下必填欄位：</h4>
                        <form method="post" action="<?=SITE_URL?>/flea_src/action/register_action.php" id="signup_form" name="signup_form">
                            <input type="hidden" name="invite_email" value="<?=$invite_email;?>" />
                            <input type="hidden" name="invitation_id" value="<?=$invitation_id;?>" />
                            <input type="hidden" name="verify_code" value="<?=$verify_code;?>" />
                            <div class="textfield-half">
                                <label for="account">帳號&nbsp;&nbsp;&nbsp;<?=$user_temp_account;?></label>
                                <input type="hidden" name="account" value="<?=$user_temp_account;?>" />
                            </div>
                            <div class="textfield-half">
                                <label for="school">學校&nbsp;&nbsp;&nbsp;<?=$school_obj->title?></label>
                                <input type="hidden" name="school_id" value="<?=$school_obj->id?>" />
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
                                            <option value="<?=$school_department_obj->id?>"><?=$school_department_obj->title?></option>
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
                                <input type="text" name="nickname" id="nickname" class="text">
                                <span id="nickname_error"></span>
                            </div>
                            <div class="textfield">
                                <label for="email">連絡用電子郵件信箱</label>
                                <input type="text" name="email" class="text" id="email" value="<?=$invite_email?>" onkeyup="check_email();">
                                <span id="email_error"></span>
                            </div>
                            <div class="textfield">
                                <label for="password1">密碼</label>
                                <input type="password" name="password1" id="password1" class="text" onkeyup="check_passwrd1();">
                                <span id="password1_error"></span>
                            </div>
                            <div class="textfield">
                                <label for="password2">密碼確認</label>
                                <input type="password" name="password2" id="password2" class="text" onkeyup="check_passwrd2();">
                                <span id="password2_error"></span>
                            </div>
                            <div class="textfield-half">
                                <label for="gender">性別</label>
                                <select name="gender" id="gender" >
                                    <option value="0">請選擇</option>
                                    <option value="1">男性</option>
                                    <option value="2">女性</option>
                                </select>
                                <span id="gender_error"></span>
                            </div>
                            <div class="textfield-half">
                                <label>生日</label>
                                <select name="birth_y" id="birth_y">
                                    <option value="0">年:</option>
                                    <option value="1998">1998</option>
                                    <option value="1997">1997</option>
                                    <option value="1996">1996</option>
                                    <option value="1995">1995</option>
                                    <option value="1994">1994</option>
                                    <option value="1993">1993</option>
                                    <option value="1992">1992</option>
                                    <option value="1991">1991</option>
                                    <option value="1990">1990</option>
                                    <option value="1989">1989</option>
                                    <option value="1988">1988</option>
                                    <option value="1987">1987</option>
                                    <option value="1986">1986</option>
                                    <option value="1985">1985</option>
                                    <option value="1984">1984</option>
                                    <option value="1983">1983</option>
                                    <option value="1982">1982</option>
                                    <option value="1981">1981</option>
                                    <option value="1980">1980</option>
                                    <option value="1979">1979</option>
                                    <option value="1978">1978</option>
                                    <option value="1977">1977</option>
                                    <option value="1976">1976</option>
                                    <option value="1975">1975</option>
                                    <option value="1974">1974</option>
                                    <option value="1973">1973</option>
                                    <option value="1972">1972</option>
                                    <option value="1971">1971</option>
                                    <option value="1970">1970</option>
                                    <option value="1969">1969</option>
                                    <option value="1968">1968</option>
                                    <option value="1967">1967</option>
                                    <option value="1966">1966</option>
                                    <option value="1965">1965</option>
                                    <option value="1964">1964</option>
                                    <option value="1963">1963</option>
                                    <option value="1962">1962</option>
                                    <option value="1961">1961</option>
                                    <option value="1960">1960</option>
                                    <option value="1959">1959</option>
                                    <option value="1958">1958</option>
                                    <option value="1957">1957</option>
                                    <option value="1956">1956</option>
                                    <option value="1955">1955</option>
                                    <option value="1954">1954</option>
                                    <option value="1953">1953</option>
                                    <option value="1952">1952</option>
                                    <option value="1951">1951</option>
                                    <option value="1950">1950</option>
                                    <option value="1949">1949</option>
                                    <option value="1948">1948</option>
                                    <option value="1947">1947</option>
                                    <option value="1946">1946</option>
                                    <option value="1945">1945</option>
                                    <option value="1944">1944</option>
                                    <option value="1943">1943</option>
                                    <option value="1942">1942</option>
                                    <option value="1941">1941</option>
                                    <option value="1940">1940</option>
                                    <option value="1939">1939</option>
                                    <option value="1938">1938</option>
                                    <option value="1937">1937</option>
                                    <option value="1936">1936</option>
                                    <option value="1935">1935</option>
                                    <option value="1934">1934</option>
                                    <option value="1933">1933</option>
                                    <option value="1932">1932</option>
                                </select>
                                &nbsp;
                                <select name="birth_m" id="birth_m">
                                    <option value="0">月:</option>
                                    <option value="01">1月</option>
                                    <option value="02">2月</option>
                                    <option value="03">3月</option>
                                    <option value="04">4月</option>
                                    <option value="05">5月</option>
                                    <option value="06">6月</option>
                                    <option value="07">7月</option>
                                    <option value="08">8月</option>
                                    <option value="09">9月</option>
                                    <option value="10">10月</option>
                                    <option value="11">11月</option>
                                    <option value="12">12月</option>
                                </select>
                                &nbsp;
                                <select name="birth_d" id="birth_d">
                                    <option value="0">日:</option>
                                    <option value="01">1日</option>
                                    <option value="02">2日</option>
                                    <option value="03">3日</option>
                                    <option value="04">4日</option>
                                    <option value="05">5日</option>
                                    <option value="06">6日</option>
                                    <option value="07">7日</option>
                                    <option value="08">8日</option>
                                    <option value="09">9日</option>
                                    <option value="10">10日</option>
                                    <option value="11">11日</option>
                                    <option value="12">12日</option>
                                    <option value="13">13日</option>
                                    <option value="14">14日</option>
                                    <option value="15">15日</option>
                                    <option value="16">16日</option>
                                    <option value="17">17日</option>
                                    <option value="18">18日</option>
                                    <option value="19">19日</option>
                                    <option value="20">20日</option>
                                    <option value="21">21日</option>
                                    <option value="22">22日</option>
                                    <option value="23">23日</option>
                                    <option value="24">24日</option>
                                    <option value="25">25日</option>
                                    <option value="26">26日</option>
                                    <option value="27">27日</option>
                                    <option value="28">28日</option>
                                    <option value="29">29日</option>
                                    <option value="30">30日</option>
                                    <option value="31">31日</option>
                                </select>
                                <span id="birth_error"></span>
                            </div>
                            <br class="clearboth">
                            <h4>您的真實姓名</h4>
                            <div class="textfield-half">
                                <label for="last_name">姓</label>
                                <input type="text" name="last_name" id="last_name" class="text">
                                <span id="last_name_error"></span>
                            </div>
                            <div class="textfield-half">
                                <label for="first_name">名</label>
                                <input type="text" name="first_name" id="first_name" class="text">
                                <span id="first_name_error"></span>
                            </div>
                            <br class="clearboth">
                            <br class="clearboth">
                            <div>
                                <input type="submit" value="註冊" name="submit" class="TBbtn butt">
                            </div>
                            <br class="clearboth">
                        </form>	
                    </div>
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