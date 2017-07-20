<?php

echo '...';
$url = strip_tags(trim($_GET['q']));
$urlVector = explode('-', $url);
$url = $urlVector[0];
if($url == 'undefined'){
	$urlUndefined = $url;
	$url = 'brasil';
}

$cidadeAnuncio = $urlVector[1];
$categoriaAnuncio = $urlVector[2];

if(strlen($url)==2){ //AQUI RECEBE A QUERY DA BUSCA E VERIFICA A UF SE EXISTIR ELE ENTRA E RETORNA O ESTADO
	$url = sds_retornaLinkEstado(strtoupper($url));
}else{ // CASO NÃO HAJA QUERY ELE BUSCA O ESTADO POR INTEIRO
	if($url != 'brasil'){// caso a query não seja brasil
		$url = Url::getURL(1);

		if(empty($url))
			$url = strtolower(strip_tags(trim($_GET['city'])));

		$url = urldecode($url);
		$url = strtolower($url);
	}
}


if(	$url == 'acre' || $url == 'alagoas' || $url == 'amazonas' || $url == 'amapa' || $url == 'bahia' || $url == 'minas-gerais' || $url == 'minas gerais' || $url == 'ceara' ||
   	$url == 'distrito-federal' || $url == 'distrito federal' || $url == 'brasilia' || $url == 'brasília' || $url == 'espirito-santo' || $url == 'espirito santo' || $url == 'goias' || $url == 'maranhao' || $url == 'mato-grosso-do-sul' || $url == 'mato grosso do sul' || $url == 'mato-grosso' || $url == 'mato grosso' ||
   	$url == 'para' || $url == 'paraiba' || $url == 'pernambuco' || $url == 'piaui' || $url == 'parana' || $url == 'rio-de-janeiro' || $url == 'rio de janeiro' || $url == 'rondonia' ||
   	$url == 'rio-grande-do-norte' || $url == 'rio grande do norte' || $url == 'roraima' || $url == 'rio-grande-do-sul' || $url == 'rio grande do sul' || $url == 'santa-catarina' || $url == 'santa catarina' || $url == 'sergipe' || $url == 'sao-paulo' || $url == 'sao paulo' |
   	$url == 'tocantins' || $url == 'brasil'){

	if($url == 'brasilia' || $url == 'brasília')
		$url == 'distrito-federal';

	$estadoAnuncio = strip_tags(trim($url));
	$estadoAnuncioLink = $estadoAnuncio;
	
	$estadoUF = sds_verificaUF($estadoAnuncio);
	$estadoAnuncio = sds_verificaEstados($estadoAnuncio);
	
	if(isset($_POST['bt-search-category'])){
		$categoriaAnuncio = strip_tags(trim($_POST['busca-categoria']));
		$cidadeAnuncio = strip_tags(trim($_POST['busca-cidade']));	
		
		$citKeyWords 	= $cidadeAnuncio;
		$catKeyWords 	= $categoriaAnuncio;
		sds_inserePalavraChaveCategoria($citKeyWords, $catKeyWords);
	}
	if(empty($categoriaAnuncio)){
		if(isset($_POST['bt-search-category'])){
			$categoriaAnuncio = null;
		}else{
			$categoriaAnuncio = urldecode(Url::getURL(5));
			$categoriaAnuncio = strip_tags(trim($categoriaAnuncio));
		}
	}
	if(empty($cidadeAnuncio)){
		if(isset($_POST['bt-search-category'])){
			$cidadeAnuncio = null;
		}else{
			if(urldecode(Url::getURL(2)) == 'cidade'){
				$cidadeAnuncio = urldecode(Url::getURL(3));
				$cidadeAnuncio = strip_tags(trim($cidadeAnuncio));
			}elseif(urldecode(Url::getURL(2)) == 'categoria'){
				//ESTE PARTE É PARA CONSULTAS NO BRASIL TODO
				// O FILTRO NÃO VAI PEGAR CIDADE PORQUE É BRASIL TODO
				$categoriaAnuncio = urldecode(Url::getURL(3));
				$categoriaAnuncio = strip_tags(trim($categoriaAnuncio));
			}
		}
	}
?>

<div class="container-fluid ads-top">
	<div class="container"> <h4>Patrocinados <small><a href="#">*saiba mais</a></small></h4></div>	
</div>

<div class="container">
	
	<ul class="ads-header-top">
		<?php require_once "nav/functions/page_patrocinados.php"; ?>
	</ul>

</div>

<?php 
if($urlUndefined == 'undefined'){
	echo '<br><br><div class="container-fluid" style="text-align:center; background:red; padding:10px; color:#FFF;">
		<h3>OPSSS... Sua busca não retornou nenhum estado.</b></h3></div>
	';
}

?>


<div class="container-fluid stateshome">
	<div class="container"> 
		<h4>Escolha outro estado: 
			<small><a href="<?php echo URL::getBase() ?>estado/Acre">AC</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Alagoas">AL</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Amazonas">AM</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Amapa">AP</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Bahia">BA</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Ceara">CE</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/distrito-federal">DF</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/espirito-santo">ES</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Goias">GO</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Maranhao">MA</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/minas-gerais">MG</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/mato-grosso-do-sul">MS</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/mato-grosso">MT</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Para">PA</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Paraiba">PB</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Pernambuco">PE</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Piaui">PI</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Parana">PR</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/rio-de-janeiro">RJ</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/rio-grande-do-norte">RN</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Rondonia">RO</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Roraima">RR</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/rio-grande-do-sul">RS</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/santa-catarina">SC</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Sergipe">SE</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/sao-paulo">SP</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Tocantins">TO</a></small>
			<small><a href="<?php echo URL::getBase() ?>estado/Brasil">BRASIL</a></small>
		</h4>
	</div>	
</div>

<div class="container banner-middle">
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
	<!-- <img src="<?php echo URL::getBase() ?>img/others/banner_top.jpg" height="62" width="438"> -->
</div>

<div class="container">
	<small>Você está: <?php echo $estadoAnuncio; if(!empty($categoriaAnuncio)) echo ' > Procurando por: <b>'. $categoriaAnuncio.'</b>'; ?>
</small>

<div class="container">
	<aside>
		<form id="form-pesquisa" action="" name="category" method="post" enctype="multipart/form-data">  
		    <h4>Assunto</h4>
		    <input type="text" id="pesquisa" class="input-text"  name="busca-categoria" size="27" placeholder="Ex: Advogado, Eletricista" maxlength="40" value="<?php echo $categoriaAnuncio; ?>"  onkeyup="autoCompleteCat()" />
		    <!-- <ul id="pesquisa_list_id"></ul> -->

		    <ul>
		    	<small>Exemplo:</small>
		    	<li><a href="#">- Perfumes importado</a></li>
		    	<li><a href="#">- Eletricista</a></li>
		    	<li><a href="#">- Perfumes Hinode</a></li>
		    	<li><a href="#">- Planos de Saúde</a></li>
			</ul>

		    <h4>Cidade / Bairro</h4>
		    <input type="text" id="pesquisaCity" class="input-text" name="busca-cidade" size="27" placeholder="Ex: Duque de Caxias" maxlength="40" value="<?php echo $cidadeAnuncio; ?>" onkeyup="autoCompleteCity()" />
			<ul id="pesquisa_list_id_city"></ul>
			
			 <ul>
		    	<li><a href="#">- Duque de Caxias</a></li>
		    	<li><a href="#">- Jardim Primavera</a></li>
		    	<li><a href="#">- Petrópolis</a></li>
		    	<li><a href="#">- Curitiba</a></li>
			</ul>

			<input type="submit" name="bt-search-category" class="btn btn-primary bt-category" value="Buscar" />
	    </form>		
	
	</aside>

	<!-- <div class="adsbar visible-desktop">
		<img src="img/others/banner.jpg" height="570" width="192">
	</div> -->

	<content class="adsmain">

		<!-- <ul class="unstyled ads-top-gold">
			<li class="adspagegold">
				<figure>
					<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" alt=" ############################################# ">
					<div class="ads-infogold">
						<h5 class="company-namegold">RR telefonia</h5>
						<figcaption><h4>Hidratantes perfumes maquiagem cabelo</h4></figcaption>
					</div>
					<div class="adspricegold">À negociar</div>
					<address>Jardim primavera, Duque de Caxias - RJ</address>	
				</figure>
			</li>
		</ul> -->

		<ul class="unstyled">
			<?php  

				if(empty($cidadeAnuncio) && empty($categoriaAnuncio)){
					sds_getPage();
				 }else{
					if(empty($categoriaAnuncio)){
						sds_getPageCidade();	 
					}elseif(empty($cidadeAnuncio)){
						sds_getPageCategoria($estadoAnuncio, $cidadeAnuncio, $categoriaAnuncio);	 
					}else{
						sds_getPageCategoria($estadoAnuncio, $cidadeAnuncio, $categoriaAnuncio);
					}
				}
			
			?>
		</ul>
	</content>
</div>
</div>
<?php 

}else{
	echo '<br><br><div class="container"><h3>OPSSS... NÃO ENCONTRAMOS NENHUM ESTADO CHAMADO <b>'.$url.'</b></h3><br><br>

	ESCOLHA UM DOS ESTADOS ABAIXO:</div>
	
	<div class="container-fluid stateshome">
		<div class="container"> 
			<h4>Escolha um estado: 
				<small><a href="'. URL::getBase() .'estado/Acre">AC</a></small>
				<small><a href="'. URL::getBase() .'estado/Alagoas">AL</a></small>
				<small><a href="'. URL::getBase() .'estado/Amazonas">AM</a></small>
				<small><a href="'. URL::getBase() .'estado/Amapa">AP</a></small>
				<small><a href="'. URL::getBase() .'estado/Bahia">BA</a></small>
				<small><a href="'. URL::getBase() .'estado/Ceara">CE</a></small>
				<small><a href="'. URL::getBase() .'estado/distrito-federal">DF</a></small>
				<small><a href="'. URL::getBase() .'estado/espirito-santo">ES</a></small>
				<small><a href="'. URL::getBase() .'estado/Goias">GO</a></small>
				<small><a href="'. URL::getBase() .'estado/Maranhao">MA</a></small>
				<small><a href="'. URL::getBase() .'estado/minas-gerais">MG</a></small>
				<small><a href="'. URL::getBase() .'estado/mato-grosso-do-sul">MS</a></small>
				<small><a href="'. URL::getBase() .'estado/mato-grosso">MT</a></small>
				<small><a href="'. URL::getBase() .'estado/Para">PA</a></small>
				<small><a href="'. URL::getBase() .'estado/Paraiba">PB</a></small>
				<small><a href="'. URL::getBase() .'estado/Pernambuco">PE</a></small>
				<small><a href="'. URL::getBase() .'estado/Piaui">PI</a></small>
				<small><a href="'. URL::getBase() .'estado/Parana">PR</a></small>
				<small><a href="'. URL::getBase() .'estado/rio-de-janeiro">RJ</a></small>
				<small><a href="'. URL::getBase() .'estado/rio-grande-do-norte">RN</a></small>
				<small><a href="'. URL::getBase() .'estado/Rondonia">RO</a></small>
				<small><a href="'. URL::getBase() .'estado/Roraima">RR</a></small>
				<small><a href="'. URL::getBase() .'estado/rio-grande-do-sul">RS</a></small>
				<small><a href="'. URL::getBase() .'estado/santa-catarina">SC</a></small>
				<small><a href="'. URL::getBase() .'estado/Sergipe">SE</a></small>
				<small><a href="'. URL::getBase() .'estado/sao-paulo">SP</a></small>
				<small><a href="'. URL::getBase() .'estado/Tocantins">TO</a></small>
				<small><a href="'. URL::getBase() .'estado/Brasil">BRASIL</a></small>
			</h4>
		</div>	
	</div>';
}

?>