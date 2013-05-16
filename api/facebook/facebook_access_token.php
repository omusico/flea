<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $type = $_GET['type'];
    $access_uri = SITE_URL."/api/facebook/facebook_login_action.php".
                    "?type=".$type;
?>
<script>
    var anchorValue;
    var url = document.location;
    var strippedUrl = url.toString().split("#");
    if(strippedUrl.length > 1) {
        anchorvalue = strippedUrl[1];
        var facebook_return_value = anchorvalue.split("&");
        var access_token_array = facebook_return_value[0].split("=");
        var access_token = access_token_array[1];
        document.location="<?=$facebook_graph_auth_login_uri?>";
    }
</script>