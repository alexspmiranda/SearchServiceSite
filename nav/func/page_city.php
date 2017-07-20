<?php

/* -------------------------------------------------------------------------------------------------------------------------------------*/	

function sds_getPageCidade(){
	
	$pag = strip_tags(trim("$_GET[pag]"));
	$estadoLink = strip_tags(trim(Url::getURL(1)));

	if($pag >= '1'){
		$pag = $pag;
	}else{
		$pag = '1';
	}
	
	$maximo = '15'; //RESULTADOS POR PÁGINA
	$inicio = ($pag * $maximo) - $maximo;
	
	include "Connections/config.php";
	
	$statusDesativado = 'desativado';
	$statusAguardando = 'aguardando';
	$statusPendente	  = 'pendente';
	
	$cidadeAnuncio = strip_tags(trim($_POST['busca-cidade']));
	$estadoAnuncio = strip_tags(trim(Url::getURL(1)));

	if(empty($cidadeAnuncio)){
		$cidadeAnuncio = strip_tags(trim(urldecode(Url::getURL(3))));
	}

	//$cidadeAnuncio = retira_acentos($cidadeAnuncio);
	$estadoAnuncio = sds_verificaUF($estadoAnuncio);
	
	$sql_buscaCidade = 'SELECT anuncio.*, uf.uf, clientes.*
						FROM sds_anuncio anuncio, sds_estados uf, sds_clientes clientes
						WHERE anuncio.cidadeAnuncio LIKE :cidadeAnuncio AND uf.uf = :estadoAnuncio AND uf.id = anuncio.estadoAnuncio 
						AND anuncio.idCliente_fk = clientes.clienteId AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
					    WHERE clientes.status = :statusPendente) ORDER BY clientes.criadoEm DESC LIMIT '.$inicio.','.$maximo;
	try{
		
		$query_buscaCidade = $connect->prepare($sql_buscaCidade);
		$query_buscaCidade->bindValue(':cidadeAnuncio', '%'.$cidadeAnuncio.'%' ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':estadoAnuncio', $estadoAnuncio ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusPendente', $statusPendente ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusAguardando', $statusAguardando ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusDesativado', $statusDesativado ,PDO::PARAM_STR);
		$query_buscaCidade->execute();
		
		$resultado_buscaCidade= $query_buscaCidade->fetchAll(PDO::FETCH_ASSOC);
		$resultado_cont = $query_buscaCidade->rowCount(PDO::FETCH_ASSOC);
					
	}catch(PDOException $erro_buscaCidade){
		echo 'Erro ao consultar por cidade';
	}
	
	foreach($resultado_buscaCidade as $res_buscaCidade){
		$idCliente 			= $res_buscaCidade['idCliente_FK'];
		$idAnuncio 			= $res_buscaCidade['idAnuncio'];
		$nomeAnuncio 		= $res_buscaCidade['nomeFantasiaAnuncio'];
		$tituloAnuncio 		= $res_buscaCidade['tituloAnuncio'];
		$precoAnuncio 		= $res_buscaCidade['precoAnuncio'];
		$bairroAnuncio 		= $res_buscaCidade['bairroAnuncio'];
		$cidadeAnuncio 		= $res_buscaCidade['cidadeAnuncio'];
		$uf 				= $res_buscaCidade['uf'];		
		$urlAnuncio 		= $res_buscaCidade['urlAnuncio'];
		$emailAnunciante 	= $res_buscaCidade['email'];
		
		if($precoAnuncio == ""){
			$precoAnuncio = 'À negociar';	
		}else{
			$precoAnuncio = 'R$ '.$precoAnuncio;
		}
		
//		$idImagem = listaImagemAnuncio($idAnuncio);
		$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
		$idCliente = $idCliente*(10-(1)+2*3*5*7);
		
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
	
	$sql_buscaCidade = 'SELECT anuncio.*, uf.uf, clientes.*
						FROM sds_anuncio anuncio, sds_estados uf, sds_clientes clientes
						WHERE anuncio.cidadeAnuncio LIKE :cidadeAnuncio AND uf.uf = :estadoAnuncio AND uf.id = anuncio.estadoAnuncio 
						AND anuncio.idCliente_fk = clientes.clienteId AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
					    WHERE clientes.status = :statusPendente) ORDER BY clientes.criadoEm DESC';
		try{					  
		$query_buscaCidade = $connect->prepare($sql_buscaCidade);
		$query_buscaCidade->bindValue(':cidadeAnuncio', '%'.$cidadeAnuncio.'%' ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':estadoAnuncio', $estadoAnuncio ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusPendente', $statusPendente ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusAguardando', $statusAguardando ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusDesativado', $statusDesativado ,PDO::PARAM_STR);
		$query_buscaCidade->execute();
		
		$total = $query_buscaCidade->rowCount(PDO::FETCH_ASSOC);
		
		}catch(PDOException $erro_buscaCidade){
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
									echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
								}
								}echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
								for($i = $pag +1; $i <= $pag+$links; $i++){
									if($i > $paginas){
									}else{
									echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
									}
								}
								echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
							?>
						</ul>
					</center>
				</div>
				<?php				
				}
	
