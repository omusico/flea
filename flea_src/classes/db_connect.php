<?php
function connectdb() {
    $link = mysql_pconnect ( DB_HOST, DB_USER, DB_PASSWORD ) or die ( "Error:" . mysql_error() );
    mysql_select_db ( DB_NAME ) or die ( "Could not select database" );  	
	mysql_query( "set time_zone='+8:00'" , $link );
    mysql_query( "set names 'utf8'" , $link );
	return $link;
}
?>