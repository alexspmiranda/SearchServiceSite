<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
<?php include_once("header.php"); ?>

<?php
	// LISTA OS DADOS DO ANÚNCIO
	$resultado_consultaCadastro = sds_selectAnuncioPainel($idCliente);
	
	foreach($resultado_consultaCadastro as $res_consultaCadastro){
		$idAnuncio 			= $res_consultaCadastro['idAnuncio'];
		$anuncioUrl			= $res_consultaCadastro['linkPessoalAnuncio'];
		$anuncioNome 		= $res_consultaCadastro['nomeFantasiaAnuncio'];
		$anuncioTitulo	 	= $res_consultaCadastro['tituloAnuncio'];
		$anuncioSite 		= $res_consultaCadastro['siteAnuncio'];
		$anuncioCategoria 	= $res_consultaCadastro['categoriaAnuncio'];
		$anuncioPreco 		= $res_consultaCadastro['precoAnuncio'];
		$anuncioEndereco 	= $res_consultaCadastro['enderecoAnuncio'];
		$anuncioComplemento = $res_consultaCadastro['complementoAnuncio'];
		$anuncioNum			= $res_consultaCadastro['numAnuncio'];
		$anuncioCep 		= $res_consultaCadastro['cepAnuncio'];
		$anuncioBairro 		= $res_consultaCadastro['bairroAnuncio'];
		$anuncioCidade 		= $res_consultaCadastro['cidadeAnuncio'];
		$anuncioEstado 		= $res_consultaCadastro['estadoAnuncio'];
		$anuncioTelefone 	= $res_consultaCadastro['telefoneAnuncio'];
		$anuncioTelefone2 	= $res_consultaCadastro['telefoneAnuncio2'];
		$anuncioTelefone3 	= $res_consultaCadastro['telefoneAnuncio3'];
		$anuncioDescricao 	= $res_consultaCadastro['descricaoAnuncio'];			
		$estadoNome 		= $res_consultaCadastro['uf'];
	}	

	// INSERE OS DADOS DO ANUNCIO SE FOR O PRIMEIRO ACESSO DO CLIENTE
	if(isset($_POST['cadastra-anuncio'])){
		
		$anuncioUrl  			= strip_tags(trim($_POST['url']));
		$anuncioNome 			= strip_tags(trim($_POST['nome']));
		$anuncioTitulo 			= strip_tags(trim($_POST['titulo']));
		$anuncioSite 			= strip_tags(trim($_POST['website']));
		$anuncioCategoria 		= strip_tags(trim($_POST['categoria']));
		$anuncioPreco 			= strip_tags(trim($_POST['preco']));
		$anuncioCep 			= strip_tags(trim($_POST['cep']));
		$anuncioEndereco 		= strip_tags(trim($_POST['rua']));
		$anuncioComplemento 	= strip_tags(trim($_POST['complemento']));
		$anuncioNum 			= strip_tags(trim($_POST['num']));
		$anuncioBairro 			= strip_tags(trim($_POST['bairro']));
		$anuncioBairro 			= retira_acentos($anuncioBairro);
		$anuncioCidade 			= strip_tags(trim($_POST['cidade']));	
		$anuncioEstado 			= strip_tags(trim($_POST['estado']));
		$anuncioDDD 	 		= strip_tags(trim($_POST['ddd']));
		$anuncioTelefone 		= strip_tags(trim($_POST['telefone']));
		$anuncioTelefone 		= '('.$anuncioDDD.') '.$anuncioTelefone;
		$anuncioDDD2	 		= strip_tags(trim($_POST['ddd2']));
		$anuncioTelefone2 		= strip_tags(trim($_POST['telefone2']));
		$anuncioTelefone2 		= '('.$anuncioDDD2.') '.$anuncioTelefone2;
		$anuncioDescricao 		= strip_tags(trim($_POST['descricao']));
		$anuncioDataCadastro 	= date('Y-m-d H:i:s');
		$notificadoAnuncio	 	= '0';
		
		if(empty($idAnuncio)){
			$resultado_verificaUrl =  sds_verificaUrl($anuncioUrl);
						
			foreach($resultado_verificaUrl as $res_verificaUrl){
				$idAnuncioUrl 	= $res_verificaUrl['idAnuncio'];
				if($idAnuncioUrl != $idAnuncio){
					$anuncioUrl = $anuncioUrl.''.rand(1, 9);
				}
			}
			
			$anuncioTituloUrl = retira_acentos( $anuncioTitulo );
			$anuncioTituloUrl = str_replace('-', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace('.', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace(',', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace(' ', '-', $anuncioTituloUrl);
			$anuncioTituloUrl = strtolower($anuncioTituloUrl.'-'.$idCliente);

			sds_insereDadosAnuncio($idCliente, $anuncioUrl, $anuncioNome,$anuncioTitulo,$anuncioSite,$anuncioCategoria,$anuncioPreco, $anuncioEndereco,$anuncioComplemento,$anuncioNum,
								   $anuncioCep, $anuncioBairro,$anuncioCidade, $anuncioEstado,$anuncioTelefone,$anuncioTelefone2,$anuncioTelefone3,$anuncioDescricao,
								   $notificadoAnuncio, $anuncioTituloUrl);	
		
			echo '<meta http-equiv="refresh" name="Refresh" content="0; URL=http://saldaodeservicos.com/admin/painel/anuncio/endereco">	';

		}else{

			$resultado_verificaUrl =  sds_verificaUrl($anuncioUrl);

			foreach($resultado_verificaUrl as $res_verificaUrl){
				$idAnuncioUrl 	= $res_verificaUrl['idAnuncio'];
				if($idAnuncioUrl != $idAnuncio){
					$anuncioUrl = $anuncioUrl.''.rand(1, 9);
				}
			}
			

			$anuncioTituloUrl = retira_acentos( $anuncioTitulo );
			$anuncioTituloUrl = str_replace('-', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace('.', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace(',', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace(' ', '-', $anuncioTituloUrl);
			$anuncioTituloUrl = strtolower($anuncioTituloUrl.'-'.$idCliente);

			sds_atualizaDadosAnuncio($idCliente, $anuncioUrl, $anuncioNome,$anuncioTitulo,$anuncioSite,$anuncioCategoria,$anuncioPreco, $anuncioEndereco,$anuncioComplemento,$anuncioNum,
								 	 $anuncioCep, $anuncioBairro,$anuncioCidade, $anuncioEstado,$anuncioTelefone,$anuncioTelefone2,$anuncioTelefone3,$anuncioDescricao,
								  	 $notificadoAnuncio, $anuncioTituloUrl);	

			if(empty($anuncioEstado)){	
				echo '<meta http-equiv="refresh" name="Refresh" content="0; URL=http://saldaodeservicos.com/admin/painel/anuncio/endereco">	';	
			}
		}
	}
	
	$resultado_buscaPorEstado = sds_selectEstados();

	if($nivelAcesso == 'cliente'){
?>
		<div id="anuncio-patrocinado">
	
		</div><!--FECHA ANUNCIO PATROCINADO -->

<?php	
	}


$anuncioTelefone = explode(' ', $anuncioTelefone);
$ddd = str_replace('(', '', $anuncioTelefone[0]);
$ddd = str_replace(')', '', $ddd);

$anuncioTelefone2 = explode(' ', $anuncioTelefone2);
$ddd2 = str_replace('(', '', $anuncioTelefone2[0]);
$ddd2 = str_replace(')', '', $ddd2);

?>

<article class="container">
	<br>
	<h4>Meu anúncio </h4>

	<!-- <h5>Confira nossa sessão de <a href="#">dicas</a> para saber como criar um bom anúncio do seu serviço. <a href="#">Clique aqui</a> </h5> -->
  	
	<nav class="notice-submenu">
        <ul class="inline unstyled">
            <li class="btn btn-primary"><a href="<?php echo URL::getBase() ?>painel/anuncio"> Dados do anúncio</a></li>
            <li class="btn btn-primary"><a href="<?php echo URL::getBase() ?>painel/anuncio/endereco"> Endereço do anúncio</a></li>
            <li class="btn btn-primary"><a href="<?php echo URL::getBase() ?>painel/anuncio/fotos">Fotos do anúncio </a></li>
        </ul>
    </nav>
  
  <div class="my-notice">
		<form name="cadastra-anuncio" method="post" enctype="multipart/form-data">
	        
	        <span class="info-align">
	        	<h5>Endereço do seu anúncio</h5><br>
				<label style="float:left;">http://www.saldaodeservicos.com/<input type="text" name="url" placeholder="nomedaempresa (tudo junto)" required value="<?php echo $anuncioUrl; ?>" maxlength="25" class="input-large" pattern="[a-z0-9]{1,25}" oninvalid="setCustomValidity('Opps... Algo deu errado! Certifique-se de que não há espaços ou caractéres especiais.')" onchange="try{setCustomValidity('')}catch(e){}"> </label>
				<small style="float:left; margin:-45px 0 10px 10px; background:#F4F4F4; padding:10px; text-align:justify; width:340px;"> Este campo é uma URL. A URL será o endereço do seu site, por exemplo: João cadastra este campo como "joaodapadaria", então ele pode passar o endereço do seu anúncio como <i>www.saldaodeservicos.com/<strong>joaodapadaria</strong></i> para seus clientes.</small>
			</span>
			
	        <span class="info-align">
		        <h5>Nome da Empresa/Autônomo: </h5>
	    	    <input type="text" name="nome" class="input-xxlarge" value="<?php echo $anuncioNome; ?>" placeholder="Ex: Alex designer, Casa da arte, Artdesigner" required maxlength="35" />
	        </span>
	        
	        <span class="info-align">
		        <h5>Título do anúncio: </h5>
		        <input type="text" name="titulo" class="input-xxlarge"  value="<?php echo $anuncioTitulo; ?>" placeholder="Ex: Site e cartão de visita com ótimo preço" required maxlength="53" pattern="[a-z A-ZñÑãàèìòùáéíõóúÃÁÉÍÕÓÚ0-9.-,]{1,60}" oninvalid="setCustomValidity('Opps... Somente letras e números')" onchange="try{setCustomValidity('')}catch(e){}"/>
	        </span>
	        
	        <span class="info-align">
	        	<h5>Endereço do seu site:</h5>
	        	<div class="input-prepend">
				  <span class="add-on">http://</span>
				  <input class="input-large" id="prependedInput" type="text" name="website" value="<?php echo $anuncioSite; ?>"  placeholder="www.seusite.com.br (opcional)" size="40" maxlength="60" />
				</div>
	        	
	        </span>

	        <span class="info-align">        
	        	<h5>Categoria do anúcio: </h5>
	        	<input type="text" name="categoria" value="<?php echo $anuncioCategoria; ?>"  placeholder="Ex: Designer gráfico, Diarista" size="35" maxlength="60" />
			</span>

			<span class="info-align"  style="clear:none;">        
	        	<label style="float:left;">
	        		<h5>Valor do serviço: </h5>
	        		<input type="text" name="preco" value="<?php echo $anuncioPreco; ?>" size="20" placeholder="R$ 0,00" alt="" title="Deixe em branco para negociar" pattern="[0-9]{0,9}" />
	        	</label>
	        	<small style="float:left; margin:15px 0 10px 10px; background:#F4F4F4; padding:10px;">Se você deixar em branco o anuncio aparecerá como: "À negociar". </small>
	        </span>
	        
	        <span class="info-align">
	        	<label style="float:left;">
	        	<h5>DDD: </h5>
	        	<input type="text" name="ddd" class="input-mini" value="<?php echo $ddd; ?>" size="20" required id="telefone" maxlength="2" placeholder="Ex: 21" />
	       		</label>
	       		<label style="float:left; margin-left:5px;">
	       		<h5>Telefone 1: </h5>
	        	<input type="text" name="telefone" class="input-large" value="<?php echo $anuncioTelefone[1]; ?>" size="20" required id="telefone" maxlength="9" placeholder="123456789" pattern="[0-9]{0,9}" oninvalid="setCustomValidity('Opss... Só números e sem espaços')" onchange="try{setCustomValidity('')}catch(e){}" />
	  			</label>
	  		</span>

	        <span class="info-align" style="clear:none;">
				<label style="float:left;">
				<h5>DDD: </h5>
	        	<input type="text" name="ddd2" class="input-mini" value="<?php echo $ddd2; ?>" size="20" id="telefone2" maxlength="2" placeholder="Ex: 21" />
	        	</label>
	        	<label style="float:left; margin-left:5px;">
	        	<h5>Telefone 2: </h5>
	        	<input type="text" name="telefone2" class="input-large" value="<?php echo $anuncioTelefone2[1]; ?>" size="20" id="telefone2" maxlength="9" placeholder="123456789" pattern="[0-9]{0,9}" oninvalid="setCustomValidity('Opss... Só números e sem espaços')" onchange="try{setCustomValidity('')}catch(e){}" />
				</label>
	        </span>

	        <span class="info-align" style="width:100%; clear:both;">
		        <h5>Descrição:</h5>
	        	<textarea name="descricao" class="input-block-level textarea-my-notice"  maxlength="420" required style="width:60%;"><?php echo $anuncioDescricao; ?></textarea>
	    	</span>
	    
	        <input name="cep" type="hidden" value="<?php echo $anuncioCep; ?>"  />
	        <input name="rua" type="hidden" value="<?php echo $anuncioEndereco; ?>" />
	        <input name="complemento" type="hidden" value="<?php echo $anuncioComplemento; ?>" />
	        <input name="num" type="hidden" value="<?php echo $anuncioNum; ?>" type="text" />
	        <input name="bairro" type="hidden" value="<?php echo $anuncioBairro; ?>" />
	        <input name="cidade" type="hidden" value="<?php echo $anuncioCidade; ?>" />
	        <input name="estado" type="hidden" value="<?php echo $anuncioEstado; ?>" style="background:#ccc;" selected />


			<span class="info-align" style="width:60%; clear:both;">
	        	<input type="submit" name="cadastra-anuncio" value="Publicar anúncio" class="btn btn-primary" />
	      	</span>


	    </form>
	</div>
</article><!-- FECHA MEU ANUNCIO MIDIA -->

<?php include_once("footer.php"); ?>