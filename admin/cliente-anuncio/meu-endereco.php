<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
<?php include_once("header.php"); ?>

<?php
	
	// LISTA OS DADOS DO ANÚNCIO
	$resultado_consultaCadastro = sds_selectAnuncioPainel($idCliente);
	
	foreach($resultado_consultaCadastro as $res_consultaCadastro){
		$anuncioUrl			= $res_consultaCadastro['linkPessoalAnuncio'];
		$idAnuncio 			= $res_consultaCadastro['idAnuncio'];
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
	}
	

	// INSERE OS DADOS DO ANUNCIO SE FOR O PRIMEIRO ACESSO DO CLIENTE
	if(isset($_POST['cadastra-anuncio'])){
		$anuncioUrl  = strip_tags(trim($_POST['url']));
		$anuncioNome = strip_tags(trim($_POST['nome']));
		$anuncioTitulo = strip_tags(trim($_POST['titulo']));
		$anuncioSite = strip_tags(trim($_POST['website']));
		$anuncioCategoria = strip_tags(trim($_POST['categoria']));
		$anuncioPreco = strip_tags(trim($_POST['preco']));
		$anuncioCep = strip_tags(trim($_POST['cep']));
		$anuncioEndereco = strip_tags(trim($_POST['rua']));
		$anuncioComplemento = strip_tags(trim($_POST['complemento']));
		$anuncioNum = strip_tags(trim($_POST['num']));
		$anuncioBairro = strip_tags(trim($_POST['bairro']));
		$anuncioBairro = retira_acentos($anuncioBairro);
		$anuncioCidade = strip_tags(trim($_POST['cidade']));	
		$anuncioEstado = strip_tags(trim($_POST['estado']));
		$anuncioTelefone = strip_tags(trim($_POST['telefone']));
		$anuncioTelefone2 = strip_tags(trim($_POST['telefone2']));
		$anuncioTelefone3 = strip_tags(trim($_POST['telefone3']));
		$anuncioDescricao = strip_tags(trim($_POST['descricao']));
		$anuncioDataCadastro = date('Y-m-d H:i:s');
		$notificadoAnuncio = '0';
		
		if(empty($idAnuncio)){
					
			$anuncioTituloUrl = retira_acentos( $anuncioTitulo );
			$anuncioTituloUrl = str_replace('-', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace('.', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace(' ', '-', $anuncioTituloUrl);
			$anuncioTituloUrl = strtolower($anuncioTituloUrl.'-'.$idCliente);

			sds_insereDadosAnuncio($idCliente, $anuncioUrl, $anuncioNome,$anuncioTitulo,$anuncioSite,$anuncioCategoria,$anuncioPreco, $anuncioEndereco,$anuncioComplemento,$anuncioNum,
								   $anuncioCep, $anuncioBairro,$anuncioCidade, $anuncioEstado,$anuncioTelefone,$anuncioTelefone2,$anuncioTelefone3,$anuncioDescricao,
								   $notificadoAnuncio, $anuncioTituloUrl);	
		}else{


			$anuncioTituloUrl = retira_acentos( $anuncioTitulo );
			$anuncioTituloUrl = str_replace('-', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace('.', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace(' ', '-', $anuncioTituloUrl);
			$anuncioTituloUrl = strtolower($anuncioTituloUrl.'-'.$idCliente);

			sds_atualizaDadosAnuncio($idCliente, $anuncioUrl, $anuncioNome,$anuncioTitulo,$anuncioSite,$anuncioCategoria,$anuncioPreco, $anuncioEndereco,$anuncioComplemento,$anuncioNum,
								   $anuncioCep, $anuncioBairro,$anuncioCidade, $anuncioEstado,$anuncioTelefone,$anuncioTelefone2,$anuncioTelefone3,$anuncioDescricao,
								   $notificadoAnuncio, $anuncioTituloUrl);		
		}
	}
	
	$resultado_buscaPorEstado = sds_selectEstados();
	$estadoNome = sds_selectEstadoUF($anuncioEstado);

	if(isset($_POST['envia-blob'])){
		
		salvaImagemAnuncioUm($idAnuncio);
		salvaImagemAnuncioDois($idAnuncio);
		salvaImagemAnuncioTres($idAnuncio);
		salvaImagemAnuncioQuatro($idAnuncio);
		salvaImagemAnuncioCinco($idAnuncio);
		
	}
	
	$imagens = explode("::", listaImagem($idAnuncio));

	if($nivelAcesso == 'cliente'){
?>
		<div id="anuncio-patrocinado">
	
		</div><!--FECHA ANUNCIO PATROCINADO -->

<?php	
	}

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
      <form name="cadastra-anuncio" id="#cadastra-anuncio" method="post" enctype="multipart/form-data">
         <span class="info-align">
	        <h5>CEP:</h5>
    	    <input id="cep" name="cep" type="text" maxlength="9" value="<?php echo $anuncioCep; ?>" placeholder="Informe o CEP" onKeyPress="mascara(this, '#####-###')" size="12" />
        </span>
        
        <span class="info-align">
        	<h5>Nome da Rua / Logradouro:</h5>
        	<input id="rua" name="rua" class="input-xxlarge" type="text" value="<?php echo $anuncioEndereco; ?>" placeholder="Avenida Barão de Japurá" size="40" />
        </span>
        
        <span class="info-align">
        	<h5>Complemento:</h5>
        	<input id="complemento" class="input-xxlarge" name="complemento" value="<?php echo $anuncioComplemento; ?>" type="text" placeholder="Alameda A" size="40" />
        </span>
        
        <span class="info-align">
	        <h5>Nº:</h5>
	        <input id="num" name="num"  value="<?php echo $anuncioNum; ?>" type="text" placeholder="1024" size="5"/>
		</span>

        <span class="info-align">
        <h5>Bairro:</h5>
        <input id="bairro" required name="bairro" value="<?php echo $anuncioBairro; ?>" type="text" placeholder="Informe o Bairro"/>
        </span>
        
        <span class="info-align">
        <h5>Cidade:</h5>
        <input id="cidade" required name="cidade" value="<?php echo $anuncioCidade; ?>" type="text" placeholder="Informe a Cidade"/>
        </span>
        
        <span class="info-align">
        <h5>UF:</h5>
        <select name="estado" required >
        <option name="<?php echo $anuncioEstado; ?>" value="<?php echo $anuncioEstado; ?>" style="background:#ccc;" selected> <?php echo $estadoNome; ?> </option>
        <?php 
    	foreach($resultado_buscaPorEstado as $res_buscaPorEstado){
            $idEstado = $res_buscaPorEstado['id'];
            $uf = $res_buscaPorEstado['uf'];
            
            ?>
            <option name="<?php echo $idEstado; ?>" value="<?php echo $idEstado; ?>"><?php echo $uf; ?></option>
            <?php
        }
	
        ?>
        </select>
        
        </span>

        <!-- FECHA MEU ANUNCIO -->
        <input type="hidden" name="url" value="<?php echo $anuncioUrl; ?>" />
        <input type="hidden" name="nome" value="<?php echo $anuncioNome; ?>" placeholder="Ex: Alex designer, Casa da arte, Artdesigner" size="45" required maxlength="35" />
        <input type="hidden" name="titulo"  value="<?php echo $anuncioTitulo; ?>" placeholder="Ex: Site e cartão de visita com ótimo preço" size="55" required maxlength="60" />
        <input type="hidden" name="website" value="<?php echo $anuncioSite; ?>"  placeholder="http://www.seusite.com.br (opcional)" size="40" maxlength="60" />
        <input type="hidden" name="categoria" value="<?php echo $anuncioCategoria; ?>"  placeholder="Ex: Designer gráfico, Diarista" size="35" maxlength="60" />
        <input type="hidden" name="preco" value="<?php echo $anuncioPreco; ?>" size="20" placeholder="R$ 0,00" alt="" title="Deixe em branco para negociar" />
        <input type="hidden" name="telefone" value="<?php echo $anuncioTelefone; ?>" size="20" required id="telefone" maxlength="10" />
        <input type="hidden" name="telefone2" value="<?php echo $anuncioTelefone2; ?>" size="20" id="telefone2" maxlength="11" />
        <input type="hidden" name="telefone3" value="<?php echo $anuncioTelefone3; ?>" size="20" id="telefone3" maxlength="11" />
        <input type="hidden" name="descricao"  maxlength="540" required value="<?php echo $anuncioDescricao; ?>" />
        
        
        <input type="submit" name="cadastra-anuncio" value="Publicar endereço" class="btn btn-primary" />
      
      </form>
         
	</div>
</article><!-- FECHA MEU ANUNCIO MIDIA -->

<?php include_once("footer.php"); ?>