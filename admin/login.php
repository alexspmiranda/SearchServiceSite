<?php
require_once('../Connections/saldaodeservicos.php');
require_once('func/functions.php');
require_once('funcoes/sds_selectAnuncios.php');
require_once('funcoes/sds_updateAnuncios.php');

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
   $MM_redirectLoginSuccess = "painel/";
   $MM_redirectLoginFailed = "<h5 style=\"float:left; padding:5px; background:#fff; margin-top:5px;\">*** Falha ao logar! Verifique usuário e senha!</h5>";
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
require '../phpmailer/class.phpmailer.php';
require '../phpmailer/PHPMailerAutoload.php';
$validador = strip_tags(trim($_GET['validador']));

?>
<html> 
<head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Encontre empresas e prestadores de serviços de todo o Brasil. Anuncie grátis seus serviços ou de sua empresa e aumente seus lucros." />

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="all"/>
 	<link rel="stylesheet" type="text/css" href="css/style.css"/>

 	<link rel="shortcut icon" href="img/icon/icon.png">  
    <title>Saldão de serviços - Anuncie grátis</title>
	
</head>

<body>
<header class="container-fluid header">
	<div class="container">
		<a href="<?php echo URL::getBase() ?>../"><img src="<?php echo URL::getBase() ?>img/others/logo.png" alt="Logo do saldão de serviços" class="logo hidden-phone"></a>
		<a href="<?php echo URL::getBase() ?>../"><img src="<?php echo URL::getBase() ?>img/others/logo_mobile.png" alt="Logo do saldão de serviços" class="logo logomobile visible-phone"></a>
		
		<div class="header-info">
			<div class="navbar">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse" style="margin:-5px 0;">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
							<li>
								<small class="contact"><i class="icon-envelope icon-white "></i>
									<a href="#" rel="dofollow">Alguma dúvida? Entre em contato</a>
								</small>
							</li>
                            
                            <div class="account">
								<h5><li><a href="<?php echo URL::getBase() ?>../admin/index.php" title="Anuncie grátis"> Anuncie grátis | </a><a href="<?php echo URL::getBase() ?>../admin/index.php" title="Minha conta"><i class="icon-user icon-white"></i> Minha conta</a> </h5></li>
							</div>

                        </ul>
                    </div><!--/.nav-collapse -->
               </div>
       		</div>

			<div class="banner-top hidden-phone">
				<img src="<?php echo URL::getBase() ?>img/others/banner_top.jpg">
			</div>
		</div>		
	</div>
</header>

<?php

if(isset($_POST['esqueci-email-bt'])){
		
		$esqueciEmail = strip_tags(trim($_POST['esqueci-email']));
		
		$sql_verifica_email = 'SELECT email FROM sds_clientes WHERE email = :email;';
						
		try{
			$query_verifica_email = $connect->prepare($sql_verifica_email);
			$query_verifica_email->bindValue(':email', $esqueciEmail , PDO::PARAM_STR);
			$query_verifica_email->execute();
			
			$res_verifica_email = $query_verifica_email->rowCount(PDO::FETCH_ASSOC);

		}catch(PDOException $erro_verifica_email){
			echo "Erro ao verificar email";
		}
				
		if($res_verifica_email >= 1 ){
								
			$novaSenha = geraSenha();
			
			$novaSenhaLink = $novaSenha;
			$novaSenha = $novaSenha.''.$esqueciEmail;
			$novaSenha = sha1(md5($novaSenha));
			
			try{
				$sql_cadastraAnuncio  = 'UPDATE sds_clientes SET senha = :senhaNova WHERE email = :email';
				
				$query_cadastraAnuncio = $connect->prepare($sql_cadastraAnuncio);
				$query_cadastraAnuncio->bindValue(':senhaNova', $novaSenha, PDO::PARAM_STR);
				$query_cadastraAnuncio->bindValue(':email', $esqueciEmail, PDO::PARAM_STR);
				$query_cadastraAnuncio->execute();
									
				$mail_data = date('Y-m-d  H:i:s');
				$mail = new PHPMailer();
				$mail->setLanguage('pt');
				
				$from	 	= 'naoresponda@saldaodeservicos.com';
				$fromName 	= 'Saldão de serviços';
				
				$host		= 'mail.saldaodeservicos.com';
				$username	= 'naoresponda@saldaodeservicos.com';
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
				
				$mail->addAddress($esqueciEmail , $esqueciEmail);
				$mail->isHTML(true);
				$mail->CharSet 	= 'utf-8';
				$mail->WordWrap = 70;
				$mail->Subject 	= 'Nova senha';

				$mail_data = date('d/m/Y H:i:s', strtotime($mail_data));
				
				$mensagemCliente = "
				
				<strong>E-mail de segurança! Por favor, guarde este e-mail para futuras consultas.</strong><br><br>
				Sua nova senha é: <strong>$novaSenhaLink</strong> <br><br>
			
				Esta mensagem é gerada automaticamente pelo nosso sistema, por favor, não responda!<br><br>
				
				Atenciosamente,<br>
				Equipe Saldão de serviços.
				
				<br><br>
				
				Mensagem enviada em $mail_data
				";
				
				$mail->Body		= $mensagemCliente;
				$mail->AltBody	= $mensagemCliente;
				
				if($mail->send()){
					$cadastradoComSucesso = 'Atualizado com sucesso';
				}else{
					echo 'Erro: '.$mail->ErrorInfo;;	
				}	
				
			}catch(PDOException $erro_atualizarSenha){
				echo 'Erro ao atualizar senha';
			}		
			
			$senhaEnviada = "<h5 style=\"float:left; padding:5px; background:#fff; margin-top:5px;\">Senha enviada com sucesso!</h5>";
					
		}else{
			$emailNaoEncontrado =  "<h5 style=\"float:left; padding:5px; background:#fff; margin-top:5px;\">E-mail não encontrado</h5>";
		}
	}
		
	?>

