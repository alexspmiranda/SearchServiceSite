<?php

function sds_getPage(){

		include "Connections/config.php";
		
		$statusDesativado = 'desativado';
		$statusAguardando = 'aguardando';
		$statusPendente	  = 'pendente';
		

		$url = Url::getURL(1);
		$estadoAnuncio = strip_tags(trim($url));
		$estadoLink = $estadoAnuncio;
		$estadoAnuncio = sds_verificaEstados($estadoAnuncio);

	
		$pag = strip_tags(trim("$_GET[pag]"));
		if($pag >= '1'){
		 $pag = $pag;
		}else{
		 $pag = '1';
		}		
		
		$maximo = '15'; //RESULTADOS POR PÁGINA
		$inicio = ($pag * $maximo) - $maximo;
				
		if($estadoAnuncio != 'Brasil'){
					
		//CONSULTA OS CLIENTES ATIVOS POR ESTADO
		$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
							  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
							  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
							  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							  WHERE clientes.status = :statusPendente) ORDER BY clientes.criadoEm DESC LIMIT '.$inicio.','.$maximo;
		try{					  
			$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
			$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
			$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
			$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
			$query_buscaPorEstado->bindValue(':statusPendente',   $statusPendente, PDO::PARAM_STR);
			$query_buscaPorEstado->execute();
		
			$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
			$resultado_contador = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
		
		if($resultado_contador == 0){
			echo "<h5>&nbsp;NENHUM RESULTADO ENCONTRADO</h5>";
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
			$idAnuncio = $res_buscaPorEstado['idAnuncio'];			
			$urlAnuncio = $res_buscaPorEstado['urlAnuncio'];
			$emailAnunciante = $res_buscaPorEstado['email'];


			if(empty($precoAnuncio)){
				$precoAnuncio = 'À negociar';	
			}else{
				$precoAnuncio = 'R$ '.$precoAnuncio;
			}
			
			$resultado_votacao = sds_selectVotosContagem($idCliente);
								
			$cont=0;
			foreach($resultado_votacao as $res_votacao){
				$votos 	+= $res_votacao['votos'];
				$cont++;
			}
			
			if($votos != 0){
				$avaliacao = number_format($votos/$cont,1,'.','.');
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
	}
	
	//CONSULTA OS CLIENTES ATIVOS POR ESTADO
	$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*
						  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
						  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
						  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						  WHERE clientes.status = :statusPendente) ORDER BY clientes.criadoEm DESC';
		try{					  
		$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
		$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
		$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
		$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
		$query_buscaPorEstado->bindValue(':statusPendente',   $statusPendente, PDO::PARAM_STR);
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
				<li><a href="<?php echo URL::getBase(); ?>estado/<?php echo $estadoLink ?>?pag=1">Primeira</a></li>
				
				<?php
					for ($i = $pag-$links; $i <= $pag-1; $i++){
					if ($i <= 0){
					}else{
						echo '<li><a href="'. URL::getBase() .'estado/'. $estadoLink .'?pag='.$i.'">'.$i.'</a>&nbsp;&nbsp;&nbsp;</li>';
					}
					}echo "<li><a href=\"#\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
					for($i = $pag +1; $i <= $pag+$links; $i++){
						if($i > $paginas){
						}else{
						echo '<li><a href="'. URL::getBase() .'estado/'. $estadoLink .'?pag='.$i.'">'. $i .'</a>&nbsp;&nbsp;&nbsp;</li>';
						}
					}
					echo '<li><a href="'. URL::getBase() .'estado/'. $estadoLink .'?pag='.$paginas.'">Última página</a></li>&nbsp;&nbsp;&nbsp';
				?>
			</ul>
		</center>
	</div>
	<?php
	
	}

	if($estadoAnuncio == 'Brasil'){


		$pag = strip_tags(trim("$_GET[pag]"));
		if($pag >= '1'){
		 $pag = $pag;
		}else{
		 $pag = '1';
		}		
		
		$maximo = '15'; //RESULTADOS POR PÁGINA
		$inicio = ($pag * $maximo) - $maximo;

		//CONSULTA OS CLIENTES ATIVOS POR ESTADO
		$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
							  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
							  WHERE clientes.clienteId = anuncio.idCliente_FK
							  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							  WHERE clientes.status = :statusPendente) ORDER BY clientes.criadoEm DESC LIMIT '.$inicio.','.$maximo;
		try{					  
			$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
			$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
			$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
			$query_buscaPorEstado->bindValue(':statusPendente',   $statusPendente, PDO::PARAM_STR);
			$query_buscaPorEstado->execute();
		
			$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
			$resultado_contador = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
		
		if($resultado_contador == 0){
			echo "<h5>&nbsp;NENHUM RESULTADO ENCONTRADO</h5>";
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
			$idAnuncio = $res_buscaPorEstado['idAnuncio'];			
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
						<address><a href="'. URL::getBase() .'anuncio/'.$urlAnuncio.'"  title="'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'">'; if($uf != 'BR'){ echo $bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf;}else{ echo 'BR';} echo '</a></address>
				</figure>
			</li></a>
			';
		}

		//CONSULTA OS CLIENTES ATIVOS POR ESTADO
		$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
						  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
						  WHERE clientes.clienteId = anuncio.idCliente_FK
						  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						  WHERE clientes.status = :statusPendente)';
		try{					  
		$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
		$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
		$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
		$query_buscaPorEstado->bindValue(':statusPendente',   $statusPendente, PDO::PARAM_STR);
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
					<li><a href="<?php echo URL::getBase(); ?>estado/<?php echo $estadoLink ?>?pag=1">Primeira</a></li>
					
					<?php
						for ($i = $pag-$links; $i <= $pag-1; $i++){
						if ($i <= 0){
						}else{
							echo '<li><a href="'. URL::getBase() .'estado/'. $estadoLink .'?pag='.$i.'">'.$i.'</a>&nbsp;&nbsp;&nbsp;</li>';
						}
						}echo "<li><a href=\"#\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
						for($i = $pag +1; $i <= $pag+$links; $i++){
							if($i > $paginas){
							}else{
							echo '<li><a href="'. URL::getBase() .'estado/'. $estadoLink .'?pag='.$i.'">'. $i .'</a>&nbsp;&nbsp;&nbsp;</li>';
							}
						}
						echo '<li><a href="'. URL::getBase() .'estado/'. $estadoLink .'?pag='.$paginas.'">Última página</a></li>&nbsp;&nbsp;&nbsp';
					?>
				</ul>
			</center>
		</div>
		<?php
		
		}
	}
}


