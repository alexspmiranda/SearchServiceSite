<?php

function sds_selectDadosCliente($idCliente){

	include "../Connections/config.php";
	
	$sql_consultaCadastro = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio
							WHERE clientes.clienteId = :idCliente AND clientes.clienteId = anuncio.idCliente_FK';

	try{
		$query_consultaCadastro = $connect->prepare($sql_consultaCadastro);
		$query_consultaCadastro->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_consultaCadastro->execute();
		
		$resultado_consultaCadastro = $query_consultaCadastro->fetchAll(PDO::FETCH_ASSOC);
			
	}catch(PDOException $erro_consultarCadastro){
		echo 'Erro ao consultar';
	}
	
	return $resultado_consultaCadastro;
}

?>