<div class="container">
	<div class="login">
		
		<h4> Acessar minha conta </h4>

		<form action="<?php echo $loginFormAction; ?>" method="POST"  name="login-painel" enctype="multipart/form-data">
        	<label>
	        	<h5>E-mail: </h5>
	       		<input type="text" name="email" placeholder="Digite seu e-mail" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
            </label>
            
            <label>
            	<h5>Senha: </h5>
				<input type="password" name="senha"  placeholder="Digite sua senha"  maxlenght="12" required /><br>
            </label>
            <input type="submit" class="btn loginbuttonform" value="Logar"/>
        </form>

        <a data-toggle="modal" href="#" data-target="#rememberpass" ><br><h4> <small>[ Esqueci a senha ] </small></h4></a>
	</div>	

	<div class="modal hide fade remember-pass" id="rememberpass">
		<div class="modal-header">
	   		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	   		<h3 id="myModalLabel">Esqueci a senha</h3>
	 	</div>

		<form  method="post" enctype="multipart/form-data">
		    <br> &nbsp &nbsp <input type="email" name="esqueci-email" size="30" placeholder="Digite seu e-mail" required  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />

			<div class="modal-footer">
		    	<input type="submit" value="Reenviar senha" class="btn btn-primary" name="esqueci-email-bt" />        
		</form>
	   			<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
			</div>
	</div>

	<div class="register">
		<h3>Não possui uma conta?</h3>
		<a href="fbconfig.php" class="fblogin"></a>
		<a href="#" data-toggle="modal" data-target="#register" class="registerbt"></a>
	</div>
	
	<div class="modal hide fade registermodal" id="register">
		<div class="modal-header">
	   		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	   		<h3 id="myModalLabel">Cadastre-se agora, é grátis</h3>
	 	</div>

		<form  method="POST" action="" name="#cadastra_cliente" enctype="multipart/form-data">
            
            <h5>E-mail: </h5>
            <input type="text" name="email-cadastra"  required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
            <h5>Confirme o e-mail: </h5>
            <input type="text" name="email-confirma"  required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
            <h5>Senha: </h5>
            <input type="password" placeholder="digite entre 6 e 12 caracteres" name="senha-cadastra" pattern=".{6,12}" title="Digite entre 6 e 10 caracteres (Maiúsculas e minúsculas para maior segurança)" id="#senha" required maxlength="12" />
            <h5>Confirme a senha:</h5>
            <input  type="password" placeholder="digite entre 6 e 12 caracteres" name="senha-confirma" pattern=".{6,12}" title="Digite entre 6 e 10 caracteres" id="#senhaConfirma" maxlength="12" required /><br>

           	<input type="checkbox" name="termos" value="aceito" style=" float:left; margin-top:-4px;" required />
           	<h5> Aceito os <a href="http://www.saldaodeservicos.com/termos-privacidade" target="_blank">termos</a> e <a href="http://www.saldaodeservicos.com/termos-privacidade" target="_blank">políticas de privacidade</a></h5><br>

		<div class="modal-footer">
	    	 <input type="submit" value="Cadastrar" name="cadastrar-usuario" class="btn btn-primary" />    	       				
        </form>
   			<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
		</div>
	</div>
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
						$query_cadastra_usuario->bindValue(':nivelDeAcesso', $clienteNivel,PDO::PARAM_STR);
						$query_cadastra_usuario->bindValue(':email', $email,PDO::PARAM_STR);
						$query_cadastra_usuario->bindValue(':senha', $senha,PDO::PARAM_STR);
						$query_cadastra_usuario->bindValue(':termosPrivacidade', $termosPrivacidade,PDO::PARAM_STR);
						$query_cadastra_usuario->bindValue(':hashValid', $hashValid,PDO::PARAM_STR);			
						$query_cadastra_usuario->bindValue(':status', $statusUsuario,PDO::PARAM_STR);
						$query_cadastra_usuario->execute();
						
						$validador = 'http://saldaodeservicos.com/admin/painel/validate?valmail='.$hashValid;
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
						
						<strong>E-mail de segurança! Por favor, guarde este e-mail para futuras consultas.</strong><br><br>
						Seus dados são:<br>
						
						Login: $email <br>
						Senha: $senhaMail <br>
						
						Seu cadastro foi criado em: $criadoEm<br><br>
						
						Você precisa validar seu cadastro. Clique no link abaixo para validar:<br>
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
							echo  '<div class="alert alert-info" role="alert" style="float:right;">Cadastrado com sucesso! Verifique sua caixa de e-mail ou de spam.</div>';
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