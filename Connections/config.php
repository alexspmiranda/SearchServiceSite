<?php 

// define ('HOST','localhost');
// define ('DATABASE','saldaode_saldao');
// define ('USER','saldaode_user');
// define ('PASS','Xm906907Lequinho23_bd');

define ('HOST','localhost');
define ('DATABASE','saldaodeservicos');
define ('USER','root');
define ('PASS','');

$connection = 'mysql:host='.HOST.';dbname='.DATABASE;

try{
	
	$connect = new PDO($connection, USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
	$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	}catch(PDOException $error_connection){
		 echo 'Erro ao conectar, favor informe no email alexspmiranda@gmail.com';
	}

?>
