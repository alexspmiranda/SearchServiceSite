<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
	if (PHP_VERSION < 6) {
		$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	}
	$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
	switch ($theType) {
		case "text":
		   $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		   break;    
		 case "long":
		 case "int":
		   $theValue = ($theValue != "") ? intval($theValue) : "NULL";
		   break;
		 case "double":
		   $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
		   break;
		 case "date":
		   $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		   break;
		 case "defined":
		   $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		   break;
	}
	return $theValue;
	}
}
?>
<?php
if(!isset($_SESSION)) session_start();

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
   $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
if (isset($_POST['email'])) {
   $loginUsername=$_POST['email'];
   $password= sha1(md5($_POST['senha'].''.$loginUsername));
   $MM_fldUserAuthorization = "nivelDeAcesso";
   $MM_redirectLoginSuccess = "painel.php";
   $MM_redirectLoginFailed = "<h5 style=\"float:left; padding:5px; background:#fff; margin-top:5px;\">*** Falha ao logar! Verifique usu�rio e senha!</h5>";
   $MM_redirecttoReferrer = false;
   mysql_select_db($database_saldaodeservicos, $saldaodeservicos);
 	
  $LoginRS__query=sprintf("SELECT nome, clienteId, senha, nivelDeAcesso, status FROM sds_clientes WHERE email=%s AND senha=%s",
   GetSQLValueString($loginUsername,"text"), GetSQLValueString($password,"text")); 
  
   $LoginRS = mysql_query($LoginRS__query, $saldaodeservicos) or die(mysql_error());
   $loginFoundUser = mysql_num_rows($LoginRS);
   if ($loginFoundUser) {
   
    $loginStrGroup  = mysql_result($LoginRS,0,'nivelDeAcesso');
 	$loginStrValid  = mysql_result($LoginRS,0,'status');
 	$loginUserId  = mysql_result($LoginRS,0,'clienteId');
 	$loginUser  = mysql_result($LoginRS,0,'nome');
  
 	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
     //declare two session variables and assign them
     $_SESSION['MM_Username'] = $loginUsername;
     $_SESSION['MM_UserGroup'] = $loginStrGroup;
 	$_SESSION['MM_UserStatus'] = $loginStrValid;
 	$_SESSION['MM_LogiUserId'] = $loginUserId;
 	$_SESSION['MM_LogiUsername'] = $loginUser;	 	   
 	if($_SESSION['MM_UserStatus'] != 'pendente'){
 		if (isset($_SESSION['PrevUrl']) && false) {
 		  $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
 		}

 		header("Location: " . $MM_redirectLoginSuccess );
 	}else{
 		$validarCadastro_msg = "<h5 style=\"float:left; padding:5px; background:#fff; margin-top:5px;\">
 								Você precisa validar o seu cadastro,<br> por favor, verifique seu e-mail!</h5>";
 	}
   }
   else {
	
     //header("Location: ". $MM_redirectLoginFailed );
   }
 }

$validador = strip_tags(trim($_GET['validador']));

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Saldão de serviços - Anuncie grátis </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
	<![endif]-->
</head>

<body>
<div class="container-fluid">
	<header class="header">
		<div class="row-fluid">
			<div class="header_logo">
				<div class="span7" >
					<div class="span4 box-logo">
						<div class="logo">
							<a href="<?php echo URL::getBase() ?>" title="Saldão de serviços">
								<img src="img/others/logo.png" alt="Saldão de serviços" title="Saldão de serviços" height="64" width="187">
							</a>
						</div>
					</div>
					
					<div class="span5">
						<span class="slogan" >
							Encontre eletricistas, pedreiros, corretores de imóveis, designers, diaristas. Aqui você	 procura e encontra!
						</span>
					</div>
				</div>
			</div>
		</div>
	</header>

	<?php

	if($validador == "validado-com-sucesso"){
		echo '
			<span class="container-fluid validator text-center">
				Cadastro validado com sucesso!!!
			</span>
		';
	}

	?>

	<article class="container">
		
		<div class="span6 login" style="clear:both; margin-top:35px;">
    		<h3> Acessar minha conta </h3>
        
    		<div class="login-container">
    			<form action="<?php echo $loginFormAction; ?>" method="POST"  name="login-painel" enctype="multipart/form-data">
	            	<h5>E-mail: </h5>
	           		<input type="text" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
	                <h5>Senha: </h5>
	    			<input type="password" name="senha" required /><br>
		            <input type="submit" class="btn btn-primary" value="Logar" id="submit" />
	            </form>

		        <span style="color:#930; font:12px Arial, Helvetica, sans-serif; float:left; ">
