<?php

function sds_getPageCategoria($estadoAnuncio, $cidadeAnuncio, $categoriaAnuncio){
	
	$pag = strip_tags(trim("$_GET[pag]"));
	$estadoLink = strip_tags(trim($estadoAnuncio));
	$categoriaAnuncioExplode = explode(' ', $categoriaAnuncio);
	$contaStringcategoriaAnuncioExplode = count($categoriaAnuncioExplode);	

	if($pag >= '1'){
		$pag = $pag;
	}else{
		$pag = '1';
	}

	
	$maximo = '15'; //RESULTADOS POR PÁGINA
	$inicio = ($pag * $maximo) - $maximo;
	
	include "Connections/config.php";
	
	if($estadoAnuncio != 'Brasil'){

		$estadoAnuncio = sds_verificaEstados($estadoAnuncio);
		$statusDesativado = 'desativado';
		$statusAguardando = 'aguardando';
		$statusPendente	  = 'pendente';
		
		//BUSCA CIDADE E CATEGORIA DO ANUNCIO
		if(!empty($cidadeAnuncio) && !empty($categoriaAnuncio)){	

			$sql_buscaPorEstado  = 'SELECT anuncio.*, estados.*, clientes.*
								   FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes';
			$sql_buscaPorEstado .= ' WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
								  	AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  	WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  	WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  	WHERE clientes.status = :statusPendente)';
			
			for($i=0; $i<$contaStringcategoriaAnuncioExplode; $i++){
				$sql_buscaPorEstado .=  ' AND anuncio.descricaoAnuncio LIKE :descricaoAnuncio'.$i;
			}

			$sql_buscaPorEstado	.=	' AND anuncio.cidadeAnuncio LIKE :cidadeAnuncio ORDER BY clientes.criadoEm DESC LIMIT '.$inicio.','.$maximo;
			
			try{
				
				$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
				$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':cidadeAnuncio', '%'.$cidadeAnuncio.'%', PDO::PARAM_STR);
				
				for($i=0; $i<$contaStringcategoriaAnuncioExplode; $i++){
					$query_buscaPorEstado->bindValue(':descricaoAnuncio'.$i, '%'.$categoriaAnuncioExplode[$i].'%', PDO::PARAM_STR);
				}
				
				$query_buscaPorEstado->execute();
				
				$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
				$resultado_contador = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
				
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
				}
				
			foreach($resposta_buscaPorEstado as $res_buscaPorEstado){
				$idCliente = $res_buscaPorEstado['idCliente_FK'];
				$idAnuncio = $res_buscaPorEstado['idAnuncio'];
				$nomeAnuncio = $res_buscaPorEstado['nomeFantasiaAnuncio'];
				$tituloAnuncio = $res_buscaPorEstado['tituloAnuncio'];
				$precoAnuncio = $res_buscaPorEstado['precoAnuncio'];
				$bairroAnuncio = $res_buscaPorEstado['bairroAnuncio'];
				$cidadeAnuncio = $res_buscaPorEstado['cidadeAnuncio'];
				$uf = $res_buscaPorEstado['uf'];
				$urlAnuncio = $res_buscaPorEstado['urlAnuncio'];
				$emailAnunciante = $res_buscaPorEstado['email'];


				if(empty($precoAnuncio)){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}
				
				$idCliente = $idCliente*(10-(1)+2*3*5*7);
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';

				echo '
			<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">					
				<li class="adspage">
					<figure>
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">';
						if(verificar_url($idAnuncio, '1')){?>
	                    	<img src="<?php echo $imagem_um; ?>" width="140" height="79" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
	                    <?php 
						}else{?>
							<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="79" name="foto-perfil" />
						<?php }
echo 					'</a>

						<div class="ads-info">	
							<h5 class="company-name"><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$nomeAnuncio.'">'.$nomeAnuncio.'</a></h5>					
							<figcaption><h4><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$tituloAnuncio.'">'.$tituloAnuncio.'</a></h4></figcaption>
						</div>

						<div class="adsprice"><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$precoAnuncio.'">'.$precoAnuncio.'</a></div>
						<address><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'"  title="'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'">'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'</a></address>
				</figure>
			</li></a>
			';
			}
			
			$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
								  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
								  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
								  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio LIKE :categoriaAnuncio
								  AND anuncio.cidadeAnuncio LIKE :cidadeAnuncio ORDER BY clientes.criadoEm DESC';
			
			try{
				
				$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
				$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':cidadeAnuncio', '%'.$cidadeAnuncio.'%', PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%', PDO::PARAM_STR);
				$query_buscaPorEstado->execute();

				$total = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
				
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
			}	
			
			$paginas = ceil($total/$maximo);
			$links = '4'; //QUANTIDADE DE LINKS NO PAGINATOR

			if($paginas > 1){
				
				?>
				
				<div class="pagination">
					<center>
						<ul>
							<li><a href="index.php?pg=page&estado=<?php echo $estadoLink; ?>&categoria=<?php echo $categoriaAnuncio; ?>&cidade=<?php echo $cidadeAnuncio; ?>&amp;pag=1">Primeira</a></li>
							
							<?php
								for ($i = $pag-$links; $i <= $pag-1; $i++){
								if ($i <= 0){
								}else{
									echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
								}
								}echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$cidadeAnuncio&amp;pag=$i\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
								for($i = $pag +1; $i <= $pag+$links; $i++){
									if($i > $paginas){
									}else{
									echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
									}
								}
								echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$cidadeAnuncio&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
							?>
						</ul>
					</center>
				</div>
				<?php				
				}
			
			if($resultado_contador == 0){
				
				$bairroAnuncio = $cidadeAnuncio;
				
				//CONSULTA OS CLIENTES ATIVOS POR BAIRRO E CATEGORIA
				$sql_buscaPorEstado  = 'SELECT anuncio.*, estados.*, clientes.*
								   		FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes';
				$sql_buscaPorEstado .= ' WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
									  	AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  	WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  	WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  	WHERE clientes.status = :statusPendente)';
				
				for($i=0; $i<$contaStringcategoriaAnuncioExplode; $i++){
					$sql_buscaPorEstado .=  ' AND anuncio.descricaoAnuncio LIKE :descricaoAnuncio'.$i;
				}

				$sql_buscaPorEstado	.=	' AND anuncio.bairroAnuncio LIKE :bairroAnuncio ORDER BY clientes.criadoEm DESC LIMIT '.$inicio.','.$maximo;
				
				try{
					
					$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
					$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':bairroAnuncio', '%'.$bairroAnuncio.'%', PDO::PARAM_STR);
					
					for($i=0; $i<$contaStringcategoriaAnuncioExplode; $i++){
						$query_buscaPorEstado->bindValue(':descricaoAnuncio'.$i, '%'.$categoriaAnuncioExplode[$i].'%', PDO::PARAM_STR);
					}
					
					$query_buscaPorEstado->execute();
					
					$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
					$resultado_contadorCidCat = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
					
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
				}

				foreach($resposta_buscaPorEstado as $res_buscaPorEstado){
					$idCliente = $res_buscaPorEstado['idCliente_FK'];
					$idAnuncio = $res_buscaPorEstado['idAnuncio'];
					$nomeAnuncio = $res_buscaPorEstado['nomeFantasiaAnuncio'];
					$tituloAnuncio = $res_buscaPorEstado['tituloAnuncio'];
					$precoAnuncio = $res_buscaPorEstado['precoAnuncio'];
					$bairroAnuncio = $res_buscaPorEstado['bairroAnuncio'];
					$cidadeAnuncio = $res_buscaPorEstado['cidadeAnuncio'];
					$uf = $res_buscaPorEstado['uf'];
					$urlAnuncio = $res_buscaPorEstado['urlAnuncio'];
					$emailAnunciante = $res_buscaPorEstado['email'];
					
					if(empty($precoAnuncio)){
						$precoAnuncio = 'À negociar';	
					}else{
						$precoAnuncio = 'R$ '.$precoAnuncio;
					}
						
					$idCliente = $idCliente*(10-(1)+2*3*5*7);

					$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
			
					echo '
				<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">					
				<li class="adspage">
					<figure>
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">';
						if(verificar_url($idAnuncio, '1')){?>
	                    	<img src="<?php echo $imagem_um; ?>" width="140" height="79" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
	                    <?php 
						}else{?>
							<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="79" name="foto-perfil" />
						<?php }
echo 					'</a>

						<div class="ads-info">	
							<h5 class="company-name"><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$nomeAnuncio.'">'.$nomeAnuncio.'</a></h5>					
							<figcaption><h4><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$tituloAnuncio.'">'.$tituloAnuncio.'</a></h4></figcaption>
						</div>

						<div class="adsprice"><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$precoAnuncio.'">'.$precoAnuncio.'</a></div>
						<address><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'"  title="'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'">'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'</a></address>
				</figure>
			</li></a>
						';
				}
				
				$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
									  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
									  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
									  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio LIKE :categoriaAnuncio
									  AND anuncio.bairroAnuncio LIKE :bairroAnuncio ORDER BY clientes.criadoEm DESC ';
				
				try{
					
					$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
					$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':bairroAnuncio', '%'.$bairroAnuncio.'%', PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%', PDO::PARAM_STR);
					$query_buscaPorEstado->execute();
					
					$resultado_contadorCidCat = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
					
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
				}
				
				$paginas = ceil($resultado_contadorCidCat/$maximo);
				$links = '4'; //QUANTIDADE DE LINKS NO PAGINATOR
				
				if($paginas > 1){
				
				?>

				<div class="pagination">
					<center>
						<ul>
							<li><a href="index.php?pg=page&estado=<?php echo $estadoLink; ?>&categoria=<?php echo $categoriaAnuncio; ?>&cidade=<?php echo $cidadeAnuncio; ?>&amp;pag=1">Primeira</a></li>
							
							<?php
								for ($i = $pag-$links; $i <= $pag-1; $i++){
								if ($i <= 0){
								}else{
									echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$bairroAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
								}
								}echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$bairroAnuncio&amp;pag=$i\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
								for($i = $pag +1; $i <= $pag+$links; $i++){
									if($i > $paginas){
									}else{
									echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$bairroAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
									}
								}
								echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$bairroAnuncio&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
							?>
						</ul>
					</center>
				</div>
				<?php				
				}
			}

		}elseif(empty($cidadeAnuncio) || empty($categoriaAnuncio)){				
			
			//CONSULTA OS CLIENTES ATIVOS POR CATEGORIA NO ESTADO
			$sql_buscaPorEstado  = 'SELECT anuncio.*, estados.*, clientes.*
							   		FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes';
			$sql_buscaPorEstado .= ' WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
								  	AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  	WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  	WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  	WHERE clientes.status = :statusPendente)';
			
			for($i=0; $i<$contaStringcategoriaAnuncioExplode; $i++){
				$sql_buscaPorEstado .=  ' AND anuncio.descricaoAnuncio LIKE :descricaoAnuncio'.$i;
			}

			$sql_buscaPorEstado	.=	' ORDER BY clientes.criadoEm DESC LIMIT '.$inicio.','.$maximo;
			
			try{
				
				$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
				$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
				
				for($i=0; $i<$contaStringcategoriaAnuncioExplode; $i++){
					$query_buscaPorEstado->bindValue(':descricaoAnuncio'.$i, '%'.$categoriaAnuncioExplode[$i].'%', PDO::PARAM_STR);
				}
				
				$query_buscaPorEstado->execute();
				
				$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
				$resultado_contadorBairroCat = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);

				if($resultado_contadorBairroCat == 0){
					echo "<span class=\"span4\"><h5>&nbsp;NENHUM RESULTADO ENCONTRADO</h5></span>";
				}

				
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
				}
				
			foreach($resposta_buscaPorEstado as $res_buscaPorEstado){
				$idCliente = $res_buscaPorEstado['idCliente_FK'];
				$idAnuncio = $res_buscaPorEstado['idAnuncio'];
				$nomeAnuncio = $res_buscaPorEstado['nomeFantasiaAnuncio'];
				$tituloAnuncio = $res_buscaPorEstado['tituloAnuncio'];
				$precoAnuncio = $res_buscaPorEstado['precoAnuncio'];
				$bairroAnuncio = $res_buscaPorEstado['bairroAnuncio'];
				$cidadeAnuncio = $res_buscaPorEstado['cidadeAnuncio'];
				$uf = $res_buscaPorEstado['uf'];
				$urlAnuncio = $res_buscaPorEstado['urlAnuncio'];
				$emailAnunciante = $res_buscaPorEstado['email'];

				if(empty($precoAnuncio)){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}
				
				$idCliente = $idCliente*(10-(1)+2*3*5*7);
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
							
				echo '
					<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">					
				<li class="adspage">
					<figure>
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">';
						if(verificar_url($idAnuncio, '1')){?>
	                    	<img src="<?php echo $imagem_um; ?>" width="140" height="79" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
	                    <?php 
						}else{?>
							<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="79" name="foto-perfil" />
						<?php }
echo 					'</a>

						<div class="ads-info">	
							<h5 class="company-name"><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$nomeAnuncio.'">'.$nomeAnuncio.'</a></h5>					
							<figcaption><h4><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$tituloAnuncio.'">'.$tituloAnuncio.'</a></h4></figcaption>
						</div>

						<div class="adsprice"><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" title="'.$precoAnuncio.'">'.$precoAnuncio.'</a></div>
						<address><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'"  title="'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'">'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'</a></address>
				</figure>
			</li></a>
					';
			}
			$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
								  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
								  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
								  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio LIKE :categoriaAnuncio
								  ORDER BY clientes.criadoEm DESC';
			
			try{
				
				$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
				$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%', PDO::PARAM_STR);
				$query_buscaPorEstado->execute();
				
			}catch(PDOException $erro_buscaPorEstado){
				echo 'Erro ao buscar os anúncios';	
			}
		
			$paginas = ceil($resultado_contador/$maximo);
			$links = '4'; //QUANTIDADE DE LINKS NO PAGINATOR

			if($paginas > 1){
				
				?>

				<div class="pagination">
					<center>
						<ul>
							<li><a href="index.php?pg=page&estado=<?php echo $estadoLink; ?>&categoria=<?php echo $categoriaAnuncio; ?>&amp;pag=1">Primeira</a></li>
							
							<?php
								for ($i = $pag-$links; $i <= $pag-1; $i++){
								if ($i <= 0){
								}else{
									echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
								}
								}echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&amp;pag=$i\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
								for($i = $pag +1; $i <= $pag+$links; $i++){
									if($i > $paginas){
									}else{
									echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
									}
								}
								echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
							?>
						</ul>
					</center>
				</div>
				<?php				
				}
			}
	}else{		
		if(!empty($cidadeAnuncio) && !empty($categoriaAnuncio)){	
			
			//CONSULTA OS CLIENTES ATIVOS POR ESTADO
			$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
								  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
								  WHERE clientes.clienteId = anuncio.idCliente_FK
								  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio LIKE :categoriaAnuncio
								  AND anuncio.cidadeAnuncio LIKE :cidadeAnuncio ORDER BY clientes.criadoEm DESC';
			
			try{
				
				$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
				$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':cidadeAnuncio', '%'.$cidadeAnuncio.'%', PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%', PDO::PARAM_STR);
				$query_buscaPorEstado->execute();
				
				$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
				$resultado_contador = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
				
				if($resultado_contador == 0){
					echo "<span class=\"span4\"><h5>&nbsp;NENHUM RESULTADO ENCONTRADO</h5></span>";
				}
				
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
				}
				
			foreach($resposta_buscaPorEstado as $res_buscaPorEstado){
				$idCliente = $res_buscaPorEstado['idCliente_FK'];
				$nomeAnuncio = $res_buscaPorEstado['nomeFantasiaAnuncio'];
				$tituloAnuncio = $res_buscaPorEstado['tituloAnuncio'];
				$precoAnuncio = $res_buscaPorEstado['precoAnuncio'];
				$bairroAnuncio = $res_buscaPorEstado['bairroAnuncio'];
				$cidadeAnuncio = $res_buscaPorEstado['cidadeAnuncio'];
				$uf = $res_buscaPorEstado['uf'];
				$urlAnuncio = $res_buscaPorEstado['urlAnuncio'];
				$emailAnunciante = $res_buscaPorEstado['email'];
				
				if(empty($precoAnuncio)){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}
				
				$idCliente = $idCliente*(10-(1)+2*3*5*7);
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
							
				echo '
				<a href="'. URL::getBase() .'anuncio/'.$idCliente.'">					
				<li>
				
					<div class="imagem-anuncio">
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'"></a>
					</div><!-- FECHA IMAGEM ANUNCIO -->
					
					<div class="nome-cliente">
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">'.$nomeAnuncio.'</a>
					</div><!-- FECHA TITULO ANUNCIO -->
					
					<div class="titulo-anuncio">
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">'.$tituloAnuncio.'</a>
					</div><!-- FECHA TITULO ANUNCIO -->
					
					<div class="preco-anuncio">
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">'.$precoAnuncio.'</a>
					</div><!-- FECHA PRECO ANUNCIO -->
					
					<div class="localizacao-anuncio">
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'</a>
					</div><!-- FECHA PRECO ANUNCIO -->
					
				</li></a>
				';
			}
		// 			?> 
  //                   	<img src="<?php echo $imagem_um; ?>" width="140" height="79" name="foto-perfil" />
  //                       <?php 
		// 			}else{?>
		// 				<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="79" name="foto-perfil" />
		// 			<?php }

	}
}


