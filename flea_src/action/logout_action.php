<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $cookie_process = new FleaCookieProcess();
    $cookie_process->clear_cookie();
    header("Location: ".SITE_URL);
?>