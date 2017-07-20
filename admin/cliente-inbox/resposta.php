<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
<?php include_once("header.php"); ?>    
	
<article class="container visible-desktop">
	<div class="answers">            
                   
<?php

	$idMensagem = strip_tags(trim($_GET['emailId']));

	$resultado_inboxCliente = sds_selectResposta($idMensagem);
	            
	foreach($resultado_inboxCliente as $res_inboxCliente){
		$idMensagem        = $res_inboxCliente['idMensagem'];
		$idCliente_fk	=	$res_inboxCliente['idCliente_fk'];
		$nomeUsuario      = $res_inboxCliente['nomeUsuario'];
		$emailUsuario     = $res_inboxCliente['emailUsuario'];
		$telefoneUsuario     = $res_inboxCliente['telefoneUsuario'];
		$mensagemUsuario     = $res_inboxCliente['mensagemUsuario'];
		$statusMensagem    = $res_inboxCliente['statusMensagem'];
		$dataMensagem  = $res_inboxCliente['dataMensagem'];
		$respostaMensagem  = $res_inboxCliente['respostaCliente'];

        $i++;
        $cor = 'style="background:#D9D9D9;"'					

?>	 	 
    <h5><strong>NOME:</strong></h5>
    <h5><?php echo $nomeUsuario ?></h5>
    <br>
    <h5><strong>E-MAIL:</strong></h5>
    <h5><?php echo $emailUsuario ?></h5>
    <br>
    <h5><strong>TELEFONE:</strong></h5>
    <h5><?php echo $telefoneUsuario;
	 
	  if(empty($telefoneUsuario))
	 	echo 'Não informado';
		
	?>
	</h5>
	<br>
    <h5><strong>MENSAGEM:</strong></h5>
    <h5><?php echo $mensagemUsuario ?></h5>
    <br>
    <h5><strong>RESPOSTA ANTERIOR:</strong></h5>
    
    <h5><?php
	 	if(empty($respostaMensagem)){
	 		echo 'Mensagem automática: NENHUMA RESPOSTA ANTERIOR FOI DADA A ESTE E-MAIL!';
	 	}else{
		 	echo $respostaMensagem; 
     	}
     ?></h5>
<?php
    }
?> 
    <br><br>
    <?php if(isset($_POST['executar'])){

			$idMensagem           = strip_tags(trim($_POST['contatoId']));
			$respostaMensagem     = strip_tags(trim($_POST['mensagem']));
			$emailUsuario = strip_tags(trim($_POST['contatoEmail']));
			$nomeUsuario         = strip_tags(trim($_POST['contatoNome']));
			
			$recebidoEm = strip_tags(trim($_POST['dataMensagem']));
			$mensagemEm = strip_tags(trim($_POST['emailMensagem']));
			
			sds_atualizaMensagemRespondidos($idMensagem, $respostaMensagem);
			
			$mail_data = date('Y-m-d  H:i:s');
			$mail = new PHPMailer();
			$mail->setLanguage('pt');
			
			$from    	=  $email;
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
			
			$mail->addAddress($emailUsuario , $emailUsuario);
			$mail->isHTML(true);
			$mail->CharSet 	= 'utf-8';
			$mail->WordWrap = 70;
			$mail->Subject 	= 'RESPOSTA - CONTATO SALDÃO DE SERVIÇOS';
		
			$statusMensagem   = 'respondido';
			
			$mensagemEnvio = 

			"Olá, $nomeUsuario. Este e-mail é uma resposta para a mensagem:<br /><br />
			$mensagemUsuario<br /><br />

			<strong>Resposta:</strong><br /> $respostaMensagem<br /><br />
			
			A partir desta mensagem o contato é feito diretamente com o anunciante. <br /><br />
			
			Atenciosamente,<br>
			Equipe Saldão de serviços.
			
			 ";
			 
			 $mail->Body	= $mensagemEnvio;
			 $mail->AltBody	= $mensagemEnvio;
			 
			 if($mail->send()){
				 
				$enviadoSucesso = 'Mensagem enviada com sucesso!!!';
										
				echo '<script language="javascript">';
				echo '$(window).load(function() {
						alert("'.$enviadoSucesso.'")
				})';
				echo '</script>';

			}else{
				echo 'Erro: '.$mail->ErrorInfo;
		}

		}?>
            
	    <h5>Responder:</h5><br>
        <form name="responderEmail" action="" enctype="multipart/form-data" method="post">           
 			
 			<textarea name="mensagem"></textarea>
            <input type="hidden" name="contatoId" value="<?php echo $idMensagem ;?>" />
            <input type="hidden" name="contatoEmail" value="<?php echo $emailUsuario;?>" />
            <input type="hidden" name="dataMensagem" value="<?php echo $dataMensagem;?>" />
            <input type="hidden" name="contatoMensagem" value="<?php echo $mensagemUsuario;?>" />
            <input type="hidden" name="contatoNome" value="<?php echo $nomeUsuario;?>" />
            <br>
            <input type="submit" name="executar" class="btn btn-primary" value="Enviar Resposta" style="float:right;" />
        
        </form>
            
            
        </div>
    </article>
<?php include_once("footer.php"); ?>