        <div id="content">
            <div class="inner">
                <div class="error_page">
                    <img src="http://dctlab.nccu.edu.tw/flea/images/bg-404.gif" alt="404">
                    <div id="pagenotfound_block">
                        <h1>服務訊息</h1>
                        <p>
                            <?
                            $mid = $_GET['mid'];
                            switch($mid){
                                case 'account_exist':
                                    echo "您的email已經註冊過，請直接登入即可。";
                                break;
                                case 'login_require':
                                    echo "請登入以使用此功能。";
                                break;
                                case 'is_verify':
                                    echo "此邀請函已註冊過，請您使用已註冊好的帳號登入。";
                                break;
                                default:
                                    echo "發生未知錯誤。";
                                break;
                            }
                            ?>
                        </p>
                        <p><a href="http://dctlab.nccu.edu.tw/flea">回到首頁</a></p>
                    </div>
                </div>
            </div>
        </div>