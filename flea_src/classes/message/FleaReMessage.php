<?php
class FleaReMessage {
    //成員函數
    var $id;
    var $message_id;
    var $sender_id;
    var $receiver_id;
    var $content;
    var $send_time;
    var $is_sender_deleted;
    var $is_receiver_deleted;

    //建構子
    function __construct($input_message_key){
        $dbc = connectdb();
        $query_message = mysql_query("SELECT * FROM reply_message WHERE id='$input_message_key' LIMIT 1",$dbc);
        while ($query_message_data = mysql_fetch_array($query_message)) {
            $this->id = $query_message_data['id'];
            $this->message_id = $query_message_data['message_id'];
            $this->sender_id = $query_message_data['sender_id'];
            $this->receiver_id = $query_message_data['receiver_id'];
            $this->content = $query_message_data['content'];
            $this->send_time = $query_message_data['send_time'];
            $this->is_sender_deleted = $query_message_data['is_sender_deleted'];
            $this->is_receiver_deleted = $query_message_data['is_receiver_deleted'];
        }
        /* free result set */
        mysql_free_result($query_message);
        unset($dbc);
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->message_id);
        unset($this->sender_id);
        unset($this->receiver_id);
        unset($this->content);
        unset($this->send_time);
        unset($this->is_sender_readed);
        unset($this->is_receiver_readed);
    }
}
?>