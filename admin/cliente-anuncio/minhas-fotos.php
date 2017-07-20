<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
<?php include_once("header.php"); ?>

<?php
	// LISTA OS DADOS DO ANÚNCIO
	$resultado_consultaCadastro = sds_selectAnuncioPainel($idCliente);
	
	foreach($resultado_consultaCadastro as $res_consultaCadastro){
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
		$estadoNome 		= $res_consultaCadastro['uf'];
	}
	

	// INSERE OS DADOS DO ANUNCIO SE FOR O PRIMEIRO ACESSO DO CLIENTE
	if(isset($_POST['cadastra-anuncio'])){
		
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
					
			sds_insereDadosAnuncio($idCliente, $anuncioNome,$anuncioTitulo,$anuncioSite,$anuncioCategoria,$anuncioPreco, $anuncioEndereco,$anuncioComplemento,$anuncioNum,
								   $anuncioCep, $anuncioBairro,$anuncioCidade, $anuncioEstado,$anuncioTelefone,$anuncioTelefone2,$anuncioTelefone3,$anuncioDescricao,
								   $notificadoAnuncio);	
		}else{
			sds_atualizaDadosAnuncio($idCliente, $anuncioNome,$anuncioTitulo,$anuncioSite,$anuncioCategoria,$anuncioPreco, $anuncioEndereco,$anuncioComplemento,$anuncioNum,
								   $anuncioCep, $anuncioBairro,$anuncioCidade, $anuncioEstado,$anuncioTelefone,$anuncioTelefone2,$anuncioTelefone3,$anuncioDescricao,
								   $notificadoAnuncio);		
		}
	}
	
	$resultado_buscaPorEstado = sds_selectEstados();

	if(isset($_POST['envia-blob'])){
       		
		salvaImagemAnuncioUm($idAnuncio, $email, $idCliente);
		salvaImagemAnuncioDois($idAnuncio, $email, $idCliente);
		salvaImagemAnuncioTres($idAnuncio, $email, $idCliente);
		salvaImagemAnuncioQuatro($idAnuncio, $email, $idCliente);
		salvaImagemAnuncioCinco($idAnuncio, $email, $idCliente);
		
	    
        $tituloFoto_um          = strip_tags(trim($_POST['tituloFoto1']));
        $tituloFoto_dois        = strip_tags(trim($_POST['tituloFoto2']));
        $tituloFoto_tres        = strip_tags(trim($_POST['tituloFoto3']));
        $tituloFoto_quatro      = strip_tags(trim($_POST['tituloFoto4']));
        $tituloFoto_cinco       = strip_tags(trim($_POST['tituloFoto5']));

        $descricaoFoto_um       = strip_tags(trim($_POST['descricaoFoto1']));
        $descricaoFoto_dois     = strip_tags(trim($_POST['descricaoFoto2']));
        $descricaoFoto_tres     = strip_tags(trim($_POST['descricaoFoto3']));
        $descricaoFoto_quatro   = strip_tags(trim($_POST['descricaoFoto4']));
        $descricaoFoto_cinco    = strip_tags(trim($_POST['descricaoFoto5']));

        if(!empty($tituloFoto_um) || !empty($descricaoFoto_um)){
            
            insere_descricaoFoto($idAnuncio, $tituloFoto_um, $descricaoFoto_um, '1');

        }

        if(!empty($tituloFoto_dois) || !empty($descricaoFoto_dois)){  

            insere_descricaoFoto($idAnuncio, $tituloFoto_dois, $descricaoFoto_dois, '2');

        }

        if(!empty($tituloFoto_tres) || !empty($descricaoFoto_tres)){

            insere_descricaoFoto($idAnuncio, $tituloFoto_tres, $descricaoFoto_tres, '3');

        }

        if(!empty($tituloFoto_quatro) || !empty($descricaoFoto_quatro)){

            insere_descricaoFoto($idAnuncio, $tituloFoto_quatro, $descricaoFoto_quatro, '4');

        }

        if(!empty($tituloFoto_cinco) || !empty($descricaoFoto_cinco)){

            insere_descricaoFoto($idAnuncio, $tituloFoto_cinco, $descricaoFoto_cinco, '5');

        }
    }
	
	$imagem_um = listaImagem($email);

    $resultado_buscaDesc = select_descricaoFotos($idAnuncio);

    foreach($resultado_buscaDesc as $res_buscaDesc){
        $idFoto     = $res_buscaDesc['nomeFoto'];
        $tituloFoto = $res_buscaDesc["tituloFoto"];
        $descFoto   = $res_buscaDesc['descFoto'];
        
        if($idFoto == '1'){
            $tituloFoto1 = $tituloFoto;
            $descricaoFoto1 = $descFoto;
        }elseif($idFoto == '2'){
            $tituloFoto2 = $tituloFoto;
            $descricaoFoto2 = $descFoto;
        }elseif($idFoto == '3'){
            $tituloFoto3 = $tituloFoto;
            $descricaoFoto3 = $descFoto;
        }elseif($idFoto == '4'){
            $tituloFoto4 = $tituloFoto;
            $descricaoFoto4 = $descFoto;
        }elseif($idFoto == '5'){
            $tituloFoto5 = $tituloFoto;
            $descricaoFoto5 = $descFoto;
        }

    }

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
  <div class="meu-anuncio-midia">
   	
    <form id="formulario" name="form" method="post" enctype="multipart/form-data">
	<ul class="unstyled">
    <?php 
    // LISTA DE IMAGENS


    $imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($email).'/thumbs/'.md5($email).'_thumb_userImage1.jpg';
    $imagem_dois 	= 'http://saldaodeservicos.com/img/uploads/'. md5($email).'/thumbs/'.md5($email).'_thumb_userImage2.jpg';
    $imagem_tres 	= 'http://saldaodeservicos.com/img/uploads/'. md5($email).'/thumbs/'.md5($email).'_thumb_userImage3.jpg';
    $imagem_quatro 	= 'http://saldaodeservicos.com/img/uploads/'. md5($email).'/thumbs/'.md5($email).'_thumb_userImage4.jpg';
    $imagem_cinco 	= 'http://saldaodeservicos.com/img/uploads/'. md5($email).'/thumbs/'.md5($email).'_thumb_userImage5.jpg';

    
    /*Exclui foto*/

    if(isset($_POST['delete-pic-1'])){
        $idPhoto = '1';
        sds_deletePic($idPhoto, $idAnuncio);
    }elseif(isset($_POST['delete-pic-2'])){
        $idPhoto = '2';
        sds_deletePic($idPhoto, $idAnuncio);
    }elseif(isset($_POST['delete-pic-3'])){
        $idPhoto = '3';
        sds_deletePic($idPhoto, $idAnuncio);
    }elseif(isset($_POST['delete-pic-4'])){
        $idPhoto = '4';
        sds_deletePic($idPhoto, $idAnuncio);
    }elseif(isset($_POST['delete-pic-5'])){
        $idPhoto = '5';
        sds_deletePic($idPhoto, $idAnuncio);
    }

    // if(isset($_POST['delete-pic-1'])){
    //     $arquivo =  '/www/vtest/img/uploads/'. md5($email).'/thumbs/'.md5($email).'_thumb_userImage1.jpg';
    //     echo $arquivo;
        
    //     if(@unlink($arquivo)){
    //         echo "Arquivo excluído com sucesso.";
    //     }
    //     else{
    //         echo "Não foi possível excluir o arquivo.";
    //     }
    // }

    ?>
        <input type="submit" name="envia-blob" class="btn btn-success" value="Publicar fotos" style="float:right; margin-bottom:20px; margin-right:105px;" />
    	<li>
    
            <!-- FOTO UM  -->
            <span style="float:left;">
            
            <?php if(verificar_urlAdmin($idAnuncio, '1')){ ?>

            <?php } ?>
               	<?php
                    if(verificar_urlAdmin($idAnuncio, '1')){ ?>
                		<img src="<?php echo $imagem_um; ?>" width="185" height="104"  />
                 	<?php }else{?>
                		<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="185" height="104"  />    
                <?php } ?>
                <span class="insert-photo">
                    <input id="imagem" name="userImage1" class="realuploaded" type="file" onchange="this.form.fakeupload1.value = this.value;"/>
                </span>
            </span>
                
            <span class="subtitle">
                <input type="text" name="tituloFoto1" class="input-xlarge" placeholder="Título do anúncio" value="<?php echo $tituloFoto1; ?>"  maxlength="40" >
                <br><textarea  name="descricaoFoto1" class="input-xxlarge" placeholder="Descrição do anúncio" maxlength="125"><?php echo $descricaoFoto1; ?></textarea>
            </span>

                <input type="submit" name="delete-pic-1" value="Excluir esta foto" class="btn btn-danger">
       </li>      
       
       <li>      
            <!-- FOTO DOIS  -->    
            <span style="float:left;">
                <?php
                    if(verificar_urlAdmin($idAnuncio, '2')){ ?>
                		<img src="<?php echo $imagem_dois; ?>" width="185" height="104"  />
                 	<?php }else{?>
                		<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="185" height="104"  />    
                <?php } ?> 
                <span class="insert-photo">
                    <input id="realuploaded" name="userImage2" class="realuploaded" type="file" onchange="this.form.fakeupload2.value = this.value;" style="position:relative; clear:both;"/>
                </span>
            </span>

            <span class="subtitle">
                <input type="text" name="tituloFoto2" class="input-large" placeholder="Título do anúncio" value="<?php echo $tituloFoto2; ?>"  maxlength="40" >
                <br><textarea  name="descricaoFoto2" class="input-xxlarge" placeholder="Descrição do anúncio" maxlength="125"><?php echo $descricaoFoto2; ?></textarea>
            </span>

                <input type="submit" name="delete-pic-2" value="Excluir esta foto" class="btn btn-danger">

        </li>
        
      	

        <li>      
            <!-- FOTO TRÊS  -->    
            <span style="float:left;">
                <?php
                    if(verificar_urlAdmin($idAnuncio, '3')){ ?>
                        <img src="<?php echo $imagem_tres; ?>" width="185" height="104"  />
                    <?php }else{?>
                        <img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="185" height="104"  />    
                <?php } ?> 
                <span class="insert-photo">
                    <input id="realuploaded" name="userImage3" class="realuploaded" type="file" onchange="this.form.fakeupload2.value = this.value;" style="position:relative; clear:both;"/>
                </span>
            </span>

            <span class="subtitle">
                <input type="text" name="tituloFoto3" class="input-large" placeholder="Título do anúncio" value="<?php echo $tituloFoto3; ?>"  maxlength="40" >
                <br><textarea  name="descricaoFoto3" class="input-xxlarge" placeholder="Descrição do anúncio" maxlength="125"><?php echo $descricaoFoto3; ?></textarea>
            </span>

                <input type="submit" name="delete-pic-3" value="Excluir esta foto" class="btn btn-danger">

        </li>

        <li>      
            <!-- FOTO QUATRO  -->    
            <span style="float:left;">
                <?php
                    if(verificar_urlAdmin($idAnuncio, '4')){ ?>
                        <img src="<?php echo $imagem_quatro; ?>" width="185" height="104"  />
                    <?php }else{?>
                        <img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="185" height="104"  />    
                <?php } ?> 
                <span class="insert-photo">
                    <input id="realuploaded" name="userImage4" class="realuploaded" type="file" onchange="this.form.fakeupload2.value = this.value;" style="position:relative; clear:both;"/>
                </span>
            </span>

            <span class="subtitle">
                <input type="text" name="tituloFoto4" class="input-large" placeholder="Título do anúncio" value="<?php echo $tituloFoto4; ?>"  maxlength="40" >
                <br><textarea  name="descricaoFoto4" class="input-xxlarge" placeholder="Descrição do anúncio" maxlength="125"><?php echo $descricaoFoto4; ?></textarea>
            </span>

                <input type="submit" name="delete-pic-4" value="Excluir esta foto" class="btn btn-danger">

        </li>

        <li>      
            <!-- FOTO CINCO  -->    
            <span style="float:left;">
                <?php
                    if(verificar_urlAdmin($idAnuncio, '5')){ ?>
                        <img src="<?php echo $imagem_cinco; ?>" width="185" height="104"  />
                    <?php }else{?>
                        <img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="185" height="104"  />    
                <?php } ?> 
                <span class="insert-photo">
                    <input id="realuploaded" name="userImage5" class="realuploaded" type="file" onchange="this.form.fakeupload2.value = this.value;" style="position:relative; clear:both;"/>
                </span>
            </span>

            <span class="subtitle">
                <input type="text" name="tituloFoto5" class="input-large" placeholder="Título do anúncio" value="<?php echo $tituloFoto5; ?>"  maxlength="40" >
                <br><textarea  name="descricaoFoto5" class="input-xxlarge" placeholder="Descrição do anúncio" maxlength="125"><?php echo $descricaoFoto5; ?></textarea>
            </span>

                <input type="submit" name="delete-pic-5" value="Excluir esta foto" class="btn btn-danger">

        </li>
       
       	<label>	<input type="hidden" name="userImage" /></label>
            
        <label>	<input type="hidden" name="userImage1" /></label>
        <label>	<input type="hidden" name="userImage2" /></label>
        <label>	<input type="hidden" name="userImage3" /></label>
        <label>	<input type="hidden" name="userImage4" /></label>
        <label>	<input type="hidden" name="userImage5" /></label>

    </ul>	    
   
        
	    <input type="submit" name="envia-blob" class="btn btn-success" value="Publicar fotos" style="float:left;" />
	</form>
	
    </div>
	</div>
</article><!-- FECHA MEU ANUNCIO MIDIA -->

 

<?php include_once("footer.php"); ?>