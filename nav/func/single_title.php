<?php

function sds_getSingleTitle(){

	include "Connections/config.php";

	$urlTitle = Url::getURL(1);
	$idCliente = strip_tags(trim($urlTitle));
	$idCliente = sds_buscaId($urlTitle);

	$resultado_getSingle = sds_selectGetSingle($idCliente);
	foreach($resultado_getSingle as $res_getSingle){
		$nomeFantasia 		= $res_getSingle['nomeFantasiaAnuncio'];
		$tituloAnuncio 		= $res_getSingle['tituloAnuncio'];
		$categoriaAnuncio   = $res_getSingle['categoriaAnuncio'];
		$bairroAnuncio 		= $res_getSingle['bairroAnuncio'];
		$cidadeAnuncio 		= $res_getSingle['cidadeAnuncio'];
		$estadoAnuncio 		= $res_getSingle['uf'];

		echo $tituloAnuncio.' | '.$nomeFantasia.' - '.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$estadoAnuncio;
	}
}
?>