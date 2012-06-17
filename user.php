<?
require_once('flea_src/base_functions.php');
 
if(!empty($_GET['account'])){
    $dbc = connectdb();
    $account = $_GET['account'];
    $query_user_result = mysql_query("SELECT * FROM user WHERE account='$account' LIMIT 1",$dbc);
    $user_exist_num = mysql_num_rows($query_user_result);
    mysql_free_result($query_user_result);
    if($user_exist_num>0){
        require_once('flea_src/head.php');
        ?>  
            <div id="wrapper">
                <?
                require_once('flea_src/header.php');
                ?>
                <?
                require_once('flea_src/content/user.php');
                ?>
                <?
                require_once('flea_src/footer.php');
                ?>
            </div>
        <?
        require_once('flea_src/script_manager.php');  
        
    } else {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".SITE_URL."/404.php");
    }
} else {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".SITE_URL."/404.php");
}


