<?php

function sds_atualizaDadosPessoais($idCliente, $clienteNome, $clienteCpf, $clienteSexo, $clienteEmail){
	
	include "../Connections/config.php";
	
	try{
		$clienteNome = strip_tags(trim($_POST['nome-completo']));
		$clienteCpf = strip_tags(trim($_POST['cpf-cnpj']));
		$clienteSexo = strip_tags(trim($_POST['sexo']));
		$clienteEmail = strip_tags(trim($_POST['email']));
			
		$sql_cadastraAnuncio  = 'UPDATE sds_clientes SET nome = :clienteNome, cpfCnpj = :clienteCpf, sexo = :clienteSexo, email = :clienteEmail
								WHERE clienteId = :clienteId';
		
		$query_cadastraAnuncio = $connect->prepare($sql_cadastraAnuncio);
		$query_cadastraAnuncio->bindValue(':clienteId', $idCliente, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':clienteNome', $clienteNome, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':clienteCpf', $clienteCpf, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':clienteSexo', $clienteSexo, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':clienteEmail', $clienteEmail, PDO::PARAM_STR);
		$query_cadastraAnuncio->execute();
		
		$cadastradoComSucesso = 'Dados salvos com sucesso';

		$sql_criaAvaliacao  = 'INSERT INTO sds_avaliacao(idCliente_fk, votos)';
		
		$sql_buscaComentarios = 'SELECT avaliacao.* FROM sds_avaliacao avaliacao
                             WHERE avaliacao.idCliente_fk = :idCliente_fk';
		try{	
			$query_buscaComentarios = $connect->prepare($sql_buscaComentarios);
			$query_buscaComentarios->bindValue(':idCliente_fk', $idCliente , PDO::PARAM_STR);
			$query_buscaComentarios->execute();
			
			$resultado_buscaComentarios = $query_buscaComentarios->rowCount(PDO::FETCH_ASSOC);
				
		}catch(PDOException $erro_buscaComentarios){
			echo 'Não foi possível verificar se o comentario existe';
		}
		
		
		if($resultado_buscaComentarios == 0){
			$sql_criaAvaliacao .= ' VALUES(:idCliente, :votos)';
			
			try{
				$query_criaAvaliacao = $connect->prepare($sql_criaAvaliacao);
				$query_criaAvaliacao->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
				$query_criaAvaliacao->bindValue(':votos', "0", PDO::PARAM_STR);
				$query_criaAvaliacao->execute();
				
			}catch(PDOException $erro_criaAvaliacao)
			{
				echo 'Erro ao criar avaliacoes';
			}
		}
		
		// echo '<script language="javascript">';
		// echo '$(window).load(function() {
		// 		alert("'.$cadastradoComSucesso.'")
		// })';
		// echo '</script>'; 

		
	}catch(PDOException $erro_cadastrar){
		echo 'Não possível atualizar os dados.';
	}
}

function sds_atualizaSenha($idCliente, $senhaAtual, $senhaNova, $senhaNovaRepita){
	
	include "../Connections/config.php";

	try{		
		$sql_verificaSenha = 'SELECT senha FROM sds_clientes WHERE clienteId = :clienteId';
		
		$query_verificaSenha = $connect->prepare($sql_verificaSenha);
		$query_verificaSenha->bindValue(':clienteId', $idCliente, PDO::PARAM_STR);
		$query_verificaSenha->execute();
		
		$resultado_verificaSenha = $query_verificaSenha->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_verificarSenha){
			echo 'Erro ao verificar senha';
	}
	
	foreach($resultado_verificaSenha as $res_verificaSenha);
			$senhaAtualRes = $res_verificaSenha['senha'];
	
	if($senhaAtual == $senhaAtualRes){
		
		if($senhaNova == $senhaNovaRepita){
		
			try{
				$sql_cadastraAnuncio  = 'UPDATE sds_clientes SET senha = :senhaNova WHERE clienteId = :clienteId';
				
				$query_cadastraAnuncio = $connect->prepare($sql_cadastraAnuncio);
				$query_cadastraAnuncio->bindValue(':senhaNova', $senhaNova, PDO::PARAM_STR);
				$query_cadastraAnuncio->bindValue(':clienteId', $idCliente, PDO::PARAM_STR);
				$query_cadastraAnuncio->execute();
				
				$cadastradoComSucesso = 'Atualizado com sucesso';
				
			}catch(PDOException $erro_atualizarSenha){
				echo 'Erro ao atualizar senha';
			}
			
		}else{
			$senhaNovaNaoConfere = 'Sua nova senha não confere';	
		}
	
	}else{
		$senhaAtualErrada = 'Sua senha atual está errada';
	}
	
	if(!empty($cadastradoComSucesso)){
	 	return $cadastradoComSucesso;
	}elseif(!empty($senhaNovaNaoConfere)){
		return $senhaNovaNaoConfere;	
	}elseif(!empty($senhaAtualErrada)){
		return $senhaAtualErrada;		
	}
}