function sds_getPage_by_preco(){

		include "Connections/config.php";
		
		$statusDesativado = 'desativado';
		$statusAguardando = 'aguardando';
		$statusPendente	  = 'pendente';
		
		$url = Url::getURL(1);
		$estadoAnuncio = strip_tags(trim($url));
		$estadoAnuncio = sds_verificaEstados($estadoAnuncio);

	
		$pag = strip_tags(trim("$_GET[pag]"));
		if($pag >= '1'){
		 $pag = $pag;
		}else{
		 $pag = '1';
		}		
		
		$maximo = '15'; //RESULTADOS POR PÁGINA
		$inicio = ($pag * $maximo) - $maximo;
				
		if($estadoAnuncio != 'Brasil'){
					
		//CONSULTA OS CLIENTES ATIVOS POR ESTADO
		$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*, clientes.*
							  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
							  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
							  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							  WHERE clientes.status = :statusPendente) ORDER BY anuncio.precoAnuncio DESC LIMIT '.$inicio.','.$maximo;
		try{					  
			$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
			$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
			$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
			$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
			$query_buscaPorEstado->bindValue(':statusPendente',   $statusPendente, PDO::PARAM_STR);
			$query_buscaPorEstado->execute();
		
			$resposta_buscaPorEstado = $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
			$resultado_contador = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
		
		if($resultado_contador == 0){
			echo "<h5>&nbsp;NENHUM RESULTADO ENCONTRADO</h5>";
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
			$idAnuncio = $res_buscaPorEstado['idAnuncio'];	
			$urlAnuncio = $res_buscaPorEstado['urlAnuncio'];	
			$emailAnunciante = $res_buscaPorEstado['email'];
			
			if(empty($precoAnuncio)){
				$precoAnuncio = 'À negociar';	
			}else{
				$precoAnuncio = 'R$ '.$precoAnuncio;
			}
			
			$resultado_votacao = sds_selectVotosContagem($idCliente);
								
			$cont=0;
			foreach($resultado_votacao as $res_votacao){
				$votos 	+= $res_votacao['votos'];
				$cont++;
			}
			
			if($votos != 0){
				$avaliacao = number_format($votos/$cont,1,'.','.');
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
	}
	
	//CONSULTA OS CLIENTES ATIVOS POR ESTADO
	$sql_buscaPorEstado = 'SELECT anuncio.*, estados.*
						  FROM sds_estados estados, sds_anuncio anuncio, sds_clientes clientes
						  WHERE clientes.clienteId = anuncio.idCliente_FK AND estados.nome = :nomeEstado
						  AND estados.id = anuncio.estadoAnuncio AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						  WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						  WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						  WHERE clientes.status = :statusPendente) ORDER BY anuncio.precoAnuncio DESC';
		try{					  
		$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
		$query_buscaPorEstado->bindValue(':nomeEstado', $estadoAnuncio, PDO::PARAM_STR);
		$query_buscaPorEstado->bindValue(':statusDesativado', $statusDesativado, PDO::PARAM_STR);
		$query_buscaPorEstado->bindValue(':statusAguardando', $statusAguardando, PDO::PARAM_STR);
		$query_buscaPorEstado->bindValue(':statusPendente',   $statusPendente, PDO::PARAM_STR);
		$query_buscaPorEstado->execute();
		
		$total = $query_buscaPorEstado->rowCount(PDO::FETCH_ASSOC);
		
		}catch(PDOException $erro_buscaPorEstado){
			echo 'Erro ao buscar os anúncios';	
		}
	
	$paginas = ceil($total/$maximo);
	$links = '4'; //QUANTIDADE DE LINKS NO PAGINATOR
	
	$estadoLink = strip_tags(trim($_GET['estado']));
	
	if($paginas > 1){
	
	?>
	
	<div class="pagination">
		<center>
			<ul>
				<li><a href="index.php?pg=page&estado=<?php echo $estadoLink; ?>&amp;pag=1">Primeira</a></li>
				
				<?php
					for ($i = $pag-$links; $i <= $pag-1; $i++){
					if ($i <= 0){
					}else{
						echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
					}
					}echo "<li><a href=\"#\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
					for($i = $pag +1; $i <= $pag+$links; $i++){
						if($i > $paginas){
						}else{
						echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
						}
					}
					echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
				?>
			</ul>
		</center>
	</div>
	<?php
	
	}
}

?>