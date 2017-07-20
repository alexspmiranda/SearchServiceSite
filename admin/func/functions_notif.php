<?php

function sds_pagamentoInformado(){
	
	include "../Connections/config.php";
	
	$sql_pagamentoInformado = 'SELECT notificadoPagamento FROM sds_pagamento WHERE notificadoPagamento = 0';
	
	$query_pagamentoInformado = $connect->prepare($sql_pagamentoInformado);
	$query_pagamentoInformado->execute();
	
	$resultado_pagamentoInformado 		= $query_pagamentoInformado->fetchAll(PDO::FETCH_ASSOC);
	$resultado_pagamentoInformadoCont	= $query_pagamentoInformado->rowCount(PDO::FETCH_ASSOC);
	 
	return $resultado_pagamentoInformadoCont;
	
}

function sds_pagamentoInformadoLido(){
	
	include "../Connections/config.php";
	
	$notificadoPagamento = '1';
	$sql_marcaLido = 'UPDATE sds_pagamento SET notificadoPagamento = :notificadoPagamento ';
	
	try{
		$query_marcaLido = $connect->prepare($sql_marcaLido);
		$query_marcaLido->bindValue(':notificadoPagamento', $notificadoPagamento,PDO::PARAM_STR);
		$query_marcaLido->execute();
		
	}catch(PDOException $erro_pagamentoLido)
	{
		echo 'Não foi possível verificar pagamento como visto';
	}
}

function sds_anuncioInformado(){
	
	include "../Connections/config.php";
	
	$sql_anuncioInformado = 'SELECT notificadoAnuncio FROM sds_anuncio WHERE notificadoAnuncio = "0"';
	
	$query_anuncioInformado = $connect->prepare($sql_anuncioInformado);
	$query_anuncioInformado->execute();
	
	$resultado_anuncioInformado 	= $query_anuncioInformado->fetchAll(PDO::FETCH_ASSOC);
	$resultado_anuncioInformadoCont	= $query_anuncioInformado->rowCount(PDO::FETCH_ASSOC);
	 
	return $resultado_anuncioInformadoCont;
	
}

function sds_anuncioInformadoLido(){
	
	include "../Connections/config.php";
	
	$notificadoAnuncioInformado = '1';
	$sql_AnuncioInformadoLido = 'UPDATE sds_anuncio SET notificadoAnuncio = :notificadoAnuncioInformado ';
	
	try{
		$query_AnuncioInformadoLido = $connect->prepare($sql_AnuncioInformadoLido);
		$query_AnuncioInformadoLido->bindValue(':notificadoAnuncioInformado', $notificadoAnuncioInformado,PDO::PARAM_STR);
		$query_AnuncioInformadoLido->execute();
		
	}catch(PDOException $erro_anuncioInformadoLido)
	{
		echo 'Não foi possível verificar pagamento como visto';
	}
	
}

function sds_mensagemSite(){
	
	include "../Connections/config.php";
	
	$sql_mensagemSite = 'SELECT notificadoPagamento FROM sds_contato WHERE notificadoPagamento = "0"';
	
	$query_mensagemSite = $connect->prepare($sql_mensagemSite);
	$query_mensagemSite->execute();
	
	$resultado_mensagemSite 	= $query_mensagemSite->fetchAll(PDO::FETCH_ASSOC);
	$resultado_mensagemSiteCont	= $query_mensagemSite->rowCount(PDO::FETCH_ASSOC);
	 
	return $resultado_mensagemSiteCont;
	
}

function sds_mensagemSiteLido(){
	
	include "../Connections/config.php";
	
	$notificadoMensagemSiteLido = '1';
	$sql_mensagemSiteLido = 'UPDATE sds_contato SET notificadoPagamento = :notificadoMensagemSiteLido ';
	
	try{
		$query_mensagemSiteLido = $connect->prepare($sql_mensagemSiteLido);
		$query_mensagemSiteLido->bindValue(':notificadoMensagemSiteLido', $notificadoMensagemSiteLido,PDO::PARAM_STR);
		$query_mensagemSiteLido->execute();
		
	}catch(PDOException $erro_mensagemSiteLido)
	{
		echo 'Não foi possível verificar pagamento como visto';
	}
	
}

function sds_denunciados(){
	
	include "../Connections/config.php";
	
	$notificadoDenuncia = '0';
	$sql_denunciados = 'SELECT notificadoDenuncia FROM sds_denuncias WHERE notificadoDenuncia = :notificadoDenuncia';
	
	$query_denunciados = $connect->prepare($sql_denunciados);
	$query_denunciados->bindValue(':notificadoDenuncia', $notificadoDenuncia,PDO::PARAM_STR);
	$query_denunciados->execute();
	
	$resultado_denunciados 	= $query_denunciados->fetchAll(PDO::FETCH_ASSOC);
	$resultado_denunciadosCont	= $query_denunciados->rowCount(PDO::FETCH_ASSOC);
	 
	return $resultado_denunciadosCont;
	
}

function sds_denunciadosLido(){
	
	include "../Connections/config.php";
	
	$notificadodenunciados = '1';
	$sql_denunciadosLido = 'UPDATE sds_denuncias SET notificadoDenuncia = :notificadodenunciados ';
	
	try{
		$query_denunciadosLido = $connect->prepare($sql_denunciadosLido);
		$query_denunciadosLido->bindValue(':notificadodenunciados', $notificadodenunciados,PDO::PARAM_STR);
		$query_denunciadosLido->execute();
		
	}catch(PDOException $erro_denunciadosLido)
	{
		echo 'Não foi possível verificar pagamento como visto';
	}
	
}

?>
