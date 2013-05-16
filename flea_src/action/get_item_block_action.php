<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $item_id = $_GET['item_id'];
    $item_obj = new FleaTransactionItem($item_id);
    $dbc = connectdb();
    $method_obj = new FleaTransactionMethod($item_obj->method_id); 
?>
<div id="item_icon_block<?=$item_obj->id?>" class="item_icon_block left">
    <span class="polaroids <?=rand_polaroids();?>"><img id="item_icon" src="<?=$item_obj->getItemIconRW('200');?>" width="200" /></span>
</div>
<div class="item_des_block right">
    <h3><span><?=$item_obj->title;?></span> (<a onclick="call_edit_item_box('&item_id=<?=$item_obj->id?>')">編輯</a>) (<a onclick="remove_back('<?=$item_obj->id?>');">自動去背</a>) (<a onclick="call_delete_item_box('&item_id=<?=$item_obj->id?>')">刪除</a>)</h3>
    <div class="item_detail">
        <span>價錢: <?=$item_obj->price;?>元</span><br/>
        <span>交易方式: <?=$method_obj->title;?></span><br/>
        <? 
        if(!empty($item_obj->school_location_id)){
        $school_obj = new FleaSchool($item_obj->school_id);
        $location_obj = new FleaSchoolLocation($item_obj->school_location_id);
        ?>
        <span>交易地點: <?=$school_obj->title?> <?=$location_obj->title?></span><br/>
        <?
        }
        if(!empty($item_obj->category_id)&&!empty($item_obj->subcategory_id)){
            $category_obj = new FleaCategory($item_obj->category_id);
            $subcategory_obj = new FleaSubcategory($item_obj->subcategory_id);
        ?>
        <span>分類:<?=$category_obj->title?> <?=$subcategory_obj->title?></span><br/>
        <?
        }
        ?>
    </div>
    <p>
        <?=nl2br($item_obj->content);?>
    </p>
</div>
<br class="clearboth">
<? } ?>