<?php

function sds_deleteExcluiMensagens($idMensagem){
	
	include "../Connections/config.php";
	
	$sql_excluiMensagens = 'DELETE FROM sds_contato_cliente WHERE idMensagem = :idMensagem';
			
	try{			
		$query_excluiMensagens = $connect->prepare($sql_excluiMensagens);
		$query_excluiMensagens->bindValue(':idMensagem', $idMensagem, PDO::PARAM_STR);
		$query_excluiMensagens->execute();
		
		$excluidoSucesso = 'Mensagem excluída com sucesso';
		
	}catch(PDOException $erro_excluiMensagens){
		echo 'Não foi possível excluir a mensagem.';
	}

	return $excluidoSucesso;
}

?>