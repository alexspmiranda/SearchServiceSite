<?php
	
	$url = Url::getURL(1);
	
	$idCliente = sds_buscaId($url);

	// RECEBE O IP DO USUARIO PARA INSERIR NAS VISITAS
	$ip = $_SERVER["REMOTE_ADDR"];
		
	$verificaVisita = sds_selectVerificaVisita($idCliente, $ip);
	
	$resultado_verificaStatus = sds_selectVerificaStatus($idCliente);
	
	foreach($resultado_verificaStatus as $res_verificaStatus){
		$status = $res_verificaStatus['status'];
		$categoriaAnuncio = $res_verificaStatus['categoriaAnuncio'];
		$estadoAnuncio = $res_verificaStatus['estadoAnuncio'];		
	}

if($status == 'ativo' || $status == 'patrocinado'){ 

	$url = Url::getURL(1);
	$url = strip_tags(trim($url));
	$idCliente = sds_buscaId($url);
	
	$resultado_getSingle = sds_selectGetSingle($idCliente);
	
	foreach($resultado_getSingle as $res_getSingle){
		$idCliente_FK		= $res_getSingle['idCliente_FK'];
		$nomeFantasia 		= $res_getSingle['nomeFantasiaAnuncio'];
		$tituloAnuncio 		= $res_getSingle['tituloAnuncio'];
		$siteAnuncio		= $res_getSingle['siteAnuncio'];
		$precoAnuncio 		= $res_getSingle['precoAnuncio'];
		$categoriaAnuncio   = $res_getSingle['categoriaAnuncio'];
		$descricaoAnuncio 	= $res_getSingle['descricaoAnuncio'];
		$enderecoAnuncio	= $res_getSingle['enderecoAnuncio'];
		$complementoAnuncio	= $res_getSingle['complementoAnuncio'];
		$cepAnuncio			= $res_getSingle['cepAnuncio'];
		$bairroAnuncio 		= $res_getSingle['bairroAnuncio'];
		$cidadeAnuncio 		= $res_getSingle['cidadeAnuncio'];
		$estadoAnunciop		= $res_getSingle['uf'];
		$telefoneAnuncio	= $res_getSingle['telefoneAnuncio'];
		$telefoneAnuncio2	= $res_getSingle['telefoneAnuncio2'];
		$telefoneAnuncio3	= $res_getSingle['telefoneAnuncio3'];
		$emailAnuncio 		= $res_getSingle['email'];
		$idAnuncio 			= $res_getSingle['idAnuncio'];
		$emailAnunciante 	= $res_getSingle['email'];
		$linkPessoal		= $res_getSingle['linkPessoalAnuncio'];

		if($precoAnuncio == ""){
			$precoAnuncio = 'À negociar';	
		}else{
			$precoAnuncio = 'R$ '.$precoAnuncio;
		}
		
		$imagemPerfil   = 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_profile_userImage.jpg';
		$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
	    $imagem_dois 	= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage2.jpg';
	    $imagem_tres 	= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage3.jpg';
	    $imagem_quatro 	= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage4.jpg';
	    $imagem_cinco 	= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage5.jpg';

	    $imagem_um_large		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/'. md5($emailAnunciante).'_image_1.jpg';
	    $imagem_dois_large 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/'. md5($emailAnunciante).'_image_2.jpg';
	    $imagem_tres_large 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/'. md5($emailAnunciante).'_image_3.jpg';
	    $imagem_quatro_large 	= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/'. md5($emailAnunciante).'_image_4.jpg';
	    $imagem_cinco_large 	= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/'. md5($emailAnunciante).'_image_5.jpg';

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
?>

<div class="container-fluid step">
	<div class="container"><a href="<?php echo URL::getBase() .'estado/'.sds_retornaLinkEstado($estadoAnunciop); ?>" title="Anúncio grátis - <?php echo $estadoAnunciop?>"> <?php echo $estadoAnunciop?></a> > <a href="<?php echo URL::getBase() .'estado/'.sds_retornaLinkEstado($estadoAnunciop).'/cidade/'.$cidadeAnuncio; ?>" title="Anúncio grátis - <?php echo $cidadeAnuncio; ?>"><?php echo $cidadeAnuncio; ?></a> > <a href="<?php echo URL::getBase() .'estado/'.sds_retornaLinkEstado($estadoAnunciop).'/cidade/'.$cidadeAnuncio.'/categoria/'.$categoriaAnuncio; ?>" title="Anúncio sobre <?php echo $categoriaAnuncio ?>"><?php echo $categoriaAnuncio;?></a></div>
</div>

<div class="container">
	<content class="mainsingle">
		<figure class="userlogo single first">
<?php
			if(verificar_url($idAnuncio, 'profile')){ ?> 
            	<a href="<?php echo $imagemPerfil; ?>" rel="lightbox[plants]" title="Perfil">
 					<img src="<?php echo $imagemPerfil; ?>" width="100" height="100"  title="Imagem do perfil" />
 				</a><?php 
			}else{?>
				<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="100" height="100"title="Imagem do perfil" />
<?php 		} ?>
				<div class="infotitle">
					<h2 class="namecompany"><?php echo $nomeFantasia; ?></h2>
					<figcaption><h1><?php echo $tituloAnuncio; ?></h1></figcaption>
				
					<div class="contact hidden-phone">
						<h4>Localização: <?php echo $bairroAnuncio.', '.$cidadeAnuncio.' - '.$estadoAnunciop; ?></h4>
						<h5>Telefone: <?php echo $telefoneAnuncio; if(!empty($telefoneAnuncio2)) echo ' / '. $telefoneAnuncio2; ?></h5>
						<h5>Site pessoal: <?php if(empty($siteAnuncio)) echo 'Não possui'; else echo '<a href="http://'.$siteAnuncio.'" target="_blank">'.$siteAnuncio.'</a>'; ?></h5>
					</div>
				</div>
				<div class="contact visible-phone">
					<h4><?php echo $bairroAnuncio.', '.$cidadeAnuncio.' - '.$estadoAnunciop; ?></h4>
					<h5>Telefone: <?php echo $telefoneAnuncio; if(!empty($telefoneAnuncio2)) echo ' / '. $telefoneAnuncio2; ?></h5>
					<h5>Site pessoal: <?php if(empty($siteAnuncio)) echo 'Não possui'; else echo '<a href="http://'.$siteAnuncio.'" target="_blank">'.$siteAnuncio.'</a>'; ?></h5>
				</div>
		</figure>

		<div class="price"><?php echo $precoAnuncio; ?></div>
		
		<div class="contentpicture">
			<figure class="picture_one">
<?php
				if(verificar_url($idAnuncio, '1')){ ?>
					<a href="<?php echo $imagem_um_large; ?>" rel="lightbox[plants]" title="<?php echo $tituloFoto1.'<br>'.$descricaoFoto1; ?>">
						<img src="<?php echo $imagem_um ?>" width="380" height="215" alt="img01"/>
					</a><?php
				}else{
					echo '<img src="'.URL::getBase().'img/others/sem_imagens.png" width="380" height="215"/>';
				}
?>	
			</figure>

			<ul class="hidden-phone">
				<?php if(verificar_url($idAnuncio, '2')){ ?>
					<li>
						<figure>
							<a href="<?php echo $imagem_dois_large; ?>" rel="lightbox[plants]" title="<?php echo $tituloFoto2.'<br>'.$descricaoFoto2; ?>">
								<img src="<?php echo $imagem_dois ?>" width="65" height="45" alt="img02"/>
							</a>
						</figure>
					</li>
				<?php }?>
				
				<?php if(verificar_url($idAnuncio, '3')){ ?>
					<li>
						<figure>
							<a href="<?php echo $imagem_tres_large; ?>" rel="lightbox[plants]" title="<?php echo $tituloFoto3.'<br>'.$descricaoFoto3; ?>">
								<img src="<?php echo $imagem_tres ?>" width="65" height="45" alt="img03"/>											
							</a>
						</figure>
					</li>
				<?php }?>
				
				<?php if(verificar_url($idAnuncio, '4')){ ?>
					<li>
						<figure>
							<a href="<?php echo $imagem_quatro_large; ?>" rel="lightbox[plants]" title="<?php echo $tituloFoto4.'<br>'.$descricaoFoto4; ?>">
								<img src="<?php echo $imagem_quatro ?>" width="65" height="45" alt="img04"/>										
							</a>
						</figure>
					</li>
				<?php }?>

				<?php if(verificar_url($idAnuncio, '5')){ ?>
					<li>
						<figure>
							<a href="<?php echo $imagem_cinco_large; ?>" rel="lightbox[plants]" title="<?php echo $tituloFoto5.'<br>'.$descricaoFoto5; ?>">
								<img src="<?php echo $imagem_cinco ?>" width="65" height="45" alt="img05"/>											
							</a>
						</figure>
					</li>
				<?php }?>
			</ul>

			<span class="more-images visible-phone">[ Ver mais imagens ]</span>
		
		</div>
		
		<div class="sendmessage">
			<h4>Entrar em contato</h4>
		    <form method="POST" enctype="multipart/form-data">
		        <input type="text" name="nome-msg" autofocus="autofocus" class="input-msg" required placeholder="Digite seu nome" />
		        <input type="text" name="email-msg"  placeholder="Digite seu e-mail" required />
		        <input type="text" name="telefone-msg" placeholder="Digite seu telefone" maxlength="15"/>
		        <textarea name="text-msg" class="sendmessagesubmit" maxlength="255">Olá, encontrei seu anúncio no site saldaodeservicos.com e me interessei. Por favor, entre em contato comigo.</textarea>
				<input type="submit" name="envia-msg" value="Enviar mensagem" class="btn btn-primary" />
		 	</form>
		</div>

		<div class="btmessage">
			<form method="POST" enctype="multipart/form-data">
		      	<input type="submit" value="Enviar uma mensagem" class="btn btn-primary" />
		 	</form>
		</div>
	</content>

	<aside class="singlesidebar">

		<ul class="unstyled"><?php
		$resultado_patrocinadosBasic = sds_selectPatrocinadosBasic($categoriaAnuncio, $idCliente_FK);

		$cont = 0;
		foreach($resultado_patrocinadosBasic as $res_patrocinadosBasic){
			$idClienteP			= $res_patrocinadosBasic['clienteId'];
			$idAnuncio 			= $res_patrocinadosBasic['idAnuncio'];
			$tituloAnuncio		= $res_patrocinadosBasic['tituloAnuncio'];
			$precoAnuncio		= $res_patrocinadosBasic['precoAnuncio'];
			$urlAnuncio 		= $res_patrocinadosBasic['urlAnuncio'];
			$emailAnunciante 	= $res_patrocinadosBasic['email'];

			if($precoAnuncio == ""){
				$precoAnuncio = 'À negociar';	
			}else{
				$precoAnuncio = 'R$ '.$precoAnuncio;
			}
			$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
			$idClienteP = $idClienteP*(10-(1)+2*3*5*7);
				
echo '	<li>'?>
			<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio; ?>"><?php
				if(verificar_url($idAnuncio, '1')){ ?> 
					<img src="<?php echo $imagem_um; ?>" width="140" height="79" /><?php 
				}else{ ?>
		        	<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="79" /><?php
		        }		                            
echo '		</a>
		
           	<h5><a href="'. URL::getBase() .'anuncio/'. $urlAnuncio .'" title="'. $tituloAnuncio .'" class="adstitletop">'. $tituloAnuncio .'</a></h5>
			<h5><a href="'. URL::getBase() .'anuncio/'. $urlAnuncio .'" title="'. $tituloAnuncio .'" class="pricesidebarsingle">'. $precoAnuncio .'</a></h5>
		</li>';		
		$cont++;
		}
		

		
		if($cont < 2){

			$restoResultado = $cont%2;
			$limiteCategorias = (-$restoResultado)+2;
				
			$resultado_patrocinadosBasicRestante = sds_selectPatrocinadosBasicRestante($idCliente_FK, $tituloAnuncio, $estadoAnuncio, $limiteCategorias);
			
			foreach($resultado_patrocinadosBasicRestante as $res_patrocinadosBasicRestante){
				$idClientePatrocinado		= $res_patrocinadosBasicRestante['clienteId'];
				$idAnuncio 					= $res_patrocinadosBasicRestante['idAnuncio'];
				$tituloAnuncio				= $res_patrocinadosBasicRestante['tituloAnuncio'];
				$precoAnuncio				= $res_patrocinadosBasicRestante['precoAnuncio'];
				$urlAnuncio 				= $res_patrocinadosBasicRestante['urlAnuncio'];
				$emailAnunciante 	        = $res_patrocinadosBasicRestante['email'];
			
				if($precoAnuncio == ""){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}

				
				//$idImagem = listaImagemAnuncio($idAnuncio);
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
				$idClientePatrocinado = $idClientePatrocinado*(10-(1)+2*3*5*7);
			

echo '	<li>'?>
			<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio; ?>"><?php
				if(verificar_url($idAnuncio, '1')){ ?> 
					<img src="<?php echo $imagem_um; ?>" width="140" height="79" /><?php 
				}else{ ?>
		        	<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="79" /><?php
		        }		                            
echo '		</a>
		
           	<h5><a href="'. URL::getBase() .'anuncio/'. $urlAnuncio .'" title="'. $tituloAnuncio .'" class="adstitletop">'. $tituloAnuncio .'</a></h5>
			<h5><a href="'. URL::getBase() .'anuncio/'. $urlAnuncio .'" title="'. $tituloAnuncio .'" class="pricesidebarsingle">'. $precoAnuncio .'</a></h5>
		</li>';
			}	
		} ?>    
	</ul>	
	<a href="#"><span class="bannerone"></span></a>
	</aside>

	<article class="description">
		<h4>Sobre o anúncio:</h4>

		<p><?php echo $descricaoAnuncio ?></p>
		<h4 class="fbshare">Gostou?</h4> <div class="fb-share-button" data-href="#" data-layout="button" style="margin:0;"></div>
		
		<ul class="unstyled moreinfo">
			<h4 class="moreinfotitle"><strong>Mais informações:</strong></h4>

			<li><strong>Categoria:</strong> <?php echo $categoriaAnuncio; ?></li>
			<li><strong>Link para este anúncio:</strong><br><a href="http://www.saldaodeservicos.com/<?php echo $linkPessoal ?>" rel="nofollow"><small>saldaodeservicos.com/<?php echo $linkPessoal ?></small></a></li>
		</ul>

		<!-- <ul class="unstyled payment">
			<h4 class="moreinfotitle"><strong>Formas de pagamento:</strong></h4>
			<li><img src="../img/icon/money.png" height="23" width="51" title="Dinheiro"></li>
		</ul> -->
	</article>
</div>

<div class="container-fluid ads-top">
	<div class="container"> <h4>Patrocinados <small><a href="#">*saiba mais</a></small></h4></div>	
</div>

<div class="container">
	<ul class="ads-header-top"><?php 
			
		$resultado_buscaAnunciosRelacionados = sds_selectPatrocinadosSingleFooter($categoriaAnuncio);	
		
		$cont = 0;
		foreach($resultado_buscaAnunciosRelacionados as $res_buscaAnunciosRelacionados){
			$idCliente					= $res_buscaAnunciosRelacionados['clienteId'];
			$idAnuncio 					= $res_buscaAnunciosRelacionados['idAnuncio'];
			$tituloAnuncioRelacionado	= $res_buscaAnunciosRelacionados['tituloAnuncio'];
			$precoAnuncioRelacionado	= $res_buscaAnunciosRelacionados['precoAnuncio'];
			$status						= $res_buscaAnunciosRelacionados['status'];
			$urlAnuncio 				= $res_buscaAnunciosRelacionados['urlAnuncio'];
			$emailAnunciante			= $res_buscaAnunciosRelacionados['email'];

			if($precoAnuncioRelacionado == ""){
				$precoAnuncioRelacionado = 'À negociar';	
			}else{
				$precoAnuncioRelacionado = 'R$ '.$precoAnuncioRelacionado;
			}

			$imagem_um = 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
				
			if($status == 'ativo' || $status == 'patrocinado'){?>
				<li>
					<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio; ?>"><?php
					if(verificar_url($idAnuncio, '1')){ ?> 
						<span class="image-home">
							<img src="<?php echo $imagem_um; ?>" width="140" height="79" />
						</span><?php
 					}else{?>
 						<span class="image-home">
							<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="59" />
						</span>
						<?php 
					}
echo '				</a>
					<h5><a href="'. URL::getBase() .'anuncio/'. $urlAnuncio .'" title="'. $tituloAnuncioRelacionado .'" class="adstitletop">'. $tituloAnuncioRelacionado .'</a></h5>
					<h5><a href="'. URL::getBase() .'anuncio/'. $urlAnuncio .'" title="'. $tituloAnuncioRelacionado .'" class="price">'. $precoAnuncio .'</a></h5>';?>
				</li><?php
			}

		$cont++;
		}?>

		</li>

		<?php
		if($cont < 4){
			$restoResultado = $cont%4;
			$limiteCategorias = (-$restoResultado)+4;								

			$resultado_buscaAnuncios = sds_selectPatrocinadosSingleFooterRelacionados($categoriaAnuncio, $limiteCategorias);
			
			foreach($resultado_buscaAnuncios as $res_buscaAnuncios){
				$idClienteRelacionado	= $res_buscaAnuncios['clienteId'];
				$idAnuncio 				= $res_buscaAnuncios['idAnuncio'];
				$tituloAnuncioOutros	= $res_buscaAnuncios['tituloAnuncio'];
				$precoAnuncio			= $res_buscaAnuncios['precoAnuncio'];
				$status					= $res_buscaAnuncios['status'];
				$urlAnuncio 			= $res_buscaAnuncios['urlAnuncio'];
				$emailAnunciante		= $res_buscaAnuncios['email'];

				if($precoAnuncio == ""){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}

				//$idImagem = listaImagemAnuncio($idAnuncio);
				$idClienteRelacionado = $idClienteRelacionado*(10-(1)+2*3*5*7);
				
				$imagem_um = 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
				
				if($status == 'ativo' || $status == 'patrocinado'){?>
					<li>
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio; ?>"><?php
						if(verificar_url($idAnuncio, '1')){ ?> 
							<span class="image-home">
								<img src="<?php echo $imagem_um; ?>" width="140" height="79" />
							</span>
								<?php
	 					}else{?>
	 						<span class="image-home">
								<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="59" />
							</span><?php 
						} 
echo '					</a>
						<h5><a href="'. URL::getBase() .'anuncio/'. $urlAnuncio .'" title="'. $tituloAnuncioOutros .'" class="adstitletop">'. $tituloAnuncioOutros .'</a></h5>
						<h5><a href="'. URL::getBase() .'anuncio/'. $urlAnuncio .'" title="'. $tituloAnuncioOutros .'" class="price">'. $precoAnuncio .'</a></h5>';?>
					</li><?php
				}
			}
		}
?>
	</ul>


	<?php 

		//ENVIA MENSAGEM PARA O USUÁRIO
	    if(isset($_POST['envia-msg'])){
		    $mensagemNome = strip_tags(trim($_POST['nome-msg']));
		    $mensagemEmail = strip_tags(trim($_POST['email-msg']));
		    $mensagemTelefone = strip_tags(trim($_POST['telefone-msg']));
		    $mensagemMensagem = strip_tags(trim($_POST['text-msg']));
			sds_insertMensagemUsuario($idCliente_FK, $emailAnuncio,$mensagemNome , $mensagemEmail , $mensagemTelefone , $mensagemMensagem);
		}  
	?>
	<div class="fb-comments hidden-phone" data-href="http://developers.facebook.com/docs/plugins/comments/" href="http://saldaodeservicos.com<?php echo $_SERVER['REQUEST_URI']; ?>" data-numposts="5" style="margin-top:20px;"></div>

</div>

<?php 
	}

} 

?>