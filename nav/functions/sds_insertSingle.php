<?php

function sds_insertMensagemUsuario($idCliente, $emailAnuncio, $mensagemNome , $mensagemEmail , $mensagemTelefone , $mensagemMensagem){
	
	include "Connections/config.php";
	
	$mensagemStatus = 'pendente';
	$mensagemData = date('Y-m-d H:i:s');
	
	$sql_enviaMsg = 'INSERT INTO sds_contato_cliente(idCliente_fk, nomeUsuario, emailUsuario, telefoneUsuario, mensagemUsuario, statusMensagem, dataMensagem)';
	$sql_enviaMsg .= 'VALUES(:idCliente, :mensagemNome, :mensagemEmail, :mensagemTelefone, :mensagemMensagem, :mensagemStatus, :mensagemData)';
	
	try{
	  
		$query_enviaMsg = $connect->prepare($sql_enviaMsg);
		$query_enviaMsg->bindValue(':idCliente',$idCliente, PDO::PARAM_STR);
		$query_enviaMsg->bindValue(':mensagemNome',$mensagemNome , PDO::PARAM_STR);
		$query_enviaMsg->bindValue(':mensagemEmail',$mensagemEmail , PDO::PARAM_STR);
		$query_enviaMsg->bindValue(':mensagemTelefone',$mensagemTelefone , PDO::PARAM_STR);
		$query_enviaMsg->bindValue(':mensagemMensagem',$mensagemMensagem , PDO::PARAM_STR);
		$query_enviaMsg->bindValue(':mensagemStatus',$mensagemStatus , PDO::PARAM_STR);
		$query_enviaMsg->bindValue(':mensagemData',$mensagemData , PDO::PARAM_STR);
		$query_enviaMsg->execute();

	  	$mail_data = date('Y-m-d  H:i:s');
		$mail = new PHPMailer();
		$mail->setLanguage('pt');
		
		$from	 	= $mensagemEmail;
		$fromName 	= 'Saldão de serviços';
		
		$host		= 'mail.saldaodeservicos.com';
		$username	= 'clientlist@saldaodeservicos.com';
		$password	= 'lequinho23';
		$port		= 587;
		$secure		= 'tls';
		
		$mail->isSMTP();
		$mail->Host 		= $host;
		$mail->SMTPAuth 	= true;
		$mail->Username 	= $username;
		$mail->Password 	= $password;
		$mail->Port 		= $port;
		$mail->SMTPSecure   = $secure;
		
		$mail->From 		= $from;
		$mail->FromName		= $fromName;
		$mail->addReplyTo($from, $fromName);
		
		$mail->addAddress($emailAnuncio , $emailAnuncio);
		$mail->isHTML(true);
		$mail->CharSet 	= 'utf-8';
		$mail->WordWrap = 70;
		$mail->Subject 	= 'Você recebeu uma mensagem';
		
		$criadoEm = date('d/m/Y H:i:s', strtotime($criadoEm));
		$mail_data = date('d/m/Y H:i:s', strtotime($mail_data));
		
		if(!empty($mensagemTelefone)){
			$telefone = 'Telefone: '.$mensagemTelefone.'<br><br>';
		}

		$mensagemCliente = '
		Olá, você recebeu uma nova mensagem.
		<br><br>
		De: '.$mensagemNome.'<br>
		Email: '.$mensagemEmail.'<br>
		'.$telefone.'
		Mensagem:<br>
		'.$mensagemMensagem.'<br><br>

		Atenciosamente,<br>
		Equipe Saldão de serviços.
		
		<br><br>
		';
		
		$mail->Body		= $mensagemCliente;
		$mail->AltBody	= $mensagemCliente;
		
		if($mail->send()){
			echo ' 
				<script>
					alert("Mensagem enviada com sucesso");
				</script>
			';
		}else{
			echo 'Erro: '.$mail->ErrorInfo;;	
		}
		  
  	$sql_selectEmail = 'SELECT * FROM sds_contato_cliente WHERE nomeUsuario = :nomeUsuario
					 AND emailUsuario = :emailUsuario AND dataMensagem = :mensagemData';
	
	  try{
		  $query_selectEmail = $connect->prepare($sql_selectEmail);
		  $query_selectEmail->bindValue(':nomeUsuario', $mensagemNome, PDO::PARAM_STR);
		  $query_selectEmail->bindValue(':emailUsuario', $mensagemEmail, PDO::PARAM_STR);
		  $query_selectEmail->bindValue(':mensagemData', $mensagemData, PDO::PARAM_STR);
		  $query_selectEmail->execute();
		  
		  $resultado_selectEmail = $query_selectEmail->fetchAll(PDO::FETCH_ASSOC);
		  
	  }catch(PDOException $erro_verificaMensagem){
			echo 'Erro ao verificar mensagem';
	  }
		  
	}catch(PDOException $erro_enviarMensagem){
	  echo 'Não foi possível enviar a mensagem';
	}
}

