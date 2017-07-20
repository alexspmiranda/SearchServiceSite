<?php 

include "../Connections/config.php";

$usuarioSistema = $_SESSION['MM_Username'];
$sqlSistema_usuarioSistema = 'SELECT * FROM sds_clientes WHERE email = :usuarioSistema OR fbid = :fbid';

try{
	
	$query_usuarioSistema = $connect->prepare($sqlSistema_usuarioSistema);
	$query_usuarioSistema->bindValue(':usuarioSistema',$usuarioSistema, PDO::PARAM_STR);
	$query_usuarioSistema->bindValue(':fbid',$_SESSION['FBID'], PDO::PARAM_STR);
	$query_usuarioSistema->execute();
	
	$resultado_queryUsuarioSistema = $query_usuarioSistema->fetchAll(PDO::FETCH_ASSOC);
	
	}catch(PDOException $erro_usuarioSistema){
		
		echo 'Erro ao selecionar usuario';
		echo '<meta http-equiv="refresh" content="2, deslogar.php" />';
		
	}
	
	foreach($resultado_queryUsuarioSistema as $res_usuarioSistema);
		$ultimoAcesso = $res_usuarioSistema['modificadoEM'];
		$email = $res_usuarioSistema['email'];
		$nivelAcesso = $res_usuarioSistema['nivelDeAcesso'];
		$idCliente = $res_usuarioSistema['clienteId'];
?>