<?php
class FleaExchangeRecord {
    //成員函數
    var $id;
    var $box_item_id;
    var $item_id;
    var $buyer_id;
    var $owner_id;
    var $method_id;
    var $contact_name;
    var $contact_number;
    var $price_sum;
    var $quantity;
    var $order_time;
    var $paid_time;
    var $status;

    //建構子
    function __construct($input_exchange_key){
        $dbc = connectdb();
        $query_exchange = mysql_query("SELECT * FROM exchange_record WHERE id='$input_exchange_key' LIMIT 1",$dbc);
        while ($query_exchange_data = mysql_fetch_array($query_exchange)) {
            $this->id = $query_exchange_data['id'];
            $this->box_item_id = $query_exchange_data['box_item_id'];
            $this->item_id = $query_exchange_data['item_id'];
            $this->buyer_id = $query_exchange_data['buyer_id'];
            $this->owner_id = $query_exchange_data['owner_id'];
            $this->contact_name = $query_exchange_data['contact_name'];
            $this->contact_number = $query_exchange_data['contact_number'];
            $this->price_sum = $query_exchange_data['price_sum'];
            $this->quantity = $query_exchange_data['quantity'];
            $this->order_time = $query_exchange_data['order_time'];
            $this->paid_time = $query_exchange_data['paid_time'];
            $this->status = $query_exchange_data['status'];
        }
        /* free result set */
        mysql_free_result($query_exchange);
        unset($dbc);
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
        unset($this->id);
        unset($this->box_item_id);
        unset($this->item_id);
        unset($this->buyer_id);
        unset($this->owner_id);
        unset($this->contact_name);
        unset($this->contact_number);
        unset($this->price_sum);
        unset($this->quantity);
        unset($this->order_time);
        unset($this->paid_time);
        unset($this->status);
    }
}
?>