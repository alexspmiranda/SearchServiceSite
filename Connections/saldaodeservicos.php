<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"


$hostname_saldaodeservicos = "localhost";
$database_saldaodeservicos = "saldaodeservicos";
$username_saldaodeservicos = "root";
$password_saldaodeservicos = "";

// $hostname_saldaodeservicos = "localhost";
// $database_saldaodeservicos = "saldaode_saldao";
// $username_saldaodeservicos = "saldaode_user";
// $password_saldaodeservicos = "Xm906907Lequinho23_bd";
$saldaodeservicos = mysql_pconnect($hostname_saldaodeservicos, $username_saldaodeservicos, $password_saldaodeservicos) or trigger_error(mysql_error(),E_USER_ERROR); 
?>