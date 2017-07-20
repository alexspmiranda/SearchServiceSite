<?php

function showImages($nomeAnunciante, $idImagem){	
	$imagem = 'http://saldaodeservicos.com/img/uploads/'. md5($nomeAnunciante).'/'.md5($nomeAnunciante).'_image_'.$idImagem.'.jpg';
	return $image;
}

?>