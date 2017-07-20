<article class="container">
	
	<?php include_once("sidebar_contato.php");
		  require "Connections/config.php";
	 ?>

	<form name="fale_conosco" method="POST" action=""  enctype="multipart/form-data">
    
    <?php
		
		if(isset($_POST['contato_site'])){
			
			$contatoNome = strip_tags(trim($_POST['nome']));
			$contatoEmail = strip_tags(trim($_POST['email']));
			$contatoAssunto = strip_tags(trim($_POST['assunto']));
			$contatoMensagem = strip_tags(trim($_POST['mensagem']));
			$dataMensagem = date('Y-m-d H-i-s');
			$codData = date('d-H-i');
			$codMensagem = $codData.'-'.$contatoEmail;
			$statusMensagem = 'pendente';
			
			$sql_verificaContato = 'SELECT contatoCod FROM sds_contato WHERE contatoCod = :contatoCod';
			
			try{
				
				$query_verificaContato = $connect->prepare($sql_verificaContato);
				$query_verificaContato->bindValue(':contatoCod', $codMensagem ,PDO::PARAM_STR);
				$query_verificaContato->execute();
				
				$conta_verificaContato = $query_verificaContato->rowCount(PDO::PARAM_STR);
								
			}catch(PDOException $erro_verificaContato){
				
				echo 'Erro ao selecionar o código da mensagem.';
			
			}
if($conta_verificaContato >= 1){
		$aguarde_instantes = '<div id="envioMsg">Por favor aguarde alguns instantes para enviar uma nova mensagem.</div>';
}else{
		
		$sql_contatoSite = 'INSERT INTO sds_contato(contatoNome, contatoEmail, contatoAssunto, contatoMensagem, dataMensagem, statusMensagem, contatoCod, notificadoPagamento)';	
		$sql_contatoSite .= 'VALUES (:contatoNome,:contatoEmail,:contatoAssunto,:contatoMensagem,:dataMensagem,:statusMensagem,:contatoCod, :notificadoPagamento)';
		
		try{
			$notificadoPagamento = '0';
			$query_contatoSite = $connect->prepare($sql_contatoSite);
			$query_contatoSite->bindValue(':contatoNome', $contatoNome , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':contatoEmail', $contatoEmail , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':contatoAssunto', $contatoAssunto, PDO::PARAM_STR );
			$query_contatoSite->bindValue(':contatoMensagem', $contatoMensagem , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':dataMensagem', $dataMensagem , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':statusMensagem', $statusMensagem , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':contatoCod', $codMensagem , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':notificadoPagamento', $notificadoPagamento , PDO::PARAM_STR );
			$query_contatoSite->execute();
			
			$mail_data = date('Y-m-d  H:i:s');
			$mail = new PHPMailer();
			$mail->setLanguage('pt');
			
			$from	 	= 'comercial@saldaodeservicos.com';
			$fromName 	= 'Saldão de serviços';
			
			$host		= 'mail.saldaodeservicos.com';
			$username	= 'comercial@saldaodeservicos.com';
			$password	= 'xm906907';
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
			
			$mail->addAddress($contatoEmail , $contatoEmail);
			$mail->isHTML(true);
			$mail->CharSet 	= 'utf-8';
			$mail->WordWrap = 70;
			$mail->Subject 	= 'Mensagem recebida';
			
			$criadoEm = date('d/m/Y H:i:s', strtotime($criadoEm));
			$mail_data = date('d/m/Y H:i:s', strtotime($mail_data));
			
			$mensagemCliente = "
			Recebemos sua mensagem com sucesso, em breve responderemos.
			<br /><br />

			
			<strong>Cópia do seu e-mail: </strong><br><br>
			
			\"$contatoMensagem\". <br /><br />
			
			Esta mensagem é gerada automaticamente pelo nosso sistema, por favor, não responda!<br><br>
			
			Atenciosamente,<br>
			Equipe Saldão de serviços.
			
			<br><br>
			
			Mensagem enviada em $mail_data
			";
			
			$mail->Body		= $mensagemCliente;
			$mail->AltBody	= $mensagemCliente;
			
			if($mail->send()){
				$msg_sucesso = '<div id="envioMsg">Mensagem enviada com sucesso!.</div>';
			}else{
				echo 'Erro: '.$mail->ErrorInfo;;	
			}
						
		}catch(PDOException $erro_cadastraMensagem){
			$erro_enviar = 'Erro ao enviar a mensagem';
		}
}
			
		}
	?>
                    <h5>Nome: </h5>
                        <input type="text" name="nome" required maxlength="18"/>
                    <h5>E-mail: </h5>
                        <input type="text" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
                    <h5>Assunto: </h5>
                        <input type="text" name="assunto" required maxlength="25" /><br>
                    <h5>Mensagem: </h5>
                    	<textarea  type="text" name="mensagem" required></textarea><br>
	                
	                <input type="submit" value="Enviar" name="contato_site" id="submit" />
            </form><br>

			<?php            
            echo $erro_enviar;
            echo $aguarde_instantes;
            echo $msg_sucesso;
			?>
</article>