/* -------------------------------------------------------------------------------------------------------------------------------------*/	
	
	// BUSCA POR BAIRRO
	if($resultado_cont == 0){
		
		$bairroAnuncio = $cidadeAnuncio;
		
		// VERIFICA O NOME E O ID PARA ENVIAR PARA A CONSULTA DE BAIRRO
		
		$estadoAnuncio = strip_tags(trim(Url::getURL(1)));		
		$estadoAnuncio = sds_verificaUF($estadoAnuncio);
				
		//FAZ A CONSULTA POR BAIRRO
						
		$sql_buscaBairro = 'SELECT anuncio.*, uf.uf, clientes.*
							FROM sds_anuncio anuncio, sds_estados uf, sds_clientes clientes
							WHERE anuncio.bairroAnuncio LIKE :bairroAnuncio AND uf.uf = :estadoAnuncio AND uf.id = anuncio.estadoAnuncio 
							AND anuncio.idCliente_fk = clientes.clienteId AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
					    	WHERE clientes.status = :statusPendente) ORDER BY clientes.criadoEm DESC LIMIT '.$inicio.','.$maximo;

		try{
			
			$query_buscaBairro = $connect->prepare($sql_buscaBairro);
			$query_buscaBairro->bindValue(':bairroAnuncio', '%'.$bairroAnuncio.'%' ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':estadoAnuncio', $estadoAnuncio ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusPendente', $statusPendente ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusAguardando', $statusAguardando ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusDesativado', $statusDesativado ,PDO::PARAM_STR);
			$query_buscaBairro->execute();
			
			$resultado_buscaBairro= $query_buscaBairro->fetchAll(PDO::FETCH_ASSOC);
			$resultado_contar = $query_buscaBairro->rowCount(PDO::FETCH_ASSOC);
			
			
		}catch(PDOException $erro_buscaBairro){
			echo 'Erro ao consultar por bairro';
		}
		
		foreach($resultado_buscaBairro as $res_buscaBairro){
			$idCliente			= $res_buscaBairro['idCliente_FK'];
			$idAnuncio 			= $res_buscaBairro['idAnuncio'];
			$nomeAnuncio		= $res_buscaBairro['nomeFantasiaAnuncio'];
			$tituloAnuncio		= $res_buscaBairro['tituloAnuncio'];
			$precoAnuncio		= $res_buscaBairro['precoAnuncio'];
			$bairroAnuncio  	= $res_buscaBairro['bairroAnuncio'];
			$cidadeAnuncio		= $res_buscaBairro['cidadeAnuncio'];
			$uf					= $res_buscaBairro['uf'];
			$urlAnuncio 		= $res_buscaBairro['urlAnuncio'];
			$emailAnunciante 	= $res_buscaBairro['email'];

			if($precoAnuncio == ""){
				$precoAnuncio = 'À negociar';	
			}else{
				$precoAnuncio = 'R$ '.$precoAnuncio;
			}

			$idCliente = $idCliente*(10-(1)+2*3*5*7);
			$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
//			$idImagem = listaImagemAnuncio($idAnuncio);
			
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
		
		$sql_buscaBairro = 'SELECT anuncio.*, uf.uf, clientes.*
							FROM sds_anuncio anuncio, sds_estados uf, sds_clientes clientes
							WHERE anuncio.bairroAnuncio LIKE :bairroAnuncio AND uf.uf = :estadoAnuncio AND uf.id = anuncio.estadoAnuncio 
							AND anuncio.idCliente_fk = clientes.clienteId AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
					    	WHERE clientes.status = :statusPendente) ORDER BY clientes.criadoEm DESC';

		try{
			
			$query_buscaBairro = $connect->prepare($sql_buscaBairro);
			$query_buscaBairro->bindValue(':bairroAnuncio', '%'.$bairroAnuncio.'%' ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':estadoAnuncio', $estadoAnuncio ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusPendente', $statusPendente ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusAguardando', $statusAguardando ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusDesativado', $statusDesativado ,PDO::PARAM_STR);
			$query_buscaBairro->execute();

			$resultado_contar = $query_buscaBairro->rowCount(PDO::FETCH_ASSOC);
			
			
		}catch(PDOException $erro_buscaBairro){
			echo 'Erro ao consultar por bairro';
		}
		
		$paginas = ceil($resultado_contar/$maximo);
		$links = '4'; //QUANTIDADE DE LINKS NO PAGINATOR
		
		if($paginas > 1){
		
		?>
				
				<div class="pagination">
					<center>
						<ul>
							<li><a href="index.php?pg=page&estado=<?php echo $estadoLink; ?>&cidade=<?php echo $cidadeAnuncio; ?>&amp;pag=1">Primeira</a></li>
							
							<?php
								for ($i = $pag-$links; $i <= $pag-1; $i++){
								if ($i <= 0){
								}else{
									echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
								}
								}echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
								for($i = $pag +1; $i <= $pag+$links; $i++){
									if($i > $paginas){
									}else{
									echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
									}
								}
								echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
							?>
						</ul>
					</center>
				</div>
				<?php				
				}
	}
}

