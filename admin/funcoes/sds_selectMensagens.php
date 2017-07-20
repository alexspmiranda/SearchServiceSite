<?php


function sds_selectInbox($idCliente, $inicio, $maximo){
	
	include "../Connections/config.php";
	
	$statusMensagem = 'pendente';
	
	$sql_inboxCliente = 'SELECT * FROM sds_contato_cliente 
						 WHERE statusMensagem = :statusMensagem AND idCliente_fk = :idCliente_fk 
						 ORDER BY dataMensagem DESC  LIMIT '.$inicio.','.$maximo;
	
	try{
		$query_inboxCliente= $connect->prepare($sql_inboxCliente);
		$query_inboxCliente->bindValue(':statusMensagem',$statusMensagem,PDO::PARAM_STR);
		$query_inboxCliente->bindValue(':idCliente_fk',$idCliente,PDO::PARAM_STR);				
		$query_inboxCliente->execute();
		
		$resultado_inboxCliente = $query_inboxCliente->fetchAll(PDO::FETCH_ASSOC);
		$resultado_cont = $query_inboxCliente->rowCount(PDO::FETCH_ASSOC);
		
	}catch(PDOexception $error_inboxAdmin){
	   echo 'Erro ao selecionar pendentes';
	}

	return $resultado_inboxCliente;		
}

function sds_selectRespondidos($idCliente, $inicio, $maximo){
	
	include "../Connections/config.php";
	
	$statusMensagem = 'respondido';

	$sql_inboxAdmin = 'SELECT * FROM sds_contato_cliente WHERE statusMensagem = :statusMensagem  AND idCliente_fk = :idCliente_fk
							   ORDER BY dataMensagem DESC LIMIT '.$inicio.','.$maximo;
            
		try{
			$query_inboxAdmin = $connect->prepare($sql_inboxAdmin);
			$query_inboxAdmin->bindValue(':statusMensagem',$statusMensagem,PDO::PARAM_STR);
			$query_inboxAdmin->bindValue(':idCliente_fk',$idCliente,PDO::PARAM_STR);
			$query_inboxAdmin->execute();
			
			$resultado_respondidosCliente = $query_inboxAdmin->fetchAll(PDO::FETCH_ASSOC);
			$resultado_cont = $query_inboxAdmin->rowCount(PDO::FETCH_ASSOC);
			
			if($resultado_cont == 0){
					echo '<H4>&nbsp;NÃO HÁ E-MAIL RESPONDIDOS</H4>';
			}
			
			}catch(PDOexception $error_inboxAdmin){
			   echo 'Erro ao selecionar e-mails respondidos';
			}
			
		foreach($resultado_respondidosCliente as $res_inboxCliente){
			$idMensagem        = $res_inboxCliente['idMensagem'];
			$nomeUsuario      = $res_inboxCliente['nomeUsuario'];
			$emailUsuario     = $res_inboxCliente['emailUsuario'];
			$mensagemUsuario     = $res_inboxCliente['mensagemUsuario'];
			$statusMensagem    = $res_inboxCliente['statusMensagem'];
			$dataMensagem  = $res_inboxCliente['dataMensagem'];

		}
		
		return $resultado_respondidosCliente;	
}

function sds_selectResposta($idMensagem){
	
	include "../Connections/config.php";
	
	$sql_inboxCliente = 'SELECT * FROM sds_contato_cliente WHERE idMensagem = :idMensagem';
            
	try{
		$query_inboxCliente = $connect->prepare($sql_inboxCliente);
		$query_inboxCliente->bindValue(':idMensagem',$idMensagem,PDO::PARAM_STR);
		$query_inboxCliente->execute();
		
		$resultado_inboxCliente = $query_inboxCliente->fetchAll(PDO::FETCH_ASSOC);
		
		}catch(PDOexception $error_inboxCliente){
		   echo 'Erro ao selecionar pendentes';
		}
	
	return $resultado_inboxCliente;	
}

?>