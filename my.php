<?
require_once('flea_src/base_functions.php');
if(!empty($_COOKIE['user_id'])){

    require_once('flea_src/head.php');
    ?>  
        <div id="wrapper">
            <?
            require_once('flea_src/header.php');
            ?>
            <?
            require_once('flea_src/content/my.php');
            ?>
            <?
            require_once('flea_src/footer.php');
            ?>
        </div>
    <?
    require_once('flea_src/script_manager.php');

} else {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".SITE_URL."/hint.php?mid=login_require");
}
?>      
