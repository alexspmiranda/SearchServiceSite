<?php 
		if(empty($cidadeAnuncio) && empty($categoriaAnuncio)){
	
			$resultado_buscarPatrocinados = sds_patrocinadosPage($estadoUF);
			
			$cont = 0;
			foreach($resultado_buscarPatrocinados as $res_buscarPatrocinados){
				$idCliente 			= $res_buscarPatrocinados['clienteId'];
				$idAnuncio 			= $res_buscarPatrocinados['idAnuncio'];
				$tituloAnuncio 		= $res_buscarPatrocinados['tituloAnuncio'];
				$precoAnuncio 		= $res_buscarPatrocinados['precoAnuncio'];
				$urlAnuncio			= $res_buscarPatrocinados['urlAnuncio'];
				$emailAnunciante 	= $res_buscarPatrocinados['email'];
				
				if($precoAnuncio == ""){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}
				
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
				$idCliente = $idCliente*(10-(1)+2*3*5*7);
?>
				<li class="span3">
					<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>">
                	<?php 
					if(verificar_url($idAnuncio, '1')){
					?>
						<span class="image-ads">
                    		<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
                        </span>
                        <?php 
					}else{?>
						<span class="image-ads">
							<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado" />
						</span>
					<?php } ?>
                </a>
				<span class="ads-desc-sidebar text-left"><a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>"><?php echo $tituloAnuncio ?></a></span>
				<span class="ads-desc-sidebar text-left"><a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>"><?php echo $precoAnuncio ?></a></span></li>
	<?php
				$cont++;
			}
			
			if($cont < 4){
				$restoResultado = $cont%4;
				$limiteCategorias = (-$restoResultado)+4;
				
				$resultado_buscaPatrocinadosBrasil = sds_buscaPatrocinadosBrasil($estadoUF, $limiteCategorias);
				
				foreach($resultado_buscaPatrocinadosBrasil as $res_buscaPatrocinadosBrasil){
					$idCliente = $res_buscaPatrocinadosBrasil['clienteId'];
					$idAnuncio = $res_buscaPatrocinadosBrasil['idAnuncio'];
					$tituloAnuncio = $res_buscaPatrocinadosBrasil['tituloAnuncio'];
					$precoAnuncio = $res_buscaPatrocinadosBrasil['precoAnuncio'];
					$urlAnuncio		= $res_buscaPatrocinadosBrasil['urlAnuncio'];
					$emailAnunciante = $res_buscaPatrocinadosBrasil['email'];
					
					if($precoAnuncio == ""){
						$precoAnuncio = 'À negociar';	
					}else{
						$precoAnuncio = 'R$ '.$precoAnuncio;
					}
					
					$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
					$idCliente = $idCliente*(10-(1)+2*3*5*7);
			
				?>
					<li class="span3">
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>">
							<?php 
							if(verificar_url($idAnuncio, '1')){
							?>
								<span class="image-ads">
									<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
								</span>
								<?php 
							}else{?>
								<span class="image-ads">
									<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado" />
								</span>
							<?php } ?>
						</a>
						
						<span class="ads-desc-sidebar text-left"><a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>"><?php echo $tituloAnuncio ?></a></span>
						<span class="ads-desc-sidebar text-left"><a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>"><?php echo $precoAnuncio ?></a></span>

						</li>
					<?php
					
				}
			}
			//PATROCINADOS POR CIDADE
		}elseif(!empty($cidadeAnuncio) && empty($categoriaAnuncio)){
			$resultado_buscaPatrocinadosPorCidade  = sds_buscaPatrocinadosPorCidade($cidadeAnuncio, $estadoUF);
			
			$cont=0;
			foreach($resultado_buscaPatrocinadosPorCidade as $res_buscarPatrocinados){
				$idCliente = $res_buscarPatrocinados['clienteId'];
				$idAnuncio = $res_buscarPatrocinados['idAnuncio'];
				$tituloAnuncio = $res_buscarPatrocinados['tituloAnuncio'];
				$precoAnuncio = $res_buscarPatrocinados['precoAnuncio'];
				$urlAnuncio		= $res_buscarPatrocinados['urlAnuncio'];
				$emailAnunciante = $res_buscarPatrocinados['email'];
				
				if($precoAnuncio == ""){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}
				
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
				$idCliente = $idCliente*(10-(1)+2*3*5*7);
		
    ?>
				<li class="span3">
					<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>">
	                	<?php 
						if(verificar_url($idAnuncio, '1')){
						?>
							<span class="image-ads">
		                    	<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
		                    </span>	
	                        <?php 
						}else{?>
							<span class="image-ads">
								<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado"/>
							</span>
						<?php } ?>
	                </a>
					<span class="ads-desc-sidebar text-left">
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>"><?php echo $tituloAnuncio ?></a>
					</span>
					
					<span class="ads-desc-sidebar text-left">
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>"><?php echo $precoAnuncio ?></a>
					</span>
				</li>
	<?php
				$cont++;
			}
			
			/// FAZ UMA NOVA CONSULTA CASO AINDA FALTE ANÚNCIOS PARA EXIBIR
			if($cont < 4){
				$restoResultado = $cont%4;
				$limiteCategorias = (-$restoResultado)+4;
				
				$resultado_buscaPatrocinadosRestantesCidade = sds_buscaPatrocinadosRestantesCidade($cidadeAnuncio, $estadoUF, $limiteCategorias);
					
				foreach($resultado_buscaPatrocinadosRestantesCidade as $res_buscarPatrocinados){
					$idCliente = $res_buscarPatrocinados['clienteId'];
						$idAnuncio = $res_buscarPatrocinados['idAnuncio'];
					$tituloAnuncio = $res_buscarPatrocinados['tituloAnuncio'];
					$precoAnuncio = $res_buscarPatrocinados['precoAnuncio'];
					$urlAnuncio		= $res_buscarPatrocinados['urlAnuncio'];
					$emailAnunciante = $res_buscarPatrocinados['email'];
					
					if($precoAnuncio == ""){
						$precoAnuncio = 'À negociar';	
					}else{
						$precoAnuncio = 'R$ '.$precoAnuncio;
					}
					
					$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
					$idCliente = $idCliente*(10-(1)+2*3*5*7);
		?>
                    <li class="span3">
                    	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>">
	                    	<?php 
							if(verificar_url($idAnuncio, '1')){
							?>
								<span class="image-ads">
									<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
								</span>
								<?php 
							}else{?>
								<span class="image-ads">
									<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado" />
								</span>
							<?php } ?>
	                    </a>
	                    <span class="ads-desc-sidebar text-left">
	                    	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>"><?php echo $tituloAnuncio ?></a>
	                    </span>

	                   	<span class="ads-desc-sidebar text-left">
	                   		<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>"><?php echo $precoAnuncio ?></a>
						</span>

                   	</li>
		<?php		$cont++;					
				}
					
			}
			
			//CASO NÃO EXISTA PATROCINADOS NO ESTADO E NEM NA CIDADE BUSCA POR OUTROS ESTADOS.
		
			if($cont < 4){
				$restoResultado = $cont%4;
				$limiteCategorias = (-$restoResultado)+4;
				
				$resultado_buscaPatrocinadosBrasil = sds_buscaPatrocinadosBrasil($estadoUF, $limiteCategorias);
				
				foreach($resultado_buscaPatrocinadosBrasil as $res_buscaPatrocinadosBrasil){
					$idCliente = $res_buscaPatrocinadosBrasil['clienteId'];
					$idAnuncio = $res_buscaPatrocinadosBrasil['idAnuncio'];
					$tituloAnuncio = $res_buscaPatrocinadosBrasil['tituloAnuncio'];
					$precoAnuncio = $res_buscaPatrocinadosBrasil['precoAnuncio'];
					$urlAnuncio		= $res_buscaPatrocinadosBrasil['urlAnuncio'];
					$emailAnunciante = $res_buscaPatrocinadosBrasil['email'];

					if($precoAnuncio == ""){
						$precoAnuncio = 'À negociar';	
					}else{
						$precoAnuncio = 'R$ '.$precoAnuncio;
					}
					
					$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
					$idCliente = $idCliente*(10-(1)+2*3*5*7);
			
				?>
					<li class="span3">
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>">
							<?php 
							if(verificar_url($idAnuncio, '1')){
							?>
								<span class="image-ads">
									<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
								</span>
								<?php 
							}else{?>
								<span class="image-ads">
									<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado" />
								</span>		
							<?php } ?>
						</a>
						<span class="ads-desc-sidebar text-left">
							<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>"><?php echo $tituloAnuncio ?></a>
						</span>
						<span class="ads-desc-sidebar text-left">
							<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>" title="<?php echo $tituloAnuncio; ?>"><?php echo $precoAnuncio ?></a>
						</span>

					</li>
					<?php
					
				}
			}
			
			// PATROCINADOS POR CATEGORIA
		}elseif(empty($cidadeAnuncio) && !empty($categoriaAnuncio)){
			$resultado_buscaPatrocinadosPorCategoria = sds_buscaPatrocinadosPorCategoria($categoriaAnuncio, $estadoUF);
			
			$cont = 0;
			foreach($resultado_buscaPatrocinadosPorCategoria as $res_buscarPatrocinados){
				$idCliente = $res_buscarPatrocinados['clienteId'];
				$idAnuncio = $res_buscarPatrocinados['idAnuncio'];
				$tituloAnuncio = $res_buscarPatrocinados['tituloAnuncio'];
				$precoAnuncio = $res_buscarPatrocinados['precoAnuncio'];
				$urlAnuncio		= $res_buscarPatrocinados['urlAnuncio'];
					$emailAnunciante = $res_buscarPatrocinados['email'];
				
				if($precoAnuncio == ""){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}
				
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
				$idCliente = $idCliente*(10-(1)+2*3*5*7);
		
    ?>
				<li class="span3">
					<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>">
                		<?php 
						if(verificar_url($idAnuncio, '1')){
						?>
							<span class="image-ads">
								<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
							</span>

							<?php 
						}else{?>
							<span class="image-ads">
								<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado" />
							</span>
						<?php } ?>
                	</a>
					<span class="ads-desc-sidebar text-left">
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $tituloAnuncio ?></a>
					</span>
					
					<span class="ads-desc-sidebar text-left">
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $precoAnuncio ?></a>
					</span>
				</li>
	<?php
			$cont++;
			}

			/// FAZ UMA NOVA CONSULTA CASO AINDA FALTE ANÚNCIOS PARA EXIBIR
			if($cont < 4){
				$restoResultado = $cont%4;
				$limiteCategorias = (-$restoResultado)+4;
				
				$resultado_buscaPatrocinadosRestantesCategoria = sds_buscaPatrocinadosRestanteCategoria($categoriaAnuncio, $estadoUF, $limiteCategorias);
					
				foreach($resultado_buscaPatrocinadosRestantesCategoria as $res_buscarPatrocinados){
					$idCliente = $res_buscarPatrocinados['clienteId'];
					$idAnuncio = $res_buscarPatrocinados['idAnuncio'];
					$tituloAnuncio = $res_buscarPatrocinados['tituloAnuncio'];
					$precoAnuncio = $res_buscarPatrocinados['precoAnuncio'];
					$urlAnuncio		= $res_buscarPatrocinados['urlAnuncio'];
					$emailAnunciante = $res_buscarPatrocinados['email'];
					
					if($precoAnuncio == ""){
						$precoAnuncio = 'À negociar';	
					}else{
						$precoAnuncio = 'R$ '.$precoAnuncio;
					}
					
					$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
					$idCliente = $idCliente*(10-(1)+2*3*5*7);
		?>
                    <li class="span3">
                    	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>">
	                    	<?php 
							if(verificar_url($idAnuncio, '1')){
							?>
								<span class="image-ads">
		                    	<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
		                    </span>	
	                        <?php 
						}else{?>
							<span class="image-ads">
								<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado"/>
							</span>
							<?php } ?>
                    	</a>
	                    <span class="ads-desc-sidebar text-left">
	                    	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $tituloAnuncio ?></a>
	                    </span>
	                    <span class="ads-desc-sidebar text-left">
	                    	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $precoAnuncio ?></a>
						</span>
                    </li>
		<?php			
				$cont++;				
				}		
			}
			
			if($cont < 4){
				$restoResultado = $cont%4;
				$limiteCategorias = (-$restoResultado)+4;
				
				$resultado_buscaPatrocinadosBrasil = sds_buscaPatrocinadosBrasil($estadoUF, $limiteCategorias);
				
				foreach($resultado_buscaPatrocinadosBrasil as $res_buscaPatrocinadosBrasil){
					$idCliente = $res_buscaPatrocinadosBrasil['clienteId'];
					$idAnuncio = $res_buscaPatrocinadosBrasil['idAnuncio'];
					$tituloAnuncio = $res_buscaPatrocinadosBrasil['tituloAnuncio'];
					$precoAnuncio = $res_buscaPatrocinadosBrasil['precoAnuncio'];
					$urlAnuncio		= $res_buscaPatrocinadosBrasil['urlAnuncio'];
					$emailAnunciante = $res_buscaPatrocinadosBrasil['email'];
					
					if($precoAnuncio == ""){
						$precoAnuncio = 'À negociar';	
					}else{
						$precoAnuncio = 'R$ '.$precoAnuncio;
					}
					
					$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
					$idCliente = $idCliente*(10-(1)+2*3*5*7);
			
				?>
					<li class="span3">
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>">
							<?php 
							if(verificar_url($idAnuncio, '1')){
							?>
								<span class="image-ads">
		                    	<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
		                    </span>	
	                        <?php 
						}else{?>
							<span class="image-ads">
								<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado"/>
							</span>
							<?php } ?>
						</a>
						<span class="ads-desc-sidebar text-left">
							<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $tituloAnuncio ?></a>
						</span>

						<span class="ads-desc-sidebar text-left">
							<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $precoAnuncio ?></a>
						</span>
					</li>
					<?php
					
				}
			}
			
		}elseif(!empty($cidadeAnuncio) && !empty($categoriaAnuncio)){
			$resultado_buscaPatrocinadosPorCidade = sds_buscaPatrocinadosPorCategoriaECidade($categoriaAnuncio, $cidadeAnuncio, $estadoUF);
			
			$cont = 0;
			foreach($resultado_buscaPatrocinadosPorCidade as $res_buscarPatrocinados){
				$idCliente = $res_buscarPatrocinados['clienteId'];
				$idAnuncio = $res_buscarPatrocinados['idAnuncio'];
				$tituloAnuncio = $res_buscarPatrocinados['tituloAnuncio'];
				$precoAnuncio = $res_buscarPatrocinados['precoAnuncio'];
				$urlAnuncio		= $res_buscarPatrocinados['urlAnuncio'];
				$emailAnunciante = $res_buscarPatrocinados['email'];
				
				if($precoAnuncio == ""){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}
				
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
				$idCliente = $idCliente*(10-(1)+2*3*5*7);
		
    ?>
				<li class="span3">
					<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>">
                		<?php 
						if(verificar_url($idAnuncio, '1')){
						?>
							<span class="image-ads">
								<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
							</span>
							<?php 
						}else{?>
							<span class="image-ads">
								<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado" />
							</span>
						<?php } ?>
               		</a>
					<span class="ads-desc-sidebar text-left">
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $tituloAnuncio ?></a>
					</span>
					<span class="ads-desc-sidebar text-left">
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $precoAnuncio ?></a>
					</span>

				</li>
	<?php
			$cont++;	
			}
			
			/// FAZ UMA NOVA CONSULTA CASO AINDA FALTE ANÚNCIOS PARA EXIBIR
			if($cont < 4){
				$restoResultado = $cont%4;
				$limiteCategorias = (-$restoResultado)+4;
				
				$resultado_buscaPatrocinadosRestantesCategoria = sds_buscaPatrocinadosRestanteCategoriaECidade($categoriaAnuncio, $cidadeAnuncio, $estadoUF, $limiteCategorias);
					
				foreach($resultado_buscaPatrocinadosRestantesCategoria as $res_buscarPatrocinados){
					$idCliente = $res_buscarPatrocinados['clienteId'];
					$idAnuncio = $res_buscarPatrocinados['idAnuncio'];
					$tituloAnuncio = $res_buscarPatrocinados['tituloAnuncio'];
					$precoAnuncio = $res_buscarPatrocinados['precoAnuncio'];
					$urlAnuncio		= $res_buscarPatrocinados['urlAnuncio'];
					$emailAnunciante = $res_buscarPatrocinados['email'];
					
					if($precoAnuncio == ""){
						$precoAnuncio = 'À negociar';	
					}else{
						$precoAnuncio = 'R$ '.$precoAnuncio;
					}
					
					$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
					$idCliente = $idCliente*(10-(1)+2*3*5*7);
		?>
                    <li class="span3">
                    	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>">
	                    	<?php 
							if(verificar_url($idAnuncio, '1')){
							?>
								<span class="image-ads">
		                    	<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
		                    </span>	
	                        <?php 
						}else{?>
							<span class="image-ads">
								<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado"/>
							</span>
							<?php } ?>
                    	</a>
                    <span class="ads-desc-sidebar text-left">
                     	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $tituloAnuncio ?></a>
                    <span class="ads-desc-sidebar text-left">
                    	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $precoAnuncio ?></a>
					</span>
                </li>
		<?php	
				$cont++;						
				}	
			}
			
			if($cont<4){
				$restoResultado = $cont%(4+$cont);
				$limiteCategorias = (-$restoResultado)+4;
					
				$resultado_buscaPatrocinadosRestantesCategoria = sds_buscaPatrocinadosRestanteCategoriaECidadeEEstado($categoriaAnuncio, $estadoUF, $limiteCategorias);
					
				foreach($resultado_buscaPatrocinadosRestantesCategoria as $res_buscarPatrocinados){
					$idCliente = $res_buscarPatrocinados['clienteId'];
					$idAnuncio = $res_buscarPatrocinados['idAnuncio'];
					$tituloAnuncio = $res_buscarPatrocinados['tituloAnuncio'];
					$precoAnuncio = $res_buscarPatrocinados['precoAnuncio'];
					$urlAnuncio		= $res_buscarPatrocinados['urlAnuncio'];
					$emailAnunciante = $res_buscarPatrocinados['email'];
					
					if($precoAnuncio == ""){
						$precoAnuncio = 'À negociar';	
					}else{
						$precoAnuncio = 'R$ '.$precoAnuncio;
					}
					
					$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
					$idCliente = $idCliente*(10-(1)+2*3*5*7);
		?>
                    <li class="span3">
                    	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>">
	                    	<?php 
							if(verificar_url($idAnuncio, '1')){
							?>
								<span class="image-ads">
		                    	<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
		                    </span>	
	                        <?php 
						}else{?>
							<span class="image-ads">
								<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado"/>
							</span>
							<?php } ?>
                    	</a>
	                    <span class="ads-desc-sidebar text-left">
	                    	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $tituloAnuncio ?></a>
	                    </span>
	                    <span class="ads-desc-sidebar text-left">
	                    	<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $precoAnuncio ?></a>
						</span>
                    </li>
		<?php							
				$cont++;
				}
			}
			
			if($cont < 4){
				$restoResultado = $cont%4;
				$limiteCategorias = (-$restoResultado)+4;
				
				$resultado_buscaPatrocinadosBrasil = sds_buscaPatrocinadosBrasil($estadoUF, $limiteCategorias);
				
				foreach($resultado_buscaPatrocinadosBrasil as $res_buscaPatrocinadosBrasil){
					$idCliente = $res_buscaPatrocinadosBrasil['clienteId'];
					$idAnuncio = $res_buscaPatrocinadosBrasil['idAnuncio'];
					$tituloAnuncio = $res_buscaPatrocinadosBrasil['tituloAnuncio'];
					$precoAnuncio = $res_buscaPatrocinadosBrasil['precoAnuncio'];
					$urlAnuncio		= $res_buscaPatrocinadosBrasil['urlAnuncio'];
					$emailAnunciante = $res_buscaPatrocinadosBrasil['email'];


					
					if($precoAnuncio == ""){
						$precoAnuncio = 'À negociar';	
					}else{
						$precoAnuncio = 'R$ '.$precoAnuncio;
					}
					echo 'as';
					$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
					$idCliente = $idCliente*(10-(1)+2*3*5*7);
			
				?>
					<li class="span3">
						<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>">
							<?php 
							if(verificar_url($idAnuncio, '1')){
							?>
								<span class="image-ads">
									<img src="<?php echo $imagem_um; ?>" width="170" height="96" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
								</span>
								<?php 
							}else{?>
								<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="170" height="96" name="foto-1" title="<?php echo $tituloAnuncio; ?>" alt="Imagem do anúncio patrocinado" />
							<?php } ?>
						</a>
						<span class="ads-desc-sidebar text-left">
							<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $tituloAnuncio ?></a>
						</span>

						<span class="ads-desc-sidebar text-left">
							<a href="<?php echo URL::getBase() ?>anuncio/<?php echo $urlAnuncio ?>"><?php echo $precoAnuncio ?></a>
						</span>
					</li>
					<?php
					
				}
			}
		}
	?>