function sds_atualizaDadosAnuncio($idCliente, $url, $anuncioNome,$anuncioTitulo,$anuncioSite,$anuncioCategoria,$anuncioPreco, $anuncioEndereco,$anuncioComplemento,$anuncioNum,
								   $anuncioCep, $anuncioBairro,$anuncioCidade, $anuncioEstado,$anuncioTelefone,$anuncioTelefone2,$anuncioTelefone3,$anuncioDescricao,
								   $notificadoAnuncio, $anuncioTituloUrl){

	include "../Connections/config.php";
	
	try{				
		$sql_cadastraAnuncio  = 'UPDATE sds_anuncio SET idCliente_fk = :idCliente_fk, linkPessoalAnuncio = :url , urlAnuncio = :anuncioTituloUrl, nomeFantasiaAnuncio = :nomeAnuncio,
								tituloAnuncio = :tituloAnuncio, categoriaAnuncio = :categoriaAnuncio, precoAnuncio = :precoAnuncio,
								descricaoAnuncio = :descricaoAnuncio, enderecoAnuncio = :anuncioEndereco, complementoAnuncio = :anuncioComplemento,
								cepAnuncio = :anuncioCep, bairroAnuncio = :anuncioBairro, cidadeAnuncio = :anuncioCidade, estadoAnuncio = :anuncioEstado, 
								telefoneAnuncio = :anuncioTelefone, telefoneAnuncio2 = :anuncioTelefone2,  telefoneAnuncio3 = :anuncioTelefone3, 
								siteAnuncio = :anuncioSite, numAnuncio = :anuncioNum, notificadoAnuncio = :notificadoAnuncio WHERE idCliente_FK = :idCliente_fk';
		
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
		$query_cadastraAnuncio->bindValue(':anuncioComplemento', $anuncioComplemento, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioNum', $anuncioNum, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioCep', $anuncioCep, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioBairro', $anuncioBairro, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioCidade', $anuncioCidade, PDO::PARAM_STR);	
		$query_cadastraAnuncio->bindValue(':anuncioEstado', $anuncioEstado, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioTelefone', $anuncioTelefone, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioTelefone2', $anuncioTelefone2, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioTelefone3', $anuncioTelefone3, PDO::PARAM_STR);				
		$query_cadastraAnuncio->bindValue(':notificadoAnuncio', $notificadoAnuncio, PDO::PARAM_STR);
		$query_cadastraAnuncio->execute();
		
		$cadastradoComSucesso = 'Cadastrado com sucesso!!!';
		
		$status = 'aguardando';
		$sql_publicaAnuncio = 'UPDATE sds_clientes SET status = :status WHERE clienteId = :idCliente';
		
		try{
			
			$query_publicaAnuncio = $connect->prepare($sql_publicaAnuncio);
			$query_publicaAnuncio->bindValue(':status', $status, PDO::PARAM_STR);
			$query_publicaAnuncio->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
			$query_publicaAnuncio->execute();
			
			echo '<div class="container"><div class="alert alert-sucess" role="alert" style="text-align:center;">Cadastrado com sucesso!</div></div>';
			
		}catch(PDOException $erro_atualizarStatus){
			echo "Erro ao atualizar status";	
		}
		
	}catch(PDOException $erro_cadastrar){
		echo 'Não possível atualizar os dados.';
	}				
}	//FECHA ATUALIZAÇÃO DE ANUNCIOS

function sds_validaCadastro($validador){
	
	include "../Connections/config.php";
	
	$status = 'desativado';
	
	$sql_mudaStatus  = 'UPDATE sds_clientes SET status = :status WHERE validador = :validador';
	
	try{
		
		$query_mudaStatus = $connect->prepare($sql_mudaStatus);
		$query_mudaStatus->bindValue(':status', $status ,PDO::PARAM_STR);
		$query_mudaStatus->bindValue(':validador', $validador ,PDO::PARAM_STR);
		$query_mudaStatus->execute();

	}catch(PDOException $erro_mudarStatus){
		echo 'Erro ao validar cadastro';
	}

	return true;
}

function sds_atualizaRespostaDenunciados($mensagemResposta, $idDenuncia){
	
	include "../Connections/config.php";
	
	$dataResposta = date('Y-m-d H:i:s');
				
	$sql_respostaDenuncia = 'UPDATE sds_denuncias SET respostaDenuncia = :mensagemResposta, dataRespostaDenuncia = :dataResposta 
							WHERE idDenuncia = :idDenuncia';
							
	try{
		$query_respostaDenuncia = $connect->prepare($sql_respostaDenuncia);
		$query_respostaDenuncia->bindValue(':idDenuncia', $idDenuncia, PDO::PARAM_STR);
		$query_respostaDenuncia->bindValue(':mensagemResposta', $mensagemResposta, PDO::PARAM_STR);
		$query_respostaDenuncia->bindValue(':dataResposta', $dataResposta, PDO::PARAM_STR);		
		$query_respostaDenuncia->execute();
		
	}catch(PDOException $erro_denunciarResposta){
		echo "Erro ao enviar resposta";
	}
}

function sds_atualizaStatusPagamento($idCliente){
	
	include "../Connections/config.php";
	
	try{
		$statusPagamento = 'confirmado';
			
		$sql_cadastraAnuncio  = 'UPDATE sds_pagamento SET statusPagamento = :statusPagamento
								 WHERE idClientePatrocinado_fk = :idClientePatrocinado_fk';
		
		$query_cadastraAnuncio = $connect->prepare($sql_cadastraAnuncio);
		$query_cadastraAnuncio->bindValue(':idClientePatrocinado_fk', $idCliente, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':statusPagamento', $statusPagamento, PDO::PARAM_STR);				
		$query_cadastraAnuncio->execute();
		
		$cadastradoComSucesso = 'Atualizado com sucesso';
		
	}catch(PDOException $erro_cadastrar){
		echo 'Não possível atualizar os dados.';
	}	
	
	return $cadastradoComSucesso;
}

function sds_updateDesativarConta($idCliente){
	
	include "../Connections/config.php";
	
	$desativarConta = 'desativado';
			
	$sql_desativarConta = 'UPDATE sds_clientes SET status = :status WHERE clienteId= :idCliente';
	
	try{
		
		$query_desativarConta = $connect->prepare($sql_desativarConta);
		$query_desativarConta->bindValue(':status', $desativarConta, PDO::PARAM_STR);
		$query_desativarConta->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_desativarConta->execute();
		
		echo '<meta http-equiv="refresh" content="0">';
		
	}catch(PDOException $erro_desativarCliente){
		echo 'Erro ao desativar cliente';
	}		
}

function sds_updateModifacadoEM($idCliente){
	
	include "../Connections/config.php";
	
	$ultimaEntrada = date('Y-m-d H-i-s');

	$sql_atualiza_ultimaEntrada  = 'UPDATE sds_clientes SET modificadoEM = :modificadoEM WHERE clienteId = :idCliente';
	
	try{
		$sql_atualiza_ultimaEntrada = $connect->prepare($sql_atualiza_ultimaEntrada);
		$sql_atualiza_ultimaEntrada->bindValue(':idCliente', $idCliente ,PDO::PARAM_STR);
		$sql_atualiza_ultimaEntrada->bindValue(':modificadoEM', $ultimaEntrada,PDO::PARAM_STR);
		$sql_atualiza_ultimaEntrada->execute();
		
	}catch(PDOException $erro_atualiza){		
		echo 'Erro ao cadastrar';		
	}	
}

function sds_updatePatrocinioVencido($idClienteVencido){
	include "../Connections/config.php";

	$plano = NULL;
	$dataVencimento = NULL;
	$dataInicio = NULL;
	$sql_atualizaPatrocinioVencido = 'UPDATE sds_clientes SET status = "ativo" , plano = :plano, inicioPatrocinio = :dataInicio, vencimentoPatrocinio = :dataVencimento
									 WHERE clienteId = :idClienteVencido';
	
	$query_atualizaPatrocinioVencido = $connect->prepare($sql_atualizaPatrocinioVencido);
	$query_atualizaPatrocinioVencido->bindValue(':dataInicio', $dataInicio , PDO::PARAM_STR);
	$query_atualizaPatrocinioVencido->bindValue(':dataVencimento', $dataVencimento , PDO::PARAM_STR);
	$query_atualizaPatrocinioVencido->bindValue(':plano', $plano , PDO::PARAM_STR);
	$query_atualizaPatrocinioVencido->bindValue(':idClienteVencido', $idClienteVencido, PDO::PARAM_STR);
	$query_atualizaPatrocinioVencido->execute();
}

function sds_atualizaDadosPessoaisPrimeiroAcesso($fbid, $clienteNome, $clienteEmail){
	
	include "../Connections/config.php";
	$status = 'desativado';

	try{
			
		$sql_cadastraAnuncio  = 'UPDATE sds_clientes SET nome = :clienteNome, email = :clienteEmail, status = :status WHERE fbid = :fbid';
		
		$query_cadastraAnuncio = $connect->prepare($sql_cadastraAnuncio);
		$query_cadastraAnuncio->bindValue(':fbid', $fbid, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':clienteNome', $clienteNome, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':clienteEmail', $clienteEmail, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':status', $status, PDO::PARAM_STR);
		$query_cadastraAnuncio->execute();
		
		$cadastradoComSucesso = 'Cadastrado com sucesso';

		echo '<br><div class="container alert alert-success" role="alert">'.$cadastradoComSucesso .'!!! Você está sendo redirecionado...</div>';
		echo '<meta http-equiv="refresh" content="2; URL=http://saldaodeservicos.com/admin/painel/anuncio"> ';
		exit;

	}catch(PDOException $erro_cadastrar){
		echo 'Não possível atualizar os dados.';
	}
}


?>
