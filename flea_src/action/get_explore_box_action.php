<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');

    $dbc = connectdb();
    $school_id = $_GET['school_id'];
    $current_item = $_GET['current_item'];
    if(empty($current_item)){
        $current_item = 0;
    }
    
    $query_box = '';
    if($school_id=='0'){
        $query_box = "SELECT id FROM box WHERE is_deleted='0' AND is_released='1' ORDER BY update_time DESC";
    } else {
        $query_box = "SELECT b.id FROM box b INNER JOIN user u ON (b.owner_id=u.id) WHERE b.is_deleted='0' AND b.is_released='1' AND u.school_id='$school_id' ORDER BY b.update_time DESC";
    }
    $query_box_result = mysql_query($query_box, $dbc);
    $box_exist_num = mysql_num_rows($query_box_result);
    mysql_free_result($query_box_result);
    
    $query_box = $query_box." LIMIT $current_item,10";
    
    if($box_exist_num==0){
        if($current_item==0){
        ?>
        <h2>尚無任何福利格子</h2>
        <?
        }
    } else {
        $explore_title = '';
        if($school_id!=0){
            $school_obj = new FleaSchool($school_id);
            $explore_title = $school_obj->title;
            unset($school_obj);
        } else {
            $explore_title = '最新';
        }
        
        if($current_item==0){
        ?>
        <h2><?=$explore_title?>福利格子</h2>
        <?
        }
        $query_box_result = mysql_query($query_box, $dbc);
        while ($query_box_data = mysql_fetch_array($query_box_result)) {
            $box_obj = new FleaBox($query_box_data['id']);
            $owner_obj = new FleaUser($box_obj->owner_id);
        ?>
        <div class="explore_box_main_block left">
            <div id="explore_box_block<?=$box_obj->id?>" class="explore_box_block">
                <a href="/flea/user.php?user_id=<?=$owner_obj->id?>"><img id="explore_box_cover<?=$box_obj->id?>" src="<?=$box_obj->getBoxCoverR('300')?>" width="300" height="300" onmouseover="seteInfo_none('<?=$box_obj->id?>');" onmouseout="seteInfo_diplay('<?=$box_obj->id?>');" /></a>
                <div class="explore_box_block_info" id="explore_box_block_info<?=$box_obj->id?>">
                    <!--<div id="owner"><img src="<?=$owner_obj->getUserIcon('18')?>" /></div>-->
                    <span class="title"><?=$box_obj->title?></span>
                </div>
            </div>
            <div class="owner_block">
                <div class="left">
                    <a href="/flea/user.php?user_id=<?=$owner_obj->id?>"><img src="<?=$owner_obj->getUserIcon('25');?>" /></a>
                </div>
                <div class="user_info left">
                    <a href="/flea/user.php?user_id=<?=$owner_obj->id?>"><?=$owner_obj->nickname;?></a>
                </div>
                <br class="clearboth" />
            </div>
        </div>
        <?
            unset($owner_obj);
            unset($box_obj);
        }        
        mysql_free_result($query_box_result);
        if($box_exist_num>($current_item+10)){
        ?>
        <div id="load_more_block">
            <br class="clearboth" />
            <div class="load_more_block">
                <div class="load_more_text"><a onclick="loadExploreBox('<?=$school_id?>','<?=$current_item+10?>')">看更多商品</a></div>
            </div>
        </div>
        <?
        } else {
        ?>
        <br class="clearboth" />
        <?
        }
    }
?>