function sds_insertDenuncia($idCliente, $denuncia){
	
	include "Connections/config.php";
	
	$notificadoDenuncia = 0 ;
	$denunciaData = date('Y-m-d H:i:s');
	
	$sql_denuncia  = 'INSERT INTO sds_denuncias(idCliente_fk, denuncia, dataDenuncia, notificadoDenuncia)';
	$sql_denuncia .= 'VALUES(:idCliente, :denuncia, :denunciaData, :notificadoDenuncia)';
	
	try{
		$query_denuncia = $connect->prepare($sql_denuncia);
		$query_denuncia->bindValue(':idCliente',$idCliente , PDO::PARAM_STR);
		$query_denuncia->bindValue(':denuncia',$denuncia , PDO::PARAM_STR);
		$query_denuncia->bindValue(':denunciaData',$denunciaData , PDO::PARAM_STR);
		$query_denuncia->bindValue(':notificadoDenuncia',$notificadoDenuncia , PDO::PARAM_STR);
		$query_denuncia->execute();

	}catch(PDOException $erro_denuncia){
		echo "Erro ao fazer denúncia";
	}
}

function sds_insertEmailNewsletter($emailNewsletter, $hashAtivacao){
	
	include "Connections/config.php";
	
	$dataNewsletter = date('Y-m-d H:i:s');
	$statusNewsletter = 'desativado';
	
	$sql_newsletter  = 'INSERT INTO sds_newsletter(emailNewsletter, dataNewsletter, statusNewsletter, hashAtivacao)';
	$sql_newsletter .= 'VALUES(:emailNewsletter, :dataNewsletter, :statusNewsletter, :hashAtivacao )';
	
	try{
		$query_newsletter = $connect->prepare($sql_newsletter);
		$query_newsletter->bindValue(':emailNewsletter', $emailNewsletter, PDO::PARAM_STR);
		$query_newsletter->bindValue(':dataNewsletter', $dataNewsletter, PDO::PARAM_STR);
		$query_newsletter->bindValue(':statusNewsletter', $statusNewsletter, PDO::PARAM_STR);
		$query_newsletter->bindValue(':hashAtivacao', $hashAtivacao, PDO::PARAM_STR);
		$query_newsletter->execute();
		
		$validador = 'http://localhost/saldaodeservicos/index.php?pg=validate&valmail='.$hashAtivacao;
		$mail_data = date('Y-m-d  H:i:s');
		$mail = new PHPMailer();
		$mail->setLanguage('pt');
		
		$from	 	= 'alexspmiranda@gmail.com';
		$fromName 	= 'Saldão de serviços';
		
		$host		= 'smtp.gmail.com';
		$username	= 'alexspmiranda@gmail.com';
		$password	= 'lequinho23';
		$port		= 587;
		$secure		= 'tls';
		
		$mail->isSMTP();
		$mail->Host 		= $host;
		$mail->SMTPAuth 	= true;
		$mail->Username 	= $username;
		$mail->Password 	= $password;
		$mail->Port 		= $port;
		$mail->SMTPSecure   = $secure;
		
		$mail->From 		= $from;
		$mail->FromName		= $fromName;
		$mail->addReplyTo($from, $fromName);
		
		$mail->addAddress($emailNewsletter , $emailNewsletter);
		$mail->isHTML(true);
		$mail->CharSet 	= 'utf-8';
		$mail->WordWrap = 70;
		$mail->Subject 	= 'Confirme sua assinatura';
		
		$criadoEm = date('d/m/Y H:i:s', strtotime($criadoEm));
		$mail_data = date('d/m/Y H:i:s', strtotime($mail_data));
		
		$mensagemCliente = "
		Você assinou nosso sistema de newsletter, por favor, confirme o cadastro clicando neste link:
		<br />

		<a href=\"$validador\">Confirmar assinatura</a><br /><br />
		
		Esta mensagem é gerada automaticamente pelo nosso sistema, por favor, não responda!<br><br>
		
		Atenciosamente,<br>
		Equipe Saldão de serviços.
		
		<br><br>
		
		Mensagem enviada em $mail_data
		";
		
		$mail->Body		= $mensagemCliente;
		$mail->AltBody	= $mensagemCliente;
		
		if($mail->send()){
			$enviadoSucesso = 'Mensagem enviada com sucesso!!!';
			
			echo '<script language="javascript">';
			echo '$(window).load(function() {
					alert("'.$enviadoSucesso.'")
			})';
			echo '</script>';

		}else{
			echo 'Erro: '.$mail->ErrorInfo;;	
		}
		
	}catch(PDOException $erro_newsletter){
		echo 'Erro ao cadastrar newsletter';
	}
}

