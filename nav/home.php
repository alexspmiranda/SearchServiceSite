<div class="container-fluid main">
	<div class="container">
		<span class="caller">Seu negócio na internet</span>
		<span class="callersave">Cadastre-se, é grátis</span>
		<span class="btnsave"><a href="admin/index.php"><img src="img/icon/icon_save.png" height="27" width="27"> Cadastrar</a></span>
	</div>

	<div class="container titlefluidsearch">Procurar anuncios
		<div class="fluidsearch">
			<form name="form" class="input-group" id="form-pesquisa">
				<label>EM
					<input type="text" class="input-large city" id="pesquisaestado" placeholder="Ex: Duque de Caxias, RJ" required onkeyup="autoCompleteCityHome()">
					<ul id="pesquisa_list_id_city" class="unstyled"></ul>
				</label>

				<label>SOBRE
					<input type="text" class="input-xlarge category" id="pesquisa" required placeholder="Ex: Eletricista, Designer" onkeyup="autoCompleteCatHome()">
					<ul id="pesquisa_list_id" class="unstyled"></ul>
				</label>

				<input type="button" class="btn btn-primary btnhome" id="enviar" value="Enviar" onclick="search()">
			</form>

			<!-- <form id="form-pesquisa" action="" name="category" method="post" enctype="multipart/form-data">  
		    <input type="text" id="pesquisaCity" onkeyup="autoCompleteCity()" />
			<ul id="pesquisa_list_id_city"></ul> -->
	    </form>		
		</div>
	</div>
</div>


<div class="container">
	<ul class="ads-header-top" style="margin-top:20px;">
<?php 

	$resultado_consultaAnuncio = sds_homePostsPatrocinados();

	foreach($resultado_consultaAnuncio as $res_consultaAnuncio){
		$idCliente 			= $res_consultaAnuncio['idCliente_FK'];
		$idAnuncio 			= $res_consultaAnuncio['idAnuncio'];
		$emailAnunciante 	= $res_consultaAnuncio['email'];
		$tituloAnuncio  	= $res_consultaAnuncio['tituloAnuncio'];
		$precoAnuncio 		= $res_consultaAnuncio['precoAnuncio'];
		$urlAnuncio 		= $res_consultaAnuncio['urlAnuncio'];

		if($precoAnuncio == ""){
			$precoAnuncio = 'À negociar';	
		}else{
			$precoAnuncio = 'R$ '.$precoAnuncio;
			}
		
		$imagem_um = 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
	    
		$idCliente = $idCliente*(10-(1)+2*3*5*7);
		
echo '		
		<li>
			<a href="anuncio/'.$urlAnuncio.'" title="'.$tituloAnuncio.'">';?>
<?php 		if(verificar_url($idAnuncio, '1')){ ?> 
				<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" /><?php 
			}else{?>
				<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
<?php   	
			}

echo 		'
			</a>';
echo 		'
			<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$tituloAnuncio.'" class="adstitletop">'.$tituloAnuncio.'</h4></a>';
echo 		'
			<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$tituloAnuncio.'" class="price">'.$precoAnuncio.'</h4></a>';
echo 		'
		</li>';
	}
?> 		
	</ul>
</div>

<div class="container-fluid stateshome">
	<div class="container"> 
		<h4>Escolha um estado: 
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