<?php		
					if(empty($validarCadastro_msg)){
						echo $MM_redirectLoginFailed;
					}else{
						echo $validarCadastro_msg;
					}
					
					if(!empty($senhaEnviada)){
						echo $senhaEnviada;
					}elseif(!empty($emailNaoEncontrado)){
						echo $emailNaoEncontrado;
					}
?>
		        </span>
  			</div>
        	<a href="#" class="remember-pass"><h4> [ Esqueci a senha ] </h4></a>
    	</div>
    
	    <div class="span6 new-user" style="margin:35px 0 35px 0;">
	    	<h3>Não possui uma conta?</h3>
	      	<div class="login-container">

        	<h5 style="font-size:20px;">Cadastra-se agora, é grátis! </h5> <br> 
            <form  method="POST" action="" name="#cadastra_cliente" enctype="multipart/form-data">
                <h5>E-mail: </h5>
                <input type="text" name="email-cadastra"  required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
                <h5>Confirme o e-mail: </h5>
                <input type="text" name="email-confirma"  required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
                <h5>Senha: </h5>
                <input type="password" name="senha-cadastra" pattern=".{6,}" title="Digite entre 6 e 8 caracteres (Mai�sculas e min�sculas para maior seguran�a)" id="#senha" required maxlength="8" />
                <h5>Confirme a senha:</h5>
                <input  type="password" name="senha-confirma" pattern=".{6,}" title="Digite entre 6 e 8 caracteres" id="#senhaConfirma" maxlength="8" required /><br>
                <input type="checkbox" name="termos" value="aceito" style=" float:left; margin-top:4px;" required />
                <h5> Aceito os <a href="../index.php?pg=termos-privacidade" target="_blank">termos</a> e <a href="../index.php?pg=termos-privacidade" target="_blank">políticas de privacidade</a></h5><br>
                <input type="submit" value="Cadastrar" name="cadastrar-usuario" class="btn btn-primary" />    	       				
            </form>
