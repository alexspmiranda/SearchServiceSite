<?php

function sds_updateDadosCliente($anuncioNome, $anuncioTitulo, $anuncioCategoria, $anuncioPreco, $anuncioEndereco, $anuncioComplemento, $anuncioCep, $anuncioBairro,
								   $anuncioCidade, $anuncioEstado, $anuncioTelefone, $anuncioTelefone2, $anuncioTelefone3, $anuncioDescricao, $anuncioDataCadastro){

	include "../Connections/config.php";

	$sql_cadastraAnuncio  = 'UPDATE sds_anuncio SET idCliente_fk = :idCliente_fk, nomeFantasiaAnuncio = :nomeAnuncio,
							tituloAnuncio = :tituloAnuncio, categoriaAnuncio = :categoriaAnuncio, precoAnuncio = :precoAnuncio,
							descricaoAnuncio = :descricaoAnuncio, enderecoAnuncio = :anuncioEndereco, complementoAnuncio = :anuncioComplemento,
							cepAnuncio = :anuncioCep, bairroAnuncio = :anuncioBairro, cidadeAnuncio = :anuncioCidade, estadoAnuncio = :anuncioEstado, 
							telefoneAnuncio = :anuncioTelefone, telefoneAnuncio2 = :anuncioTelefone2,  telefoneAnuncio3 = :anuncioTelefone3 
							WHERE idCliente_FK = :idCliente_fk';
	
	try{
			
		$query_cadastraAnuncio = $connect->prepare($sql_cadastraAnuncio);
		$query_cadastraAnuncio->bindValue(':idCliente_fk', $idCliente, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':nomeAnuncio', $anuncioNome, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':tituloAnuncio', $anuncioTitulo, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':categoriaAnuncio', $anuncioCategoria, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':precoAnuncio', $anuncioPreco, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':descricaoAnuncio', $anuncioDescricao, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':dataCadastroAnuncio', $anuncioDataCadastro, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioEndereco', $anuncioEndereco, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioComplemento', $anuncioComplemento, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioCep', $anuncioCep, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioBairro', $anuncioBairro, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioCidade', $anuncioCidade, PDO::PARAM_STR);	
		$query_cadastraAnuncio->bindValue(':anuncioEstado', $anuncioEstado, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioTelefone', $anuncioTelefone, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioTelefone2', $anuncioTelefone2, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':anuncioTelefone3', $anuncioTelefone3, PDO::PARAM_STR);				
		$query_cadastraAnuncio->execute();
		
		$executadoComSucesso = 'Cadastrado com sucesso';
			
	}catch(PDOException $erro_cadastrar){
		echo 'Não possível atualizar os dados.';
	}
}

function sds_updateDadosPessoaisCliente($clienteInicioPlano, $clienteVencimentoPlano, $idCliente){
	
	include "../Connections/config.php";

	$sql_cadastraAnuncio  = 'UPDATE sds_clientes SET inicioPatrocinio = :clienteInicioPlano, vencimentoPatrocinio = :clienteVencimentoPlano 
							WHERE clienteId = :idCliente';
	
	try{
			
		$query_cadastraAnuncio = $connect->prepare($sql_cadastraAnuncio);
		$query_cadastraAnuncio->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':clienteInicioPlano', $clienteInicioPlano, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':clienteVencimentoPlano', $clienteVencimentoPlano, PDO::PARAM_STR);			
		$query_cadastraAnuncio->execute();
		
		$executadoComSucesso = 'Cadastrado com sucesso';
			
	}catch(PDOException $erro_cadastrar){
		echo 'Não possível atualizar os dados.';
	}
}

function sds_updateStatusCliente($statusModificacao, $plano, $dataStatusModificacao, $idCliente){
	include "../Connections/config.php";
	
	if($statusModificacao == 'patrocinado'){
		$sql_consultaCadastro = 'SELECT * FROM sds_clientes WHERE clienteId = :idCliente';
	
		try{		
			$query_consultaCadastro = $connect->prepare($sql_consultaCadastro);
			$query_consultaCadastro->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
			$query_consultaCadastro->execute();
			
			$resultado_consultaCadastro = $query_consultaCadastro->fetchAll(PDO::FETCH_ASSOC);
			
		}catch(PDOException $erro_consultarAnuncio){
			echo 'Erro ao consultar';
		}
		
		foreach($resultado_consultaCadastro as $res_consultaCadastro){
			$vencimentoPatrocinio = $res_consultaCadastro['vencimentoPatrocinio'];
		}
		
		if(empty($vencimentoPatrocinio)){
			$inicioPatrocinio = date('Y-m-d H:i:s');
			$dataVencimento = date('Y-m-d H:i:s', strtotime('+'.'1months'));
		
		}else{
			
			if($statusModificacao == 'patrocinado'){
			
				$inicioPatrocinio = date('Y-m-d H:i:s');
			
				$data = date('Y-m-d', strtotime($vencimentoPatrocinio));
				$data = explode('-', $data);
							
				if($data[1] == '12'){
					$data[1] = sprintf("%02d", 1);
					$data[0] += 1;
				}else{
					$data[1] += 1;//mes
					$data[1] =  sprintf("%02d", $data[1]);
					
				}
				
				$dataVencimento = $data[0].'-'.$data[1].'-'.$data[2];
				$dataVencimento = $dataVencimento.' '.date('H:i:s');
				
			}
		}		
	}else{
		
		if($statusModificacao == 'patrocinadoReativar'){
			$resultado_consultaCadastro = sds_selectDadosCliente($idCliente);	
	
		
			foreach($resultado_consultaCadastro as $res_consultaCadastro){
				$clienteInicioPlano = $res_consultaCadastro['inicioPatrocinio'];
				$clienteVencimentoPlano = $res_consultaCadastro['vencimentoPatrocinio'];
				
				$inicioPatrocinio = $clienteInicioPlano;
				$dataVencimento = $clienteVencimentoPlano;
			}
			
			$statusModificacao = 'patrocinado';
			
		}else{
			$dataVencimento = NULL;
			$inicioPatrocinio = NULL;
		}
	}
	
	
	$sql_cadastraAnuncio  = 'UPDATE sds_clientes SET status = :status, plano = :plano, statusAlteradoEm = :dataStatusModificacao,
							 vencimentoPatrocinio = :dataVencimento, inicioPatrocinio = :inicioPatrocinio WHERE clienteId = :idCliente';

	try{			
		$query_cadastraAnuncio = $connect->prepare($sql_cadastraAnuncio);
		$query_cadastraAnuncio->bindValue(':status', $statusModificacao, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':plano', $plano, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':dataStatusModificacao', $dataStatusModificacao, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':dataVencimento', $dataVencimento, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':inicioPatrocinio', $inicioPatrocinio, PDO::PARAM_STR);
		$query_cadastraAnuncio->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);			
		$query_cadastraAnuncio->execute();		

		$cadastradoComSucesso = 'Cliente patrocinado com sucesso';	
		
	}catch(PDOException $erro_cadastrar){
		echo 'Não possível ativar.';
	}	
	
	return $cadastradoComSucesso;
}

?>