function sds_getPageCidade_by_preco(){
	
	$pag = strip_tags(trim("$_GET[pag]"));
	$estadoLink = strip_tags(trim(Url::getURL(1)));
	
	if($pag >= '1'){
		$pag = $pag;
	}else{
		$pag = '1';
	}
	
	$maximo = '15'; //RESULTADOS POR PÁGINA
	$inicio = ($pag * $maximo) - $maximo;
	
	include "Connections/config.php";
	
	$statusDesativado = 'desativado';
	$statusAguardando = 'aguardando';
	$statusPendente	  = 'pendente';
	
	$cidadeAnuncio = strip_tags(trim($_POST['busca-cidade']));
	$estadoAnuncio = strip_tags(trim(Url::getURL(1)));

	if(empty($cidadeAnuncio)){
		$cidadeAnuncio = strip_tags(trim(urldecode(Url::getURL(3))));
	}

	//$cidadeAnuncio = retira_acentos($cidadeAnuncio);
	$estadoAnuncio = sds_verificaUF($estadoAnuncio);
	
	$sql_buscaCidade = 'SELECT anuncio.*, uf.uf, clientes.*
						FROM sds_anuncio anuncio, sds_estados uf, sds_clientes clientes
						WHERE anuncio.cidadeAnuncio LIKE :cidadeAnuncio AND uf.uf = :estadoAnuncio AND uf.id = anuncio.estadoAnuncio 
						AND anuncio.idCliente_fk = clientes.clienteId AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
					    WHERE clientes.status = :statusPendente) ORDER BY anuncio.precoAnuncio DESC LIMIT '.$inicio.','.$maximo;
	try{
		
		$query_buscaCidade = $connect->prepare($sql_buscaCidade);
		$query_buscaCidade->bindValue(':cidadeAnuncio', '%'.$cidadeAnuncio.'%' ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':estadoAnuncio', $estadoAnuncio ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusPendente', $statusPendente ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusAguardando', $statusAguardando ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusDesativado', $statusDesativado ,PDO::PARAM_STR);
		$query_buscaCidade->execute();
		
		$resultado_buscaCidade= $query_buscaCidade->fetchAll(PDO::FETCH_ASSOC);
		$resultado_cont = $query_buscaCidade->rowCount(PDO::FETCH_ASSOC);
					
	}catch(PDOException $erro_buscaCidade){
		echo 'Erro ao consultar por cidade';
	}
	
	foreach($resultado_buscaCidade as $res_buscaCidade){
		$idCliente 			= $res_buscaCidade['idCliente_FK'];
		$idAnuncio		 	= $res_buscaCidade['idAnuncio'];
		$nomeAnuncio 		= $res_buscaCidade['nomeFantasiaAnuncio'];
		$tituloAnuncio 		= $res_buscaCidade['tituloAnuncio'];
		$precoAnuncio 		= $res_buscaCidade['precoAnuncio'];
		$bairroAnuncio	 	= $res_buscaCidade['bairroAnuncio'];
		$cidadeAnuncio 		= $res_buscaCidade['cidadeAnuncio'];
		$uf 				= $res_buscaCidade['uf'];		
        $urlAnuncio			= $res_buscaCidade['urlAnuncio'];
		$emailAnunciante 	= $res_buscaCidade['email'];

		if($precoAnuncio == ""){
			$precoAnuncio = 'À negociar';	
		}else{
			$precoAnuncio = 'R$ '.$precoAnuncio;
		}
		
//		$idImagem = listaImagemAnuncio($idAnuncio);
		$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
		$idCliente = $idCliente*(10-(1)+2*3*5*7);
		
		echo '
			<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'">					
			<li class="notices">
			
				<div class="img-page-thumb">
					<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'">';
					if(verificar_url($idAnuncio, '1')){
					?> 
                    	<img src="<?php echo $imagem_um; ?>" width="140" height="79" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
                    
                        <?php 
					}else{?>
						<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="79" name="foto-perfil" />
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

					
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'" class="notices-font-style" title="Nome da empresa" class="btn btn-info">'.$nomeAnuncio.'</a>					
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'" class="notices-font-style" title="Titulo do anúncio">'.$tituloAnuncio.'</a>
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'" class="notices-font-style" title="Preço do anúncio" style="margin-top:5px;">'.$precoAnuncio.'</a>
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'" class="notices-font-style" title="Endereço do anúncio" style="float:right; margin-top:15px;">'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'</a>
					</span>
				
			</li></a>
			';
	}
	
	$sql_buscaCidade = 'SELECT anuncio.*, uf.uf, clientes.*
						FROM sds_anuncio anuncio, sds_estados uf, sds_clientes clientes
						WHERE anuncio.cidadeAnuncio LIKE :cidadeAnuncio AND uf.uf = :estadoAnuncio AND uf.id = anuncio.estadoAnuncio 
						AND anuncio.idCliente_fk = clientes.clienteId AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
						WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
					    WHERE clientes.status = :statusPendente) ORDER BY anuncio.precoAnuncio DESC';
		try{					  
		$query_buscaCidade = $connect->prepare($sql_buscaCidade);
		$query_buscaCidade->bindValue(':cidadeAnuncio', '%'.$cidadeAnuncio.'%' ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':estadoAnuncio', $estadoAnuncio ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusPendente', $statusPendente ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusAguardando', $statusAguardando ,PDO::PARAM_STR);
		$query_buscaCidade->bindValue(':statusDesativado', $statusDesativado ,PDO::PARAM_STR);
		$query_buscaCidade->execute();
		
		$total = $query_buscaCidade->rowCount(PDO::FETCH_ASSOC);
		
		}catch(PDOException $erro_buscaCidade){
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
									echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
								}
								}echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
								for($i = $pag +1; $i <= $pag+$links; $i++){
									if($i > $paginas){
									}else{
									echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
									}
								}
								echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
							?>
						</ul>
					</center>
				</div>
				<?php				
				}
	