<?php 
				
			if(isset($_POST['cadastrar-usuario'])){					
				$email = strip_tags(trim($_POST['email-cadastra']));
				$confirmaEmail =  strip_tags(trim($_POST['email-confirma']));
				$senha  = strip_tags(trim($_POST['senha-cadastra'])).''.$email;
				$senha  = sha1(md5($senha));

				$confirmaSenha = strip_tags(trim($_POST['senha-confirma'])).''.$email;		
				$confirmaSenha = sha1(md5($confirmaSenha));		
				$senhaMail = strip_tags(trim($_POST['senha-cadastra']));	
				$hashValid = geraSenha();
				$hashValid = md5($email).''.md5($hashValid);
				
				if($email == $confirmaEmail){
					if($senha == $confirmaSenha){
						include "../Connections/config.php";
						
						$criadoEm = date('Y-m-d H:i:s');
						$ultimaEntrada = date('Y-m-d  H:i:s');
						$clienteNivel = 'cliente';
						$statusUsuario = 'pendente';
						$termosPrivacidade = 'aceito';
						
						$sql_verifica_email = 'SELECT email FROM sds_clientes WHERE email = :email;';
						
							try{
								$query_verifica_email = $connect->prepare($sql_verifica_email);
								$query_verifica_email->bindValue(':email', $email , PDO::PARAM_STR);
								$query_verifica_email->execute();
								
								$res_verifica_email = $query_verifica_email->rowCount(PDO::FETCH_ASSOC);
					
							}catch(PDOException $erro_verifica_email){
								echo "Erro ao verificar email";
							}
									
						if($res_verifica_email >= 1 ){
					
							echo  "<h5 style=\"float:left; width:300px; padding:5px; background:#fff; margin-top:5px;\">E-mail já cadastrado</h5>";	
									
						}else{
								
								if($email == ''){
									header("Location: index.php");
								}else{
									$sql_cadastra_usuario  = 'INSERT INTO sds_clientes(criadoEm, nivelDeAcesso,
															 email, senha, status, termosPrivacidade, validador) ';
									$sql_cadastra_usuario .= 'VALUES (:criadoEm, :nivelDeAcesso, :email, :senha,
															 :status, :termosPrivacidade, :hashValid);';
								}
							
							try{
								$query_cadastra_usuario = $connect->prepare($sql_cadastra_usuario);
								$query_cadastra_usuario->bindValue(':criadoEm', $criadoEm,PDO::PARAM_STR);
								//$query_cadastra_usuario->bindValue(':modificadoEM', $ultimaEntrada,PDO::PARAM_STR);
								$query_cadastra_usuario->bindValue(':nivelDeAcesso', $clienteNivel,PDO::PARAM_STR);
								$query_cadastra_usuario->bindValue(':email', $email,PDO::PARAM_STR);
								$query_cadastra_usuario->bindValue(':senha', $senha,PDO::PARAM_STR);
								$query_cadastra_usuario->bindValue(':termosPrivacidade', $termosPrivacidade,PDO::PARAM_STR);
								$query_cadastra_usuario->bindValue(':hashValid', $hashValid,PDO::PARAM_STR);			
								$query_cadastra_usuario->bindValue(':status', $statusUsuario,PDO::PARAM_STR);
								$query_cadastra_usuario->execute();
								
								$validador = 'http://saldaodeservicos.com/admin/painel.php?exe=validate&valmail='.$hashValid;
								$mail_data = date('Y-m-d  H:i:s');
								$mail = new PHPMailer();
								$mail->setLanguage('pt');
								
								$from	 	= 'naoresponda@saldaodeservicos.com';
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
								
								$mail->addAddress($email , $email);
								$mail->isHTML(true);
								$mail->CharSet 	= 'utf-8';
								$mail->WordWrap = 70;
								$mail->Subject 	= 'Cadastrado com sucesso';
								
								$criadoEm = date('d/m/Y H:i:s', strtotime($criadoEm));
								$mail_data = date('d/m/Y H:i:s', strtotime($mail_data));
								
								$mensagemCliente = "
								
								<strong>E-mail de seguran�a! Por favor, guarde este e-mail para futuras consultas.</strong><br><br>
								Seus dados são:<br>
								
								Login: $email <br>
								Senha: $senhaMail <br>
								
								Seu cadastro foi criado em: $criadoEm<br><br>
								
								Voc� precisa validar seu cadastro. Clique no link abaixo para validar:<br>
								<a href=\"$validador\">$validador</a><br><br>
								
								Esta mensagem é gerada automaticamente pelo nosso sistema, por favor, não responda!<br><br>
								
								Atenciosamente,<br>
								Equipe Saldão de serviços.
								
								<br><br>
								
								Mensagem enviada em $mail_data
								";
								
								$mail->Body		= $mensagemCliente;
								$mail->AltBody	= $mensagemCliente;
								
								if($mail->send()){
									echo  "<h5 style=\"float:left; width:300px; padding:5px; background:#fff; margin-top:5px;\">
								
											Cadastrado com sucesso! <br>
											Verifique sua caixa de e-mail!
										
										</h5>";
								}else{
									echo 'Erro: '.$mail->ErrorInfo;;	
								}						
								
							}catch(PDOException $erro_cadastro){
							
								echo 'Erro ao cadastrar';		
							}
						}
						
					}else{
						echo 'Senhas não conferem';	
					}
				}else{
					echo 'E-mails não conferem';	
				}
			}			
?>
       		</div>
    	</div>	
 	</article>
