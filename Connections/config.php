<?php 

// define ('HOST','localhost');
// define ('DATABASE','');
// define ('USER','');
// define ('PASS','');

define ('HOST','localhost');
define ('DATABASE','');
define ('USER','');
define ('PASS','');

$connection = 'mysql:host='.HOST.';dbname='.DATABASE;

try{
	
	$connect = new PDO($connection, USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
	$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	}catch(PDOException $error_connection){
		 echo 'Erro ao conectar, favor informe no email alexspmiranda@gmail.com';
	}

?>
