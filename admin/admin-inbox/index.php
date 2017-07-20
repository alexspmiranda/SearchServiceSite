<?php

require "../classes/Url.php";

$pagina = Url::getURL( 0 );
$pagina_dois = Url::getURL(1);
$pagina_tres = Url::getURL(2);

$pagina = strip_tags(trim($pagina));
$pagina_dois = strip_tags(trim($pagina_dois)); 
$pagina_tres = strip_tags(trim($pagina_tres));

if($pagina == null || $pagina == "index.php"){
	require_once("login.php");
}elseif($pagina == "painel"){
	if($pagina_dois == "conta"){
		if($pagina_tres == "mudar-senha"){
			require_once("cliente-anuncio/mudar-senha.php");
		}else{
			require_once("cliente-anuncio/minha-conta.php");
		}
	}elseif($pagina_dois == "anuncio"){
		if($pagina_tres == "endereco"){
			require_once("cliente-anuncio/meu-endereco.php");
		}elseif ($pagina_tres == "fotos") {
			require_once("cliente-anuncio/minhas-fotos.php");	
		}else{
			require_once("cliente-anuncio/meu-anuncio.php");
		}
	}elseif($pagina_dois == "inbox"){
		if($pagina_tres == "respondidos"){
			require_once("cliente-inbox/respondidos.php");
		}elseif($pagina_tres == "resposta"){
			require_once("cliente-inbox/resposta.php");
		}elseif($pagina_tres == "search"){
			require_once("cliente-inbox/search.php");
		}else{
			require_once("cliente-inbox/inbox.php");	
		}
	}elseif($pagina_dois == "deslogar"){
		require_once("deslogar.php");
	}elseif($pagina_dois == "passo1"){
		require_once("passo1.php");
	}elseif($pagina_dois == "passo2"){
		require_once("passo2.php");
	}elseif($pagina_dois == "passo3"){
		require_once("passo3.php");
	}elseif($pagina_dois == "passo4"){
		require_once("passo4.php");
	}elseif($pagina_dois == "validate"){
		require_once("validate.php");
	}

	// PAGINA ADMIN

	elseif($pagina_dois == "clientes"){

		if($pagina_tres == "ativos"){
			require_once("admin-nav/clientes/ativos.php");
		}elseif($pagina_tres == "pendentes"){
			require_once("admin-nav/clientes/pendentes.php");
		}elseif($pagina_tres == "desativados"){
			require_once("admin-nav/clientes/desativados.php");
		}elseif($pagina_tres == "processo"){
			require_once("admin-nav/clientes/processo.php");
		}elseif($pagina_tres == "patrocinados"){
			require_once("admin-nav/clientes/patrocinados.php");
		}elseif($pagina_tres == "gerenciador"){
			require_once("admin-nav/gerenciador.php");
		}



	}elseif($pagina == "passo2") {
require_once("passo2.php");
}else{
		require_once("home/home.php");
	}
}else{
	require_once("../404.php");
}
?>