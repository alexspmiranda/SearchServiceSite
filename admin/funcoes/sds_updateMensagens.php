<?php

function sds_atualizaMensagemRespondidos($idMensagem, $respostaMensagem	){
	
	include "../Connections/config.php";
	
	$statusMensagem = 'respondido';
	$dataResposta = date('Y-m-d');
	
	$sql_enviaCliente  = 'UPDATE sds_contato_cliente SET ';
	$sql_enviaCliente .= 'statusMensagem = :statusMensagem, dataResposta = :dataResposta, respostaCliente = :respostaMensagem WHERE idMensagem = :idMensagem';
	
   try{
	   $query_enviaCliente = $connect->prepare($sql_enviaCliente);
	   $query_enviaCliente->bindValue(':statusMensagem',$statusMensagem,PDO::PARAM_STR);
	   $query_enviaCliente->bindValue(':dataResposta',$dataResposta,PDO::PARAM_STR);
	   $query_enviaCliente->bindValue(':respostaMensagem',$respostaMensagem,PDO::PARAM_STR);
	   $query_enviaCliente->bindValue(':idMensagem',$idMensagem, PDO::PARAM_STR);
	   $query_enviaCliente->execute();
								   
	   }catch(PDOexception $error_clienteEmail){
		   echo 'Erro ao atualizar o email'.$error_clienteEmail->getMessage();
   }
}

?>