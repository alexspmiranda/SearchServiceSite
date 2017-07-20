<?php
function sds_insereDadosAnuncio($idCliente, $url,  $anuncioNome,$anuncioTitulo,$anuncioSite,$anuncioCategoria,$anuncioPreco, $anuncioEndereco,$anuncioComplemento,$anuncioNum,
								$anuncioCep, $anuncioBairro,$anuncioCidade, $anuncioEstado,$anuncioTelefone,$anuncioTelefone2,$anuncioTelefone3,$anuncioDescricao,
								$notificadoAnuncio, $anuncioTituloUrl){
	
	include "../Connections/config.php";
	
	try{					
		$sql_cadastraAnuncio  = 'INSERT INTO sds_anuncio (idCliente_fk, linkPessoalAnuncio, urlAnuncio, nomeFantasiaAnuncio, tituloAnuncio, categoriaAnuncio, precoAnuncio, descricaoAnuncio, 
								dataCadastroAnuncio, enderecoAnuncio, complementoAnuncio, cepAnuncio, bairroAnuncio, cidadeAnuncio, estadoAnuncio,
								telefoneAnuncio, telefoneAnuncio2, telefoneAnuncio3, siteAnuncio, notificadoAnuncio) ';
		$sql_cadastraAnuncio .= 'VALUES (:idCliente_fk, :url, :anuncioTituloUrl, :nomeAnuncio, :tituloAnuncio, :categoriaAnuncio, :precoAnuncio, :descricaoAnuncio, :dataCadastroAnuncio,
								:anuncioEndereco, :complementoAnuncio, :cepAnuncio, :anuncioBairro, :anuncioCidade, :anuncioEstado, :anuncioTelefone,
								:anuncioTelefone2, :anuncioTelefone3, :anuncioSite, :notificadoAnuncio)';
		
		$query_cadastraAnuncio = $connect->prepare($sql_cadastraAnuncio);
		$query_cadastraAnuncio->bindValue(':url', $url, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioTituloUrl', $anuncioTituloUrl, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':idCliente_fk', $idCliente, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':nomeAnuncio', $anuncioNome, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':tituloAnuncio', $anuncioTitulo, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioSite', $anuncioSite, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':categoriaAnuncio', $anuncioCategoria, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':precoAnuncio', $anuncioPreco, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':descricaoAnuncio', $anuncioDescricao, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':dataCadastroAnuncio', $anuncioDataCadastro, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioEndereco', $anuncioEndereco, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':complementoAnuncio', $anuncioComplemento, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':cepAnuncio', $anuncioCep, PDO::PARAM_STR);				
		$query_cadastraAnuncio->bindValue(':anuncioBairro', $anuncioBairro, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioCidade', $anuncioCidade, PDO::PARAM_STR);	
		$query_cadastraAnuncio->bindValue(':anuncioEstado', $anuncioEstado, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioTelefone', $anuncioTelefone, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioTelefone2', $anuncioTelefone2, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioTelefone3', $anuncioTelefone3, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':notificadoAnuncio', $notificadoAnuncio, PDO::PARAM_STR);
		$query_cadastraAnuncio->execute();
		
		$cadastradoComSucesso = 'Dados salvos com sucesso';
		
		// echo '<script language="javascript">';
		// echo '$(window).load(function() {
		// 		alert("'.$cadastradoComSucesso.'")
		// })';
		// echo '</script>'; 
		
		$status = 'aguardando';
		$sql_publicaAnuncio = 'UPDATE sds_clientes SET status = :status WHERE clienteId = :idCliente';
		
		try{
			
			$query_publicaAnuncio = $connect->prepare($sql_publicaAnuncio);
			$query_publicaAnuncio->bindValue(':status', $status, PDO::PARAM_STR);
			$query_publicaAnuncio->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
			$query_publicaAnuncio->execute();
			
			
		}catch(PDOException $erro_atualizarStatus){
			echo "Erro ao atualizar status";	
		}
		
	}catch(PDOException $erro_cadastrar){
		echo 'Não possível cadastrar os dados.';
	}
}

function sds_insertPatrocinados($idClientePatrocinado_fk, $codigoPagamento){
	
	include "../Connections/config.php";
	
	try{
		$statusPagamento = 'em processamento';
		$dataPagamento = date('Y-m-d H:i:s');
		$notificadoPagamento = '0';
		
		$sql_confirmaPagamento  = 'INSERT INTO sds_pagamento (idClientePatrocinado_fk, codigoPagamento, dataPagamento, statusPagamento, notificadoPagamento) ';
		$sql_confirmaPagamento .= 'VALUES (:idClientePatrocinado_fk , :codigoPagamento, :dataPagamento, :statusPagamento, :notificadoPagamento) ';
		
		$query_confirmaPagamento = $connect->prepare($sql_confirmaPagamento);
		$query_confirmaPagamento->bindValue(':idClientePatrocinado_fk', $idClientePatrocinado_fk , PDO::PARAM_STR);
		$query_confirmaPagamento->bindValue(':codigoPagamento', $codigoPagamento , PDO::PARAM_STR);
		$query_confirmaPagamento->bindValue(':dataPagamento', $dataPagamento , PDO::PARAM_STR);
		$query_confirmaPagamento->bindValue(':statusPagamento', $statusPagamento , PDO::PARAM_STR);
		$query_confirmaPagamento->bindValue(':notificadoPagamento', $notificadoPagamento , PDO::PARAM_STR);
		$query_confirmaPagamento->execute();
		
		$confirmadoComSucesso = 'Código enviado com sucesso.';
		
	}catch(PDOException $erro_confirmarPagamento){
		echo "Não foi possível enviar a mensagem de confirmação do pagamento!";
	}
	
	return  $confirmadoComSucesso;	
}


function insert_img($idAnuncio, $id){

	include "../Connections/config.php";

	$caminho = '1';

	try{
		$sql_validaUrl = "SELECT midia.* FROM sds_midia midia WHERE idAnuncio_fk = :idAnuncio AND nomeFoto = :nomeFoto";
		 
		$query_validaUrl = $connect->prepare($sql_validaUrl);
		$query_validaUrl->bindValue(':idAnuncio', $idAnuncio , PDO::PARAM_STR);
		$query_validaUrl->bindValue(':nomeFoto', $id , PDO::PARAM_STR);
		$query_validaUrl->execute();
		 
		$resultado_validaUrl = $query_validaUrl->rowCount(PDO::FETCH_ASSOC);

		if($resultado_validaUrl == 0){

			try{
				$sql_insertImg  = 'INSERT INTO sds_midia(idAnuncio_fk, caminhoFoto, nomeFoto) ';
				$sql_insertImg .= 'VALUES (:idAnuncio, :caminhoFoto, :nomeFoto) ';
				
				$query_insertImg = $connect->prepare($sql_insertImg);
				$query_insertImg->bindValue(':idAnuncio', $idAnuncio , PDO::PARAM_STR);
				$query_insertImg->bindValue(':caminhoFoto', $caminho , PDO::PARAM_STR);
				$query_insertImg->bindValue(':nomeFoto', $id , PDO::PARAM_STR);
				$query_insertImg->execute();
			}catch(PDOException $erro_salvarImagem){
				echo 'Erro ao salvar Imagem';
			}
		}

	}catch(PDOException $erro_salvarImagemSelecionar){
		echo 'Erro ao salvar ou selecionar imagens';
	}
}

function insere_descricaoFoto($idAnuncio, $tituloFoto, $descricaoFoto, $id){

	include "../Connections/config.php";

	try{
		$sql_insertImg  = 'UPDATE sds_midia SET  tituloFoto = :tituloFoto, descFoto = :descricaoFoto WHERE idAnuncio_fk = :idAnuncio AND nomeFoto = :nomeFoto';
				
		$query_insertImg = $connect->prepare($sql_insertImg);
		$query_insertImg->bindValue(':idAnuncio', $idAnuncio , PDO::PARAM_STR);
		$query_insertImg->bindValue(':nomeFoto', $id , PDO::PARAM_STR);
		$query_insertImg->bindValue(':tituloFoto', $tituloFoto , PDO::PARAM_STR);
		$query_insertImg->bindValue(':descricaoFoto', $descricaoFoto , PDO::PARAM_STR);
		$query_insertImg->execute();

		if($id == '1'){
			echo '<div class="container"><div class="alert alert-info" role="alert">Upload do título e da legenda da primeira foto efetuado com sucesso! </div></div>';
		}elseif($id == '2'){
			echo '<div class="container"><div class="alert alert-info" role="alert">Upload do título e da legenda da segunda foto efetuado com sucesso! </div></div>';
		}elseif($id == '3'){
			echo '<div class="container"><div class="alert alert-info" role="alert">Upload do título e da legenda da terceira foto efetuado com sucesso! </div></div>';
		}elseif($id == '4'){
			echo '<div class="container"><div class="alert alert-info" role="alert">Upload do título e da legenda da quarta foto efetuado com sucesso! </div></div>';
		}elseif($id == '5'){
			echo '<div class="container"><div class="alert alert-info" role="alert">Upload do título e da legenda da quinta foto efetuado com sucesso! </div></div>';
		}

	}catch(PDOException $erro_salvarImagem){
		echo 'Erro ao salvar legenda da imagem '. $id;
	}
}

function sds_cadastrafbid($nomef, $fbid){
	include "../Connections/config.php";


	$sql_verifica_fbid = 'SELECT fbid FROM sds_clientes WHERE fbid = :fbid;';
						
	try{
		$query_verifica_fbid = $connect->prepare($sql_verifica_fbid);
		$query_verifica_fbid->bindValue(':fbid', $fbid , PDO::PARAM_STR);
		$query_verifica_fbid->execute();
		
		$res_verifica_fbid = $query_verifica_fbid->rowCount(PDO::FETCH_ASSOC);

	}catch(PDOException $erro_verifica_email){
		echo "Erro ao verificar fbid";
	}

	if($res_verifica_fbid == 0){

		$criadoEm = date('Y-m-d H:i:s');
		$clienteNivel = 'cliente';
		$statusUsuario = 'pendente';
		$termosPrivacidade = 'aceito';

	    $sql = 'INSERT INTO sds_clientes(nome, fbid, criadoEm, nivelDeAcesso, status, termosPrivacidade) 
	    		VALUES(:nome, :fbid, :criadoEm, :nivelDeAcesso, :status, :termosPrivacidade)';

	    try{

	        $query_sqlfbid = $connect->prepare($sql);
	        $query_sqlfbid->bindValue(':nome', $nomef, PDO::PARAM_STR);
	        $query_sqlfbid->bindValue(':fbid', $fbid, PDO::PARAM_STR);
	        $query_sqlfbid->bindValue(':criadoEm', $criadoEm,PDO::PARAM_STR);
			$query_sqlfbid->bindValue(':nivelDeAcesso', $clienteNivel,PDO::PARAM_STR);
			$query_sqlfbid->bindValue(':termosPrivacidade', $termosPrivacidade,PDO::PARAM_STR);
			$query_sqlfbid->bindValue(':status', $statusUsuario,PDO::PARAM_STR);
	        $query_sqlfbid->execute();
	                    
	    }catch(PDOException $erro_consultarCadastro){
	        echo 'Erro ao inserir fbid';
	    }
	}
}

?>