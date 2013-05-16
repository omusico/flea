<?
require_once('flea_src/base_functions.php');
if(!empty($_COOKIE['user_id'])){
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".SITE_URL."/my.php");
} else {
    if(isset($_GET['i'])&&isset($_GET['s'])&&!empty($_GET['i'])&&!empty($_GET['s'])){
        
        $invitation_id = $_GET['i'];
        $verify_code = $_GET['s'];
        $dbc = connectdb();
        $query_invitaiton = "SELECT invite_email,is_verify FROM invitation WHERE id='$invitation_id' AND verify_code='$verify_code'";
        $query_invitaiton_result = mysql_query($query_invitaiton, $dbc);
        $invite_email = '';
        $is_verify = 0;
        while ($query_invitaiton_result_data = mysql_fetch_array($query_invitaiton_result)) {
            $invite_email = $query_invitaiton_result_data['invite_email'];
            $is_verify = $query_invitaiton_result_data['is_verify'];
        }
        $invitation_exist_num = mysql_num_rows($query_invitaiton_result);
        mysql_free_result($query_invitaiton_result);

        if($invitation_exist_num>0) {
        
            if($is_verify==0){ 
        
                require_once('flea_src/head.php');
            ?>  
                <div id="wrapper">
                    <?
                    require_once('flea_src/header.php');
                    ?>
                    <?
                    require_once('flea_src/content/register.php');
                    ?>
                    <?
                    require_once('flea_src/footer.php');
                    ?>
                </div>
            <?
                require_once('flea_src/script_manager.php');
            } else {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".SITE_URL."/hint.php?mid=is_verify");
            }
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".SITE_URL."/404.php");
        }
    } else {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".SITE_URL."/404.php");
    }
}
?>      
