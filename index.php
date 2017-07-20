<?php require "classes/Url.php"; ?>
<?php

$url = $_SERVER['REQUEST_URI'];
$url = explode('/', $url);

$pagina = Url::getURL( 0 );
$pagina = strip_tags(trim($pagina));

if($pagina == null || $pagina == "index.php"){ 
	$pagina = "index"; 
}
if( file_exists( $pagina . ".php" ) ){
	include_once("header.php");
	require_once("nav/home.php");
	include_once("footer.php");
}elseif($pagina == "estados"){
	include_once("header.php");
	require_once("nav/home.php");
	require_once("footer.php");
}elseif($pagina == "estado"){
	if($url[2] == null){
		
		require_once("header.php");
		require_once("nav/home.php");
		require_once("footer.php");
	}else{
		if($url[2] == 'busca.php' || $url[3] == 'busca.php' || $url[4] == 'busca.php' || $url[5] == 'busca.php' || $url[6] == 'busca.php'){
			require_once('busca.php');
		}elseif($url[2] == 'buscaCity.php' || $url[3] == 'buscaCity.php' || $url[4] == 'buscaCity.php' || $url[5] == 'buscaCity.php' || $url[6] == 'buscaCity.php'){
			require_once('buscaCity.php');
		}elseif($url[2] != 'busca.php'){
			require_once("header.php");
			require_once("nav/page.php");
			require_once("footer.php");
		}
	}
}elseif($pagina == "anuncios"){
	require_once("header.php");
	require_once("nav/home.php");
	require_once("footer.php");
}elseif($pagina == "anuncio"){
	if($url[2] == null){
		require_once("header.php");
		require_once("nav/home.php");
		require_once("footer.php");
	}else{
		require_once("header.php");
		require_once("nav/single.php");
		require_once("footer.php");
	}
}elseif($pagina == 'contato' || $pagina == 'contato.php'){
	require_once("header.php");
	require_once("nav/contato.php");
	require_once("footer.php");
}elseif($pagina == 'termos-privacidade' || $pagina == 'termos-privacidade.php'){
	require_once("header.php");
	require_once("nav/termos-privacidade.php");
	require_once("footer.php");
}elseif($pagina == "ajuda"){
	require_once("header.php");
	require_once("nav/help/ajuda.php");
	require_once("footer.php");
}elseif($pagina == 'admin'){
	if($url[2] == 'painel.php' || $url[2] == 'painel')
		require_once("admin/home/home.php");
	else{
		require_once('404.php');
	}
}else{
	require_once "nav/func/funcoes.php"; 
	$urlAnuncio = sds_buscaUrl($pagina);
}

?>