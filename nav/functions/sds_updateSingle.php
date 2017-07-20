<?php

function sds_updateComentariosAvaliacao($idCliente, $idAvaliador, $mensagem){
	
	include "Connections/config.php";
	
	$data = date('Y-m-d H:i:s');
	
	$sql_insereComentarioAvaliacao  = 'UPDATE sds_avaliacao SET mensagemAvaliacao = :mensagem, dataAvaliacao = :data 
									   WHERE idCliente_fk = :idCliente AND idAvaliador = :idAvaliador';
	
	try{
		$query_insereComentarioAvaliacao = $connect->prepare($sql_insereComentarioAvaliacao);
		$query_insereComentarioAvaliacao->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_insereComentarioAvaliacao->bindValue(':idAvaliador', $idAvaliador, PDO::PARAM_STR);
		$query_insereComentarioAvaliacao->bindValue(':mensagem', $mensagem, PDO::PARAM_STR);
		$query_insereComentarioAvaliacao->bindValue(':data', $data, PDO::PARAM_STR);
		$query_insereComentarioAvaliacao->execute();
		
	}catch(PDOException $erro_inserirComentarioAvaliacao){
		echo 'Erro ao atualizar comentário de avaliacao';	
	}
}

?>