<?php 
require "showerrors.php";
include "nav/func/funcoes.php"; 
require 'phpmailer/class.phpmailer.php';
require 'phpmailer/PHPMailerAutoload.php';
?>
<?php require "nav/func/single_func.php"; ?>
<?php require "nav/func/page_func.php"; ?>
<?php
// NOVAS FUNÇÕES
require "nav/functions/sds_insertPage.php"; 
require "nav/functions/sds_selectPage.php"; 
require "nav/functions/sds_insertSingle.php"; 
require "nav/functions/sds_selectSingle.php";
require "nav/functions/sds_updateSingle.php"; 
require "nav/func/page_cat.php";
require "nav/func/page_city.php";
require "nav/func/single_title.php";
?>

<html> 
<head>
	<?php
		$urlTitle = Url::getURL(1);
		$idCliente = strip_tags(trim($urlTitle));
		$idCliente = sds_buscaId($urlTitle);
		$resultado_getSingle = sds_selectGetSingle($idCliente);
		foreach($resultado_getSingle as $res_getSingle){
			$tituloAnuncio 		= $res_getSingle['tituloAnuncio'];
			$descricaoAnuncio 	= $res_getSingle['descricaoAnuncio'];
			$emailAnunciante	= $res_getSingle['email'];
		}
		if(!empty($urlTitle)){
		     $imagem_um		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/'. md5($emailAnunciante).'_image_1.jpg';
	    }else{
    		$imagem_um		= 'http://saldaodeservicos.com/img/others/logoshare.jpg';
        }
    ?>	
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<?php
 	$resultado_getSingle = sds_selectGetSingle($idCliente);
	
	foreach($resultado_getSingle as $res_getSingle){
		$descricaoAnuncio 	= $res_getSingle['descricaoAnuncio'];
	}
	if(!empty($urlTitle)){
		     $descricaoAnuncio		= $descricaoAnuncio;
	    }else{
    		$descricaoAnuncio		= 'Encontre empresas e prestadores de serviços de todo o Brasil. Anuncie grátis seus serviços ou de sua empresa e aumente seus lucros.';
        }
	?>
<meta name="description" content="<?php echo $descricaoAnuncio; ?>" />
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="anúncios grátis, anuncie, anúnciosde serviços, anunciar serviço, anuncios, serviços, saldão de serviços"/>
    <meta http-equiv="cache-control" content="no-store, no-cache, must-revalidate, Post-Check=0, Pre-Check=0">
    <meta http-equiv="expires" content="0">
	<meta http-equiv="pragma" content="no-cache">
	<link rel="shortcut icon" href="<?php echo URL::getBase() ?>img/icon/icon.png" >
    
	<meta property="og:title" content="<?php sds_getSingleTitle(); ?>">
	<meta property="og:description" content="<?php echo $descricaoAnuncio; ?>">
	<meta property="og:site_name" content="Saldão de serviços">
	<meta property="og:image" content="<?php echo $imagem_um; ?>">
	<meta property="og:image:width" content="800">
	<meta property="og:image:height" content="600"> 

    <?php 
		$urlTitle = Url::getURL(0);

		if($urlTitle == "anuncio"){?>
			<title> <?php sds_getSingleTitle(); ?> - SALDÃO DE SERVIÇOS </title><?php
		}elseif($urlTitle == "estado"){
			echo '<title>Saldão de serviços - Anuncie grátis - '.Url::getURL(1).'</title>';
		}else{
			echo '<title>Saldão de serviços - Anuncie grátis</title>';
		}
	?>

	
	<link rel="stylesheet" type="text/css" href="<?php echo URL::getBase() ?>css/bootstrap.min.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="<?php echo URL::getBase() ?>css/style.css?<?php echo filemtime(dirname(__FILE__).'/css/style.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo URL::getBase() ?>css/style_page.css?<?php echo filemtime(dirname(__FILE__).'/css/style_page.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo URL::getBase() ?>css/style_single.css?<?php echo filemtime(dirname(__FILE__).'/css/style_single.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo URL::getBase() ?>css/component.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo URL::getBase() ?>css/lightbox.css" />
	<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
	<![endif]-->

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-67430716-1', 'auto');
	  ga('send', 'pageview');

	</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}

$(function($){
    // No id #enviar assim que clicar executa a função
    $('#enviar').click(function(){
        var estado = $('#pesquisaestado').val();
        var categoria = $("#pesquisa").val();
 		
 		if (estado == null || estado == "" ) {
	        alert("Informe algum estado");
	    }else if(categoria == null || categoria == ""  ) {
	        alert("Informe o que está procurando");
	    }else{

	    	localiza = estado.split(", ");
	    	cidade = localiza[0];
	    	estado = localiza[1];
	    	cidade = replaceAll(cidade, ' ', '+');
	    	categoria = replaceAll(categoria, ' ', '+');

	    	$(location).attr('href', 'http://saldaodeservicos.com/estado/?q='+estado.toLowerCase()+'-'+cidade.toLowerCase().replace(' ', '+')+'-'+categoria.toLowerCase());
	    	//$(location).attr('href', 'http://localhost/sdsv2/estado?q='+estado.toLowerCase()+'-'+cidade.toLowerCase().replace(' ', '+')+'-'+categoria.toLowerCase());
	    
	    }
    });
});
</script>

</head>

<body onload="initialize()">

<header class="container-fluid header">
	<div class="container">
		<a href="<?php echo URL::getBase() ?>"><img src="<?php echo URL::getBase() ?>img/others/logo.png" alt="Logo do saldão de serviços" class="logo hidden-phone"></a>
		<a href="<?php echo URL::getBase() ?>"><img src="<?php echo URL::getBase() ?>img/others/logo_mobile.png" alt="Logo do saldão de serviços" class="logo logomobile visible-phone"></a>
		
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
									<a href="<?php echo URL::getBase() ?>contato" rel="dofollow">Alguma dúvida? Entre em contato</a>
								</small>
							</li>
                            
                            <div class="account">
								<h5><li><a href="<?php echo URL::getBase() ?>admin/painel" title="Anuncie grátis"> Anuncie grátis | </a><a href="<?php echo URL::getBase() ?>admin/painel" title="Minha conta"><i class="icon-user icon-white"></i> Minha conta</a> </h5></li>
							</div>

                        </ul>
                    </div><!--/.nav-collapse -->
               </div>
       		</div>

			<div class="banner-top hidden-phone">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- bottom_saldao -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6123794574040714"
     data-ad-slot="5965709383"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
				<!-- <a href="http://saldaodeservicos.com/anuncio/hinode--perfumaria-e-cosmeticos-84"><img src="<?php echo URL::getBase() ?>img/others/banner_top.jpg"></a> -->
			</div>
		</div>		
	</div>
</header>