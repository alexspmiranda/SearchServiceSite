<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"


$hostname_saldaodeservicos = "localhost";
$database_saldaodeservicos = "";
$username_saldaodeservicos = "";
$password_saldaodeservicos = "";

// $hostname_saldaodeservicos = "localhost";
// $database_saldaodeservicos = "";
// $username_saldaodeservicos = "";
// $password_saldaodeservicos = "";
$saldaodeservicos = mysql_pconnect($hostname_saldaodeservicos, $username_saldaodeservicos, $password_saldaodeservicos) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
