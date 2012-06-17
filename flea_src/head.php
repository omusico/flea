<?
    $current_page = $_SERVER['SCRIPT_NAME'];
?>
<!DOCTYPE html>
<html xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>政!大福利市集</title>
        <meta name="description" content="NCCU Flea Market" />
        <meta property="fb:app_id" content="218582441497963" />
        <? 
        if($current_page=='/flea/user.php'&&!empty($_GET['account'])){
            $owner_obj = new FleaUser($_GET['account'],'account');
        ?>
        <meta property="og:title" content="<?=$owner_obj->nickname?> 的福利市集" />
        <meta property="og:site_name" content="<?=$owner_obj->nickname?> 的福利市集 from NCCU Flea Market" />
        <meta property="og:type" content="author" />
        <meta property="og:description" content="<?=$owner_obj->about_me?>" />
        <meta property="og:url" content="<?=SITE_URL;?>/user.php?account=<?=$owner_obj->account?>" />
        <meta property="og:image" content="<?=$owner_obj->getUserIcon('300')?>" />
        <? 
            unset($owner_obj);
        } else if($current_page=='/flea/item.php'&&!empty($_GET['item_id'])&&!empty($_GET['box_item_id'])) {
              $item_obj = new FleaTransactionItem($_GET['item_id']);
              $owner_obj = new FleaUser($item_obj->owner_id);
        ?>
        <meta property="og:title" content="<?=$item_obj->title?> from <?=$owner_obj->nickname?>" />
        <meta property="og:site_name" content="<?=$owner_obj->nickname?> 的福利市集 from NCCU Flea Market" />
        <meta property="og:type" content="product" />
        <meta property="og:description" content="<?=$owner_obj->about_me?>" />
        <meta property="og:url" content="<?=SITE_URL;?>/item.php?item_id=<?=$_GET['item_id']?>&box_item_id=<?=$_GET['box_item_id']?>" />
        <meta property="og:image" content="<?=$item_obj->getItemIcon('300')?>" />
        <?
            unset($owner_obj);
            unset($item_obj);
        } else { 
        ?>
        <meta property="og:title" content="政!大福利市集" />
        <meta property="og:site_name" content="NCCU Flea Market" />
        <meta property="og:type" content="company" />
        <meta property="og:description" content="NCCU Flea Market" />
        <meta property="og:url" content="<?=SITE_URL;?>" />
        <meta property="og:image" content="<?=SITE_URL;?>/images/logo.png" />
        <? 
        } 
        ?>
        <link rel="shortcut icon" type="image/x-icon" href="/flea/favicon.ico" />
        <link rel="icon" type="image/x-icon" href="/flea/favicon.ico" />
        <link href="<?=URL;?>/library/boxy-0.1.4/docs/stylesheets/boxy.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <link href="<?=SITE_URL;?>/style/base.css" rel="stylesheet" type="text/css" media="screen" />
    </head> 
    <body>
    <div id="fb-root"></div>