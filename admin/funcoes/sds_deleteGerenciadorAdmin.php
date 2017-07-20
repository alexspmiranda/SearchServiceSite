<?php

function sds_deleteCliente($idCliente){

	include "../Connections/config.php";
	
	$sql_cadastraAnuncio  = 'DELETE FROM sds_clientes WHERE clienteId = :idCliente';
			
	try{			
		$query_cadastraAnuncio = $connect->prepare($sql_cadastraAnuncio);
		$query_cadastraAnuncio->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_cadastraAnuncio->execute();
		
	}catch(PDOException $erro_cadastrar){
		echo 'Não foi possível excluir.';
	}	

}

?>