<?php
require_once('/var/www/html/flea/flea_src/base_functions.php');
$type = '';
$i = '';
$s = '';
if(isset($_GET['type'])){
    $type = $_GET['type'];
}
if(isset($_GET['i'])){
    $i = $_GET['i'];
}
if(isset($_GET['s'])){
    $s = $_GET['s'];
}

$access_uri = SITE_URL."/api/facebook/facebook_login_action.php".
                    "?type=".$type."&i=".$i."&s=".$s;
$facebook_graph_auth_uri = "https://www.facebook.com/dialog/oauth?".
        "client_id=218582441497963".
        "&redirect_uri=".urlencode($access_uri).
        "&response_type=token".
        "&scope=publish_stream,create_event,offline_access,publish_checkins,email,user_about_me,".
        "user_activities,user_birthday,user_checkins,user_education_history,user_events,user_groups,".
        "user_interests,user_likes,user_work_history,user_online_presence,read_friendlists,friends_about_me,".
        "friends_activities,friends_birthday,friends_education_history,friends_events,".
        "friends_groups,friends_interests,friends_likes,friends_work_history,friends_online_presence";

/*                    
$facebook_graph_auth_uri = "https://graph.facebook.com/oauth/authorize?".
                    "client_id=218582441497963".
                    "&redirect_uri=".urlencode($access_uri).
                    "&scope=publish_stream,create_event,offline_access,email,user_about_me,".
                    "user_activities,user_birthday,user_education_history,user_events,user_groups,".
                    "user_interests,user_likes,user_work_history,read_friendlists,friends_about_me,".
                    "friends_activities,friends_birthday,friends_education_history,friends_events,".
                    "friends_groups,friends_interests,friends_likes,friends_work_history";*/
?>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>facebook auth</title>
  </head>
  <body>
    <!--
      We use the JS SDK to provide a richer user experience. For more info,
      look here: http://github.com/facebook/connect-js
    -->
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({appId: '218582441497963', status: true, cookie: true, xfbml: true});
        
        FB.getLoginStatus(function(response) {
            if (response.session){
                FB.Cookie.set(FB.getSession()); // hack: refresh session
                document.location="<?=$facebook_graph_auth_uri?>";
            } else {
                document.location="<?=$facebook_graph_auth_uri?>";
            }
        });
    };
    
    (function() {
        var e = document.createElement('script');
        e.type = 'text/javascript';
        e.src = document.location.protocol +
                '//connect.facebook.net/zh_TW/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
    </script>
  </body>
</html>