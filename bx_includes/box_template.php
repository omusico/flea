<?
require_once('/var/www/html/flea/flea_src/base_functions.php');
//$email = $_COOKIE ['email'];
?>
<div id="box_content">
<?
    $include = $_GET['include'];
    require_once('/var/www/html/flea/bx_includes/'.$include);
?>
</div>
