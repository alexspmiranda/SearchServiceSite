<?php
function nocached_mfile($filename) {
	return "{$filename}?cache=".date("dmYHis",filemtime($filename));
}
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
	
	// Caracteres de cada tipo
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	 
	// Variáveis internas
	$retorno = '';
	$caracteres = '';
	 
	// Agrupamos todos os caracteres que poderão ser utilizados
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;
	 
	// Calculamos o total de caracteres possíveis
	$len = strlen($caracteres);
	 
	for ($n = 1; $n <= $tamanho; $n++) {
		// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
		$rand = mt_rand(1, $len);
		// Concatenamos um dos caracteres na variável $retorno
		$retorno .= $caracteres[$rand-1];
	}
 
return $retorno;
}

function mail_status($status, $plano, $email)
{
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
	
	$mail->addAddress($email , $email);
	$mail->isHTML(true);
	$mail->CharSet 	= 'utf-8';
	$mail->WordWrap = 70;
	$mail->Subject 	= 'Seu status mudou para '.$status;

	$mail_data = date('d/m/Y H:i:s', strtotime($mail_data));
	
	if($status == 'patrocinado')
	{
		$mensagemStatus = 'Seu status foi mudado para: <strong>'.$status.'</strong> - Plano: <strong>'.$plano.'</strong>';
	}else{
		$mensagemStatus = 'Seu status foi mudado para: <strong>'.$status.'</strong>';
	}
	
	$mensagemCliente = "
	
	<strong>COMUNICADO!!!</strong><br><br>
	$mensagemStatus <br><br>
	
	Entenda por que mudou:<br />
	<a href=\"#\">Meu status mudou<a><br /><br />
	
	Esta mensagem é gerada automaticamente pelo nosso sistema, por favor, não responda!<br><br>
	
	Atenciosamente,<br>
	Equipe Saldão de serviços.
	
	<br><br>
	
	Mensagem enviada em $mail_data
	";
	
	$mail->Body		= $mensagemCliente;
	$mail->AltBody	= $mensagemCliente;
	
	if($mail->send()){

	}else{
		echo 'Erro: '.$mail->ErrorInfo;;	
	}	
}

function verificar_urlAdmin($idAnuncio, $idFoto){

	include "../Connections/config.php";
	 
	$sql_validaUrl = "SELECT midia.* FROM sds_midia midia WHERE idAnuncio_fk = :idAnuncio AND nomeFoto = :idFoto";
	 
	$query_validaUrl = $connect->prepare($sql_validaUrl);
	$query_validaUrl->bindValue(':idAnuncio', $idAnuncio, PDO::PARAM_STR);
	$query_validaUrl->bindValue(':idFoto', $idFoto, PDO::PARAM_STR);
	$query_validaUrl->execute();
	 
	$resultado_validaUrl = $query_validaUrl->fetchAll(PDO::FETCH_ASSOC);

	foreach($resultado_validaUrl as $res_validaUrl){
        $url = $res_validaUrl["caminhoFoto"];	
	}

	if($url == 1){
		$url = true;
	}else{
		$url = false;
	}

	return $url;
}

function sds_deletePic($idPhoto, $idAnuncio){
	include "../Connections/config.php";

	$sql_excluiPhoto = 'DELETE FROM sds_midia WHERE idAnuncio_fk = :idAnuncio AND nomeFoto = :idPhoto';
			
	try{			
		$query_excluiPhoto = $connect->prepare($sql_excluiPhoto);
		$query_excluiPhoto->bindValue(':idAnuncio', $idAnuncio, PDO::PARAM_STR);
		$query_excluiPhoto->bindValue(':idPhoto', $idPhoto, PDO::PARAM_STR);
		$query_excluiPhoto->execute();
		
		$excluidoSucesso = 'Foto excluída com sucesso';
		
	}catch(PDOException $erro_excluiPhoto){
		echo 'Não foi possível excluir a foto.';
	}
}
?>