function sds_insertComentariosAvaliacao($idCliente, $idAvaliador, $mensagem){
	
	include "Connections/config.php";
	
	$data = date('Y-m-d H:i:s');
	$voto = '1';
	
	$sql_insereComentarioAvaliacao  = 'INSERT INTO sds_avaliacao(idCliente_fk, votos, idAvaliador, mensagemAvaliacao, dataAvaliacao)';
	$sql_insereComentarioAvaliacao .= 'VALUES(:idCliente_fk, :votos, :idAvaliador, :mensagem, :data)';
	
	try{
		$query_insereComentarioAvaliacao = $connect->prepare($sql_insereComentarioAvaliacao);
		$query_insereComentarioAvaliacao->bindValue('idCliente_fk', $idCliente, PDO::PARAM_STR);
		$query_insereComentarioAvaliacao->bindValue('votos', $voto, PDO::PARAM_STR);
		$query_insereComentarioAvaliacao->bindValue('idAvaliador', $idAvaliador, PDO::PARAM_STR);
		$query_insereComentarioAvaliacao->bindValue('mensagem', $mensagem, PDO::PARAM_STR);
		$query_insereComentarioAvaliacao->bindValue('data', $data, PDO::PARAM_STR);
		$query_insereComentarioAvaliacao->execute();
		
	}catch(PDOException $erro_inserirComentarioAvaliacao){
		echo 'Erro ao inserir comentário de avaliacao';	
	}
}

function sds_insertNumVisitas($idCliente, $ip){
	
	include "Connections/config.php";
	
	$data = date('Y-m-d H:i:s');
	
	$sql_visitas  = 'INSERT INTO sds_visitas ( ipVisitante, idCliente_fk, dataVisita ) 
					 VALUES ( :ip, :idCliente, :data )';
	
	try{
		$query_visitas = $connect->prepare($sql_visitas);
		$query_visitas->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_visitas->bindValue(':ip', $ip, PDO::PARAM_STR);
		$query_visitas->bindValue(':data', $data, PDO::PARAM_STR);
		$query_visitas->execute();
		
	}catch(PDOException $erro_inserirComentarioAvaliacao){
		echo 'Erro ao atualizar comentário de avaliacao';	
	}
}

?>