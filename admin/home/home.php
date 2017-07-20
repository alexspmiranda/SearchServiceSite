<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>

<?php

if($nivelAcesso == 'cliente'){
	include_once("cliente.php"); 
}elseif($nivelAcesso == 'admin'){
	include_once("admin.php");
}else{
	if(!empty($_SESSION['FBID']))
		include_once("cliente.php");
	else
		include_once("deslogar.php");
}
	
?>