/* -------------------------------------------------------------------------------------------------------------------------------------*/	
	
	// BUSCA POR BAIRRO
	if($resultado_cont == 0){
		
		$bairroAnuncio = $cidadeAnuncio;
		
		// VERIFICA O NOME E O ID PARA ENVIAR PARA A CONSULTA DE BAIRRO
		
		$estadoAnuncio = strip_tags(trim(Url::getURL(1)));		
		$estadoAnuncio = sds_verificaUF($estadoAnuncio);
				
		//FAZ A CONSULTA POR BAIRRO
						
		$sql_buscaBairro = 'SELECT anuncio.*, uf.uf, clientes.*
							FROM sds_anuncio anuncio, sds_estados uf, sds_clientes clientes
							WHERE anuncio.bairroAnuncio LIKE :bairroAnuncio AND uf.uf = :estadoAnuncio AND uf.id = anuncio.estadoAnuncio 
							AND anuncio.idCliente_fk = clientes.clienteId AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
					    	WHERE clientes.status = :statusPendente) ORDER BY anuncio.precoAnuncio DESC LIMIT '.$inicio.','.$maximo;

		try{
			
			$query_buscaBairro = $connect->prepare($sql_buscaBairro);
			$query_buscaBairro->bindValue(':bairroAnuncio', '%'.$bairroAnuncio.'%' ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':estadoAnuncio', $estadoAnuncio ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusPendente', $statusPendente ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusAguardando', $statusAguardando ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusDesativado', $statusDesativado ,PDO::PARAM_STR);
			$query_buscaBairro->execute();
			
			$resultado_buscaBairro= $query_buscaBairro->fetchAll(PDO::FETCH_ASSOC);
			$resultado_contar = $query_buscaBairro->rowCount(PDO::FETCH_ASSOC);
			
			
		}catch(PDOException $erro_buscaBairro){
			echo 'Erro ao consultar por bairro';
		}
		
		foreach($resultado_buscaBairro as $res_buscaBairro){
			$idCliente			= $res_buscaBairro['idCliente_FK'];
			$idAnuncio 			= $res_buscaBairro['idAnuncio'];
			$nomeAnuncio		= $res_buscaBairro['nomeFantasiaAnuncio'];
			$tituloAnuncio		= $res_buscaBairro['tituloAnuncio'];
			$precoAnuncio		= $res_buscaBairro['precoAnuncio'];
			$bairroAnuncio  	= $res_buscaBairro['bairroAnuncio'];
			$cidadeAnuncio		= $res_buscaBairro['cidadeAnuncio'];
			$uf					= $res_buscaBairro['uf'];
            $urlAnuncio			= $res_buscaBairro['urlAnuncio'];
            $emailAnunciante 	= $res_buscaBairro['email'];

			if($precoAnuncio == ""){
				$precoAnuncio = 'À negociar';	
			}else{
				$precoAnuncio = 'R$ '.$precoAnuncio;
			}

			$idCliente = $idCliente*(10-(1)+2*3*5*7);
			$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';
//			$idImagem = listaImagemAnuncio($idAnuncio);
			
			echo '
			<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'">					
			<li class="notices">
			
				<div class="img-page-thumb">
					<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'">';
					if(verificar_url($idAnuncio, '1')){
					?> 
                    	<img src="<?php echo $imagem_um; ?>" width="140" height="79" name="foto-perfil" alt="<?php echo $tituloAnuncio; ?>" title="<?php echo $tituloAnuncio; ?>" />
                    
                        <?php 
					}else{?>
						<img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="140" height="79" name="foto-perfil" />
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
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'" class="notices-font-style" title="Nome da empresa" class="btn btn-info">'.$nomeAnuncio.'</a>					
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'" class="notices-font-style" title="Titulo do anúncio">'.$tituloAnuncio.'</a>
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'" class="notices-font-style" title="Preço do anúncio" style="margin-top:5px;">'.$precoAnuncio.'</a>
						<a href="'. URL::getBase() .'anuncio/'.$urlAnuncio .'" class="notices-font-style" title="Endereço do anúncio" style="float:right; margin-top:15px;">'.$bairroAnuncio.', '.$cidadeAnuncio.' - '.$uf.'</a>
					</span>
				
			</li></a>
			';
		}
		
		$sql_buscaBairro = 'SELECT anuncio.*, uf.uf, clientes.*
							FROM sds_anuncio anuncio, sds_estados uf, sds_clientes clientes
							WHERE anuncio.bairroAnuncio LIKE :bairroAnuncio AND uf.uf = :estadoAnuncio AND uf.id = anuncio.estadoAnuncio 
							AND anuncio.idCliente_fk = clientes.clienteId AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							WHERE clientes.status = :statusDesativado) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
							WHERE clientes.status = :statusAguardando) AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes
					    	WHERE clientes.status = :statusPendente) ORDER BY anuncio.precoAnuncio DESC';

		try{
			
			$query_buscaBairro = $connect->prepare($sql_buscaBairro);
			$query_buscaBairro->bindValue(':bairroAnuncio', '%'.$bairroAnuncio.'%' ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':estadoAnuncio', $estadoAnuncio ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusPendente', $statusPendente ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusAguardando', $statusAguardando ,PDO::PARAM_STR);
			$query_buscaBairro->bindValue(':statusDesativado', $statusDesativado ,PDO::PARAM_STR);
			$query_buscaBairro->execute();

			$resultado_contar = $query_buscaBairro->rowCount(PDO::FETCH_ASSOC);
			
			
		}catch(PDOException $erro_buscaBairro){
			echo 'Erro ao consultar por bairro';
		}
		
		$paginas = ceil($resultado_contar/$maximo);
		$links = '4'; //QUANTIDADE DE LINKS NO PAGINATOR
		
		if($paginas > 1){
		
		?>
				
				<div class="pagination">
					<center>
						<ul>
							<li><a href="index.php?pg=page&estado=<?php echo $estadoLink; ?>&cidade=<?php echo $cidadeAnuncio; ?>&amp;pag=1">Primeira</a></li>
							
							<?php
								for ($i = $pag-$links; $i <= $pag-1; $i++){
								if ($i <= 0){
								}else{
									echo"<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
								}
								}echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$pag&nbsp;&nbsp;&nbsp;</a></li>";	
								for($i = $pag +1; $i <= $pag+$links; $i++){
									if($i > $paginas){
									}else{
									echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;</li>";
									}
								}
								echo "<li><a href=\"index.php?pg=page&estado=$estadoLink&cidade=$cidadeAnuncio&amp;pag=$paginas\">Última página</a></li>&nbsp;&nbsp;&nbsp";
							?>
						</ul>
					</center>
				</div>
				<?php				
				}
	}
}

?>						