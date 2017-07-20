<?php

function sds_selectResultadoInbox($pag){
	
	include "../Connections/config.php";
	
	$statusMensagem = 'pendente';
            
	$maximo = '10'; //RESULTADOS POR PÁGINA
	$inicio = ($pag * $maximo) - $maximo;

	$sql_inboxAdmin = 'SELECT * FROM sds_contato WHERE statusMensagem = :statusMensagem ORDER BY dataMensagem DESC LIMIT '.$inicio.','.$maximo;
	
	try{
		$query_inboxAdmin = $connect->prepare($sql_inboxAdmin);
		$query_inboxAdmin->bindValue(':statusMensagem',$statusMensagem,PDO::PARAM_STR);
		$query_inboxAdmin->execute();
		
		$resultado_inboxAdmin = $query_inboxAdmin->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOexception $error_inboxAdmin){
	   echo 'Erro ao selecionar pendentes';
	}
	
	return $resultado_inboxAdmin;
}

function sds_selectRespondidosInbox($pag){
	
	include "../Connections/config.php";
	
	$statusMensagem = 'respondido';
	
	$maximo = '10'; //RESULTADOS POR PÁGINA
	$inicio = ($pag * $maximo) - $maximo;
	
	$sql_respondidosAdmin = 'SELECT * FROM sds_contato 
							 WHERE statusMensagem = :statusMensagem 
							 ORDER BY dataMensagem DESC LIMIT '.$inicio.','.$maximo;
	
	try{
		$query_respondidosAdmin = $connect->prepare($sql_respondidosAdmin);
		$query_respondidosAdmin->bindValue(':statusMensagem',$statusMensagem,PDO::PARAM_STR);
		$query_respondidosAdmin->execute();
		
		$resultado_respondidosAdmin= $query_respondidosAdmin->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOexception $error_respondidosAdmin){
	   echo 'Erro ao selecionar e-mails respondidos';
	}
	
	return $resultado_respondidosAdmin;
}

function sds_selectRespostaInbox($emailId){
	
	include "../Connections/config.php";
	
	$sql_respostaAdmin = 'SELECT * FROM sds_contato WHERE contatoId = :emailId';
            
	try{
		$query_respostaAdmin = $connect->prepare($sql_respostaAdmin);
		$query_respostaAdmin->bindValue(':emailId',$emailId,PDO::PARAM_STR);
		$query_respostaAdmin->execute();
		
		$resultado_respostaAdmin = $query_respostaAdmin->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOexception $error_respostaAdmin){
	   echo 'Erro ao selecionar pendentes';
	}
	
	return $resultado_respostaAdmin;	
}

function sds_selectSearchInbox($contatoNome, $contatoEmail){
	
	include "../Connections/config.php";
	
	$sql_searchAdmin = 'SELECT * FROM sds_contato WHERE contatoNome LIKE :contatoNome OR contatoEmail LIKE :contatoEmail';
	$sql_searchAdmin .= ' ORDER BY dataMensagem ASC';
	
	try{
		$query_searchAdmin = $connect->prepare($sql_searchAdmin);
		$query_searchAdmin->bindValue(':contatoNome','%'.$contatoNome.'%',PDO::PARAM_STR);
		$query_searchAdmin->bindValue(':contatoEmail','%'.$contatoEmail.'%',PDO::PARAM_STR);
		$query_searchAdmin->execute();
		
		$resultado_searchAdmin = $query_searchAdmin->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOexception $error_searchAdmin){
	   echo 'Erro ao selecionar e-mails respondidos';
	}
	
	return $resultado_searchAdmin;
}

?>