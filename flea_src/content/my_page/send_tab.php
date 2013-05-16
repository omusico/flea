<? 
if(!empty($_COOKIE['user_id'])){ 
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $user_obj = new FleaUser($_COOKIE['user_id']);
    $dbc = connectdb();
    $query_message = "SELECT id FROM message WHERE sender_id='$user_obj->id' ORDER BY new_reply_time DESC, send_time DESC";
    $query_message_result = mysql_query($query_message, $dbc);
    $message_num = mysql_num_rows($query_message_result);
    
    if($message_num>0){
    ?>
    <table border="0" cellpadding="0" cellspacing="0" class="cleanTable">
        <thead>
            <tr>
                <th scope="col" width="120">收件人</th>
                <th scope="col" width="450">主旨</th>
                <th scope="col" width="120">更新日期</th>
            </tr>
        </thead>
        <tbody>
            <?
            $counter = 1;
            while ($query_message_result_data = mysql_fetch_array($query_message_result)) {
                $message_obj = new FleaMessage($query_message_result_data['id']);
                $receiver_obj = new FleaUser($message_obj->receiver_id);
                $unread_class = '';
                if($message_obj->is_sender_readed==0){
                    $unread_class = 'class="unread"';
                }
            ?>
            <tr <? if($counter%2==0){ echo 'class="even"';} ?>>
                <td <?=$unread_class?>><?=$receiver_obj->nickname?></td>
                <td <?=$unread_class?>><a onclick="read_message_box('&message_id=<?=$message_obj->id?>&type=send');"><?=$message_obj->title?></a></td>
                <td <?=$unread_class?>>
                    <?
                        if($message_obj->new_reply_time!='0000-00-00 00:00:00'){
                            echo showDateTime($message_obj->new_reply_time);
                        } else {
                            echo showDateTime($message_obj->send_time);
                        }
                    ?>
                </td>
            </tr>
            <?              
                $counter ++;
            } 
            ?>
        </tbody>
    </table>
    <?
    mysql_free_result($query_message_result);
    } else {
    ?>
    <h3>尚無任何寄件。</h3>
    <?
    }
?>
<div class="clearboth"></div>
<? 
    unset($user_obj);
} 
?>