function sds_getPageCategoria_by_preco($estadoAnuncio, $cidadeAnuncio, $categoriaAnuncio){
	
	$pag = strip_tags(trim("$_GET[pag]"));
	$estadoLink = strip_tags(trim("$_GET[estado]"));

	if($pag >= '1'){
		$pag = $pag;
	}else{
		$pag = '1';
	}
	
	$maximo = '15'; //RESULTADOS POR PÁGINA
	$inicio = ($pag * $maximo) - $maximo;
	
	include "Connections/config.php";
	
	if($estadoAnuncio != 'Brasil'){

		$estadoAnuncio = sds_verificaEstados($estadoAnuncio);
		$statusDesativado = 'desativado';
		$statusAguardando = 'aguardando';
		$statusPendente	  = 'pendente';
		
		//BUSCA CIDADE E CATEGORIA DO ANUNCIO
		if(!empty($cidadeAnuncio) && !empty($categoriaAnuncio)){		

			$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
								  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
								  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
								  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio LIKE :categoriaAnuncio
								  AND anuncio.cidadeAnuncio LIKE :cidadeAnuncio ORDER BY anuncio.precoAnuncio DESC LIMIT '.$inicio.','.$maximo;
			
			try{
				
				$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
				$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':cidadeAnuncio', '%'.$cidadeAnuncio.'%', PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%', PDO::PARAM_STR);
				$query_buscaPorEstado->execute();
				
				$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
				$resultado_contador = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
				
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
				}
				
			foreach($resposta_buscaPorEstado as $res_buscaPorEstado){
				$idCliente = $res_buscaPorEstado['idCliente_FK'];
				$idAnuncio = $res_buscaPorEstado['idAnuncio'];
				$nomeAnuncio = $res_buscaPorEstado['nomeFantasiaAnuncio'];
				$tituloAnuncio = $res_buscaPorEstado['tituloAnuncio'];
				$precoAnuncio = $res_buscaPorEstado['precoAnuncio'];
				$bairroAnuncio = $res_buscaPorEstado['bairroAnuncio'];
				$cidadeAnuncio = $res_buscaPorEstado['cidadeAnuncio'];
				$uf = $res_buscaPorEstado['uf'];
				$urlAnuncio = $res_buscaPorEstado['urlAnuncio'];
				$emailAnunciante = $res_buscaPorEstado['email'];
				
				if(empty($precoAnuncio)){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}
				
				$idCliente = $idCliente*(10-(1)+2*3*5*7);
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_main_userImage1.jpg';
			
				echo '
			<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">					
			<li class="notices">
			
				<div class="img-page-thumb">
					<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">';
					if(verificar_url($idAnuncio, '1')){
					?> 
                    	<img src="<?php echo $imagem_um; ?>" width="140" height="79" name="foto-perfil" />
                        <?php 
					}else{?>
						<img src="<?php echo URL::getBase() ?>images/sem_imagens.png" width="140" height="79" name="foto-perfil" />
					<?php }
				echo '</a>
				</div>
				';?>
                
                <span class="status">
					<img src="<?php echo URL::getBase() ?>img/icon/online.png" height="19" width="19" alt="Online" title="Online">				
					<a href="#" title="Chat">Online</a>	
				</span>

                <?php  echo '
				<span class="info-notices">	
										
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Nome da empresa" class="btn btn-info">'.$nomeAnuncio.'</a>					
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Titulo do anúncio">'.$tituloAnuncio.'</a>
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Preço do anúncio" style="margin-top:5px;">'.$precoAnuncio.'</a>
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Endereço do anúncio" style="float:right; margin-top:15px;">'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'</a>
					</span>
				
			</li></a>
			';
			}
			
			$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
								  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
								  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
								  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio LIKE :categoriaAnuncio
								  AND anuncio.cidadeAnuncio LIKE :cidadeAnuncio ORDER BY anuncio.precoAnuncio DESC';
			
			try{
				
				$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
				$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':cidadeAnuncio', '%'.$cidadeAnuncio.'%', PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%', PDO::PARAM_STR);
				$query_buscaPorEstado->execute();

				$total = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
				
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
			}	
			
			$paginas = ceil($total/$maximo);
			$links = '4'; //QUANTIDADE DE LINKS NO PAGINATOR

			if($paginas > 1){
				
				?>
				
				<div class="pagination">
					<center>
						<ul>
							<li><a href="index.php?pg=page&estado=<?php echo $estadoLink; ?>&categoria=<?php echo $categoriaAnuncio; ?>&cidade=<?php echo $cidadeAnuncio; ?>&amp;pag=1">Primeira</a></li>
							
							<?php
								for ($i = $pag-$links; $i <= $pag-1; $i++){
								if ($i <= 0){
								}else{
									echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
								}
								}echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$cidadeAnuncio&amp;pag=$i\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
								for($i = $pag +1; $i <= $pag+$links; $i++){
									if($i > $paginas){
									}else{
									echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
									}
								}
								echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$cidadeAnuncio&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
							?>
						</ul>
					</center>
				</div>
				<?php				
				}
			
			if($resultado_contador == 0){
				
				$bairroAnuncio = $cidadeAnuncio;
				
				//CONSULTA OS CLIENTES ATIVOS POR BAIRRO E CATEGORIA
				$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
									  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
									  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
									  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio LIKE :categoriaAnuncio
									  AND anuncio.bairroAnuncio LIKE :bairroAnuncio ORDER BY anuncio.precoAnuncio DESC LIMIT '.$inicio.','.$maximo;
				
				try{
					
					$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
					$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':bairroAnuncio', '%'.$bairroAnuncio.'%', PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%', PDO::PARAM_STR);
					$query_buscaPorEstado->execute();
					
					$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
					$resultado_contadorCidCat = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
					
					if($resultado_contadorCidCat == 0){
						echo "<span class=\"span4\"><h5>&nbsp;NENHUM RESULTADO ENCONTRADO</h5></span>";
					}
					
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
				}

				foreach($resposta_buscaPorEstado as $res_buscaPorEstado){
					$idCliente = $res_buscaPorEstado['idCliente_FK'];
					$idAnuncio = $res_buscaPorEstado['idAnuncio'];
					$nomeAnuncio = $res_buscaPorEstado['nomeFantasiaAnuncio'];
					$tituloAnuncio = $res_buscaPorEstado['tituloAnuncio'];
					$precoAnuncio = $res_buscaPorEstado['precoAnuncio'];
					$bairroAnuncio = $res_buscaPorEstado['bairroAnuncio'];
					$cidadeAnuncio = $res_buscaPorEstado['cidadeAnuncio'];
					$uf = $res_buscaPorEstado['uf'];
					$urlAnuncio = $res_buscaPorEstado['urlAnuncio'];
					$emailAnunciante = $res_buscaPorEstado['email'];

					if(empty($precoAnuncio)){
						$precoAnuncio = 'À negociar';	
					}else{
						$precoAnuncio = 'R$ '.$precoAnuncio;
					}
					
					$idCliente = $idCliente*(10-(1)+2*3*5*7);
					$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_main_userImage1.jpg';
				

					echo '
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">					
						<li class="notices">
						
							<div class="img-page-thumb">
								<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">';
								if(verificar_url($idAnuncio, '1')){
								?> 
			                    	<img src="<?php echo $imagem_um; ?>" width="140" height="79" name="foto-perfil" />
			                        <?php 
								}else{?>
									<img src="<?php echo URL::getBase() ?>images/sem_imagens.png" width="140" height="79" name="foto-perfil" />
								<?php }
							echo '</a>
							</div>
							';?>
			                
			                <span class="status">
								<img src="<?php echo URL::getBase() ?>img/icon/online.png" height="19" width="19" alt="Online" title="Online">				
								<a href="#" title="Chat">Online</a>	
							</span>

			                <?php  echo '
							<span class="info-notices">	
								<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Nome da empresa" class="btn btn-info">'.$nomeAnuncio.'</a>					
								<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Titulo do anúncio">'.$tituloAnuncio.'</a>
								<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Preço do anúncio" style="margin-top:5px;">'.$precoAnuncio.'</a>
								<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Endereço do anúncio" style="float:right; margin-top:15px;">'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'</a>
							</span>
							
						</li></a>
						';
				}
				
				$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
									  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
									  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
									  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
									  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio = :categoriaAnuncio
									  AND anuncio.bairroAnuncio = :bairroAnuncio ORDER BY anuncio.precoAnuncio DESC ';
				
				try{
					
					$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
					$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':bairroAnuncio', $bairroAnuncio, PDO::PARAM_STR);
					$query_buscaPorEstado->bindValue(':categoriaAnuncio', $categoriaAnuncio, PDO::PARAM_STR);
					$query_buscaPorEstado->execute();
					
					$resultado_contadorCidCat = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
					
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
				}
				
				$paginas = ceil($resultado_contadorCidCat/$maximo);
				$links = '4'; //QUANTIDADE DE LINKS NO PAGINATOR
				
				if($paginas > 1){
				
				?>

				<div class="pagination">
					<center>
						<ul>
							<li><a href="index.php?pg=page&estado=<?php echo $estadoLink; ?>&categoria=<?php echo $categoriaAnuncio; ?>&cidade=<?php echo $cidadeAnuncio; ?>&amp;pag=1">Primeira</a></li>
							
							<?php
								for ($i = $pag-$links; $i <= $pag-1; $i++){
								if ($i <= 0){
								}else{
									echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$bairroAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
								}
								}echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$bairroAnuncio&amp;pag=$i\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
								for($i = $pag +1; $i <= $pag+$links; $i++){
									if($i > $paginas){
									}else{
									echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$bairroAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
									}
								}
								echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&cidade=$bairroAnuncio&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
							?>
						</ul>
					</center>
				</div>
				<?php				
				}
			}
		}elseif(empty($cidadeAnuncio) || empty($categoriaAnuncio)){				
			
			//CONSULTA OS CLIENTES ATIVOS POR CATEGORIA NO ESTADO
			$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
								  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
								  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
								  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio = :categoriaAnuncio
								  ORDER BY anuncio.precoAnuncio DESC LIMIT '.$inicio.','.$maximo;
			
			try{
				
				$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
				$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':categoriaAnuncio', $categoriaAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->execute();
				
				$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
				$resultado_contador_1 = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
				
				if($resultado_contador_1 == 0){
					//echo "<span class=\"span4\"><h5>&nbsp;NENHUM RESULTADO ENCONTRADO</h5></span>";
				}

				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
				}
				
			foreach($resposta_buscaPorEstado as $res_buscaPorEstado){
				$idCliente 		= $res_buscaPorEstado['idCliente_FK'];
				$idAnuncio 		= $res_buscaPorEstado['idAnuncio'];
				$nomeAnuncio 	= $res_buscaPorEstado['nomeFantasiaAnuncio'];
				$tituloAnuncio 	= $res_buscaPorEstado['tituloAnuncio'];
				$precoAnuncio 	= $res_buscaPorEstado['precoAnuncio'];
				$bairroAnuncio 	= $res_buscaPorEstado['bairroAnuncio'];
				$cidadeAnuncio 	= $res_buscaPorEstado['cidadeAnuncio'];
				$uf 			= $res_buscaPorEstado['uf'];
				$urlAnuncio 	= $res_buscaPorEstado['urlAnuncio'];
				$emailAnunciante = $res_buscaPorEstado['email'];
				
				if(empty($precoAnuncio)){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}
				
				$idCliente = $idCliente*(10-(1)+2*3*5*7);
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_main_userImage1.jpg';
							
				echo '
					<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">					
					<li class="notices">
					
						<div class="img-page-thumb">
							<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">';
							if(verificar_url($idAnuncio, '1')){
							?> 
		                    	<img src="<?php echo $imagem_um; ?>" width="140" height="79" name="foto-perfil" />
		                        <?php 
							}else{?>
								<img src="<?php echo URL::getBase() ?>images/sem_imagens.png" width="140" height="79" name="foto-perfil" />
							<?php }
						echo '</a>
						</div>
						';?>
		                
		                <span class="status">
							<img src="<?php echo URL::getBase() ?>img/icon/online.png" height="19" width="19" alt="Online" title="Online">				
							<a href="#" title="Chat">Online</a>	
						</span>

		                <?php  echo '
						<span class="info-notices">	
							
							
								<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Nome da empresa" class="btn btn-info">'.$nomeAnuncio.'</a>					
								<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Titulo do anúncio">'.$tituloAnuncio.'</a>
								<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Preço do anúncio" style="margin-top:5px;">'.$precoAnuncio.'</a>
								<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'" class="notices-font-style" title="Endereço do anúncio" style="float:right; margin-top:15px;">'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'</a>
							</span>
						
					</li></a>
					';
			}
			$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
								  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
								  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
								  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio = :categoriaAnuncio
								  ORDER BY anuncio.precoAnuncio DESC';
			
			try{
				
				$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
				$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':categoriaAnuncio', $categoriaAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->execute();
				
				$resultado_contador = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);

				if($resultado_contador == 0){
					echo "<span class=\"span4\"><h5>&nbsp;NENHUM RESULTADO ENCONTRADO</h5></span>";
				}
				
			}catch(PDOException $erro_buscaPorEstado){
				echo 'Erro ao buscar os anúncios';	
			}
		
			$paginas = ceil($resultado_contador/$maximo);
			$links = '4'; //QUANTIDADE DE LINKS NO PAGINATOR

			if($paginas > 1){
				
				?>

				<div class="pagination">
					<center>
						<ul>
							<li><a href="index.php?pg=page&estado=<?php echo $estadoLink; ?>&categoria=<?php echo $categoriaAnuncio; ?>&amp;pag=1">Primeira</a></li>
							
							<?php
								for ($i = $pag-$links; $i <= $pag-1; $i++){
								if ($i <= 0){
								}else{
									echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
								}
								}echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&amp;pag=$i\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
								for($i = $pag +1; $i <= $pag+$links; $i++){
									if($i > $paginas){
									}else{
									echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
									}
								}
								echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&categoria=$categoriaAnuncio&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
							?>
						</ul>
					</center>
				</div>
				<?php				
				}
			}
	}else{		
		if(!empty($cidadeAnuncio) && !empty($categoriaAnuncio)){	
			
			//CONSULTA OS CLIENTES ATIVOS POR ESTADO
			$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
								  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
								  WHERE clientes.clienteId = anuncio.idCliente_FK
								  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
								  WHERE clientes.status = :statusPendente) AND anuncio.categoriaAnuncio = :categoriaAnuncio
								  AND anuncio.cidadeAnuncio = :cidadeAnuncio ORDER BY anuncio.precoAnuncio DESC';
			
			try{
				
				$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
				$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':statusPendente', $statusPendente, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':cidadeAnuncio', $cidadeAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->bindValue(':categoriaAnuncio', $categoriaAnuncio, PDO::PARAM_STR);
				$query_buscaPorEstado->execute();
				
				$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
				$resultado_contador = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
				
				if($resultado_contador == 0){
					echo "<span class=\"span4\"><h5>&nbsp;NENHUM RESULTADO ENCONTRADO</h5></span>";
				}
				
				}catch(PDOException $erro_buscaPorEstado){
					echo 'Erro ao buscar os anúncios';	
				}
				
			foreach($resposta_buscaPorEstado as $res_buscaPorEstado){
				$idCliente = $res_buscaPorEstado['idCliente_FK'];
				$nomeAnuncio = $res_buscaPorEstado['nomeFantasiaAnuncio'];
				$tituloAnuncio = $res_buscaPorEstado['tituloAnuncio'];
				$precoAnuncio = $res_buscaPorEstado['precoAnuncio'];
				$bairroAnuncio = $res_buscaPorEstado['bairroAnuncio'];
				$cidadeAnuncio = $res_buscaPorEstado['cidadeAnuncio'];
				$uf = $res_buscaPorEstado['uf'];
				$urlAnuncio = $res_buscaPorEstado['urlAnuncio'];
				$emailAnunciante = $res_buscaPorEstado['email'];
				
				if(empty($precoAnuncio)){
					$precoAnuncio = 'À negociar';	
				}else{
					$precoAnuncio = 'R$ '.$precoAnuncio;
				}
				
				$idCliente = $idCliente*(10-(1)+2*3*5*7);
				$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_main_userImage1.jpg';
							
				echo '
				<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">					
				<li>
				
					<div class="imagem-anuncio">
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'"></a>
					</div><!-- FECHA IMAGEM ANUNCIO -->
					
					<div class="nome-cliente">
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">'.$nomeAnuncio.'</a>
					</div><!-- FECHA TITULO ANUNCIO -->
					
					<div class="titulo-anuncio">
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'">'.$tituloAnuncio.'</a>
					</div><!-- FECHA TITULO ANUNCIO -->
					
					<div class="preco-anuncio">
						<a href="'. URL::getBase() .'anuncio/'.$idCliente.'">'.$precoAnuncio.'</a>
					</div><!-- FECHA PRECO ANUNCIO -->
					
					<div class="localizacao-anuncio">
						<a href="'. URL::getBase() .'anuncio/'.$idCliente.'">'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'</a>
					</div><!-- FECHA PRECO ANUNCIO -->
					
				</li></a>
				';
			}
		// 			?> 
  //                   	<img src="<?php echo $imagem_um; ?>" width="140" height="79" name="foto-perfil" />
  //                       <?php 
		// 			}else{?>
		// 				<img src="<?php echo URL::getBase() ?>images/sem_imagens.png" width="140" height="79" name="foto-perfil" />
		// 			<?php }

	}
}
?>	