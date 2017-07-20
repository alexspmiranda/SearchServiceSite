
<?php

function sds_getSingle(){
	
	$url = Url::getURL(1);
	$url = strip_tags(trim($url));
	$idCliente = sds_buscaId($url);
	
	$resultado_getSingle = sds_selectGetSingle($idCliente);
	
	foreach($resultado_getSingle as $res_getSingle){
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
			$estadoAnuncio 		= $res_getSingle['uf'];
			$telefoneAnuncio	= $res_getSingle['telefoneAnuncio'];
			$telefoneAnuncio2	= $res_getSingle['telefoneAnuncio2'];
			$telefoneAnuncio3	= $res_getSingle['telefoneAnuncio3'];
			$emailAnuncio 		= $res_getSingle['email'];
			$idAnuncio 			= $res_getSingle['idAnuncio'];
			$emailAnunciante 	= $res_getSingle['email'];
			
			if($precoAnuncio == ""){
				$precoAnuncio = 'À negociar';	
			}else{
				$precoAnuncio = 'R$ '.$precoAnuncio;
			}
			
			$imagemPerfil   = 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_profile_userImage.jpg';
			$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_main_userImage1.jpg';
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

			echo '		
				<div class="container steps-single">
					<a href="'. URL::getBase() .'estado/'.sds_retornaLinkEstado($estadoAnuncio).'" title="Estado do anúncio">'.$estadoAnuncio.'</a> >> <a href="'. URL::getBase() .'estado/'.sds_retornaLinkEstado($estadoAnuncio).'/cidade/'.$cidadeAnuncio.'" title="Cidade do anúncio">'.$cidadeAnuncio.'</a> >> <a href="'. URL::getBase() .'estado/'.sds_retornaLinkEstado($estadoAnuncio).'/cidade/'.$cidadeAnuncio.'/categoria/'.$categoriaAnuncio.'" title="Categoria do anúncio">'. substr($categoriaAnuncio, 0, 20) .'...'.'</a>
				</div>				

				<div class="notice-single">'; ?>
					<div class="img-profile hidden-phone">
					<?php
					if(verificar_url($idAnuncio, 'profile')){
					?> 
                    	<img src="<?php echo $imagemPerfil; ?>" width="100" height="100" name="foto-1" />
                        <?php 
					}else{?>
						<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="100" height="100" name="foto-1" />
					<?php }
					
					echo '</a>
					 </div>
					 '; ?>

<?php
echo '
                       	<div class="info-profile">
													
							<div class="title-single">
								<h5 class="title-single">'.$nomeFantasia.'</h5>
								<h4 class="title-single-desc" style="color:orange;">'.$tituloAnuncio.'</h4>';
								
								if(!empty($siteAnuncio)){
								echo '<h5>Site: <a href="'.$siteAnuncio.'" title="Site do cliente" target="_blank">'.$siteAnuncio.'</a></h5>';
								}				
							echo '
							</div>
							<div class="locale"><h5><span class="hidden-phone">Localização: </span>'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$estadoAnuncio.'</h5></div>
						</div>
				'; ?>
					<section class="profile-desc">	
						<div class="grid-gallery visible-phone">
							<section class="grid-wrap picture-container">
								<ul class="grid">
									<li class="picture-current">
										<figure>
											<?php if(verificar_url($idAnuncio, '1')){ ?>
											
											<img src="<?php echo $imagem_um ?>" width="380" height="215" alt="img01"/>
											<?php }else{
											
												echo '<img src="'.URL::getBase().'img/others/sem_imagens.png" width="380" height="215"/>';
											}?>	
										</figure>
									</li>

								</ul>
								<a href="#" class="more-images">[ Ver mais imagens ]</a>
							</section>

						</div>
						
						<div id="grid-gallery" class="grid-gallery hidden-phone">
							
							<section class="grid-wrap picture-container">
								<ul class="grid">
									<li class="picture-current">
										<figure>
											<?php if(verificar_url($idAnuncio, '1')){ ?>
											
											<img src="<?php echo $imagem_um ?>" width="380" height="215" alt="img01"/>
											<?php }else{
											
												echo '<img src="'.URL::getBase().'img/others/sem_imagens.png" width="380" height="215"/>';
											}?>	
										</figure>
									</li>

									<?php if(verificar_url($idAnuncio, '2')){ ?>
										<li class="thumbs">
											<figure>
												<img src="<?php echo $imagem_dois ?>" width="65" height="45" alt="img02"/>
											</figure>
										</li>
									<?php }?>
									
									<?php if(verificar_url($idAnuncio, '3')){ ?>
										<li class="thumbs">
											<figure>
												<img src="<?php echo $imagem_tres ?>" width="65" height="45" alt="img03"/>											
											</figure>
										</li>
									<?php }?>
									
									<?php if(verificar_url($idAnuncio, '4')){ ?>
										<li class="thumbs">
											<figure>
												<img src="<?php echo $imagem_quatro ?>" width="65" height="45" alt="img04"/>										
											</figure>
										</li>
									<?php }?>

									<?php if(verificar_url($idAnuncio, '5')){ ?>
										<li class="thumbs">
											<figure>
												<img src="<?php echo $imagem_cinco ?>" width="65" height="45" alt="img05"/>											
											</figure>
										</li>
									<?php }?>
								</ul>
							</section>

							<section class="slideshow">
								<ul>
									<?php if(verificar_url($idAnuncio, '1')){ ?>
									<li>
										<figure>
											<figcaption>
												<h3><?php echo $tituloFoto1 ?></h3>
												<p><?php echo $descricaoFoto1; ?></p>
											</figcaption>
											<img src="<?php echo $imagem_um_large ?>" width="380" height="215" alt="img01"/>
										</figure>
									</li>
									<?php }?>

									<?php if(verificar_url($idAnuncio, '2')){ ?>
									<li>
										<figure>
											<figcaption>
												<h3><?php echo $tituloFoto2 ?></h3>
												<p><?php echo $descricaoFoto2; ?></p>	
											</figcaption>
											<img src="<?php echo $imagem_dois_large ?>" width="65" height="45" alt="img02"/>										
										</figure>
									</li>
									<?php }?>

									<?php if(verificar_url($idAnuncio, '3')){ ?>
									<li>
										<figure>
											<figcaption>
												<h3><?php echo $tituloFoto3 ?></h3>
												<p><?php echo $descricaoFoto3; ?></p>												
											</figcaption>
											<img src="<?php echo $imagem_tres_large ?>" width="65" height="45" alt="img03"/>											
										</figure>
									</li>
									<?php }?>

									<?php if(verificar_url($idAnuncio, '4')){ ?>
									<li>
										<figure>
											<figcaption>
												<h3><?php echo $tituloFoto4 ?></h3>
												<p><?php echo $descricaoFoto4; ?></p>
											</figcaption>
											<img src="<?php echo $imagem_quatro_large ?>" width="65" height="45" alt="img04"/>											
										</figure>
									</li>
									<?php }?>

									<?php if(verificar_url($idAnuncio, '5')){ ?>
									<li>
										<figure>
											<figcaption>
												<h3><?php echo $tituloFoto5 ?></h3>
												<p><?php echo $descricaoFoto5; ?></p>
											</figcaption>
											<img src="<?php echo $imagem_cinco_large ?>" width="65" height="45" alt="img05"/>
										</figure>
									</li>
									<?php }?>
								</ul>
								<nav>
									<span class="icon nav-prev"><</span>
									<span class="icon nav-next">></span>
									<span class="icon nav-close">X</span>
								</nav>
							</section><!-- // slideshow -->
						</div><!-- // grid-gallery -->
													
						<?php echo '

							<div class="phone-single">
								<img src="http://saldaodeservicos.com/img/icon/phone.png" height="57" width="56" alt="Telefone para contato" class="hidden-phone" />
								<span class="numbers">
									<h5 class="phonenumber">'.$telefoneAnuncio.'</h5><br>
									<h5 class="phonenumber">'.$telefoneAnuncio2.'</h5><br>
									<h5 class="phonenumber">'.$telefoneAnuncio3.'</h5>
								</span>
							</div>
							
							<div class="notice-price">
								'.$precoAnuncio.'
							</div>

							<div class="description">
								<div class="title-info">Descrição:</div>
									<p class="descript-info">
										'.$descricaoAnuncio.'
									</p>';?>
									
									<a data-toggle="modal" href="#" data-target="#msg">
										<input type="button" name="botao-mensagem" value="Enviar uma mensagem rápida" class="btn btn-primary btn-msg" />
									</a>

									<div class="modal hide fade" id="msg">
										<div class="modal-header">
									   		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									   		<h3 id="myModalLabel">Enviar mensagem rápida</h3>
									 	</div>
									 
									 	<div class="modal-body">
									   		<div class="description-msg">

											    <form method="POST" enctype="multipart/form-data">
											        <input name="nome-msg" autofocus="autofocus" class="input-msg" required placeholder="Digite seu nome" />
											        <input name="email-msg" class="input-msg" placeholder="Digite seu e-mail" required />
											        <input name="telefone-msg" class="input-msg" placeholder="Digite seu telefone" maxlength="15" required/>
											        <textarea name="text-msg" class="input-msg" maxlength="255">Olá, encontrei seu anúncio no site saldaodeservicos.com e me interessei. Por favor, entre em contato comigo.</textarea>
											</div>

											<?PHP 
											    if(isset($_POST['envia-msg'])){
												    $mensagemNome = strip_tags(trim($_POST['nome-msg']));
												    $mensagemEmail = strip_tags(trim($_POST['email-msg']));
												    $mensagemTelefone = strip_tags(trim($_POST['telefone-msg']));
												    $mensagemMensagem = strip_tags(trim($_POST['text-msg']));
													sds_insertMensagemUsuario($idCliente, $mensagemNome , $mensagemEmail , $mensagemTelefone , $mensagemMensagem);
												}
											    
											?>
									 	</div>
									 
										<div class="modal-footer">
										   		<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
										 		<input type="submit" name="envia-msg" value="Enviar mensagem" class="btn btn-primary" />
										 	</form>
										</div>
									</div>
								</div>
							</section>
								   	                                    
						<div class="important hidden-phone">
							<div class="security-warning">
								<img src="<?php echo URL::getBase() ?>img/icon/cadeado.png" alt="Dicas de segurança" width="25" height="25" style="float:left; margin:10px;"/>
								<a href="#"><h4 style="float:left; margin-top:12px; color:#039;"><strong>Dicas de segurança</strong></h4></a>

								<ul class="unstyled">
									<li> - Desconfie de anúncios surreais</li>
									<li> - Não pague adiantado</li>
									<li> - Busque por referências</li>
								</ul>
							</div>

							<div class="social">
								<h4><strong>Compartilhe</strong></h4>
								<div class="fb-share-button" data-href="#" data-layout="button" style="margin:0;"></div>
							</div>

							<div class="denounce">
								<a data-toggle="modal" href="#" data-target="#denuncia">
									<h4><strong>Denunciar anúncio</strong></h4>
									<div id="denunciar-icon">
										<img src="<?php echo URL::getBase() ?>img/icon/denunciar-icon.png" border="0" alt="Denunciar" width="25" height="25" />
									</div>
								</a>								
							</div>
						</div>
						
						<div class="modal hide fade" id="denuncia">
									<div class="modal-header">
								   		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								   		<h3 id="myModalLabel">Denunciar anúncio</h3>
								 	</div>
								 
								 	<div class="modal-body">
									  	<h4>Qual o motivo da sua denúncia?</h4>
									  
											<script type="text/javascript">
										
											function insereTexto(){
												document.getElementById('insereForm').innerHTML = '<input type="text" name="denuncia-outro" maxlength="40" required />';
											} 
											
											function limpaTexto(){
												document.getElementById('insereForm').innerHTML = '';
											}
											
										</script>

									  	<form  method="post" enctype="multipart/form-data">
									  
									    	<label><input name="denuncia" type="radio" class="radio-denuncia" value="Anúncio falso"  onclick="limpaTexto()" required /> Anúncio falso </label>
									    	<label><input name="denuncia" type="radio" class="radio-denuncia" value="Usuário diz ser quem não é"  onclick="limpaTexto()" required /> Usuário diz ser quem não é </label>
									    	<label><input name="denuncia" type="radio" class="radio-denuncia" value="Conteúdo ilegal perante a lei" onClick="limpaTexto()" required /> Conteúdo ilegal perante a lei </label>
									    	<!--label><input name="denuncia" type="radio" class="radio-denuncia" value="outro"  onclick="insereTexto()" required /> Outro </label-->
									<?php
									
									if(isset($_POST['envia-denuncia'])){
										$denuncia = strip_tags(trim($_POST['denuncia']));
										
										if( $denuncia == "outro" ){
											$denuncia = strip_tags(trim($_POST['denuncia-outro']));
										}
										
										sds_insertDenuncia($idCliente, $denuncia);
									}

									?>
								   	</div>
								 
									<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
											<input type="submit" name="envia-denuncia" value="Enviar denúncia" class="btn btn-primary"  />
									 	</form>
									</div>
								</div>

						<div class="associated-notice hidden-phone">
							<br><h4> Anúncios relacionados </h4><br>
								<ul class="inline unstyled">
									<?php 
										
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
											
											//$idImagem = listaImagemAnuncio($idAnuncio);
											
											$imagem_um = 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
											
											echo '<li>';
											if($status == 'ativo' || $status == 'patrocinado'){?>
												<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio; ?>">
												<?php
 								                   if(verificar_url($idAnuncio, '1')){
												?> 
												<img src="<?php echo $imagem_um; ?>" width="140" height="79" />
												<?php 
											}else{?>
												<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="59" />
											<?php }
										
											 echo '</a>
												<h5><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">'.$tituloAnuncioRelacionado.'</a></h5>
												<h5><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">'.$precoAnuncioRelacionado.'</a></h5>
											';
											$cont++;
										}
									}
									?>

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
													<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio; ?>">
<?php 												if(verificar_url($idAnuncio, '1')){ ?> 
														<img src="<?php echo $imagem_um; ?>" width="140" height="79" />
<?php 												}else{ 
?>
														<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="59" />
<?php 
													} echo '</a>
														<h5><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">'.$tituloAnuncioOutros.'</a></h5>
														<h5><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">'.$precoAnuncio.'</a></h5>
';?>
												</li>
<?php
											}
										}
									}
?>		
								</ul>
						</div>

						
					</div>
<?php
		}
}

?>