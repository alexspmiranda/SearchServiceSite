<?php


function sds_selectPainel($idCliente){
	
	include "../Connections/config.php";	
	
	$sql_selecionaAnuncioPainel = 'SELECT anuncio.* FROM sds_anuncio anuncio WHERE idCliente_fk = :idCliente';
	
	try{
		$query_selecionaAnuncioPainel = $connect->prepare($sql_selecionaAnuncioPainel);
		$query_selecionaAnuncioPainel->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_selecionaAnuncioPainel->execute();
		
		$resultado_selecionaAnuncioPainel = $query_selecionaAnuncioPainel->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_selecionarAnuncioPainel){
		echo 'Erro ao selecionar anúncios para o painel';
	}
				 
	 foreach($resultado_selecionaAnuncioPainel as $res_selecionaAnuncioPainel){
		$idAnuncio 	 = $res_selecionaAnuncioPainel['idAnuncio'];
		$nomeAnuncio = $res_selecionaAnuncioPainel['nomeFantasiaAnuncio'];
		$tituloAnuncio = $res_selecionaAnuncioPainel['tituloAnuncio'];
		$precoAnuncio = $res_selecionaAnuncioPainel['precoAnuncio'];
		$urlAnuncio 		= $res_selecionaAnuncioPainel['urlAnuncio']; 
	 }

	 //$idImagem = listaImagemAnuncioPainel($idAnuncio);
	
	 if(empty($precoAnuncio)){
		$precoAnuncio = 'À negociar';	
	 }else{
		$precoAnuncio = 'R$ '.$precoAnuncio;
	 }
	 
	 return $nomeAnuncio.'::'.$tituloAnuncio.'::'.$precoAnuncio.'::'. $idImagem[0].'::'.$idAnuncio.'::'. $urlAnuncio;
}

function select_descricaoFotos($idAnuncio){
	 include "../Connections/config.php";
	 
	 $sql_buscaImagens = "SELECT * FROM sds_midia WHERE idAnuncio_fk = :idAnuncio";
	 
	 $query_buscaImagens = $connect->prepare($sql_buscaImagens);
	 $query_buscaImagens->bindValue(':idAnuncio', $idAnuncio, PDO::PARAM_STR);
	 $query_buscaImagens->execute();
	 
	 $resultado_buscaImagens = $query_buscaImagens->fetchAll(PDO::FETCH_ASSOC);
	  
	 return $resultado_buscaImagens;		
}

//FUNÇAO QUE LISTA A IMAGEM DO PERFIL
function imagemPerfil($emailAnunciante){
	$imagem_um = 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/'.md5($emailAnunciante).'_image_profile.jpg';

	return $imagem_um;
}

function sds_selectMeusDados($idCliente){
	
	include "../Connections/config.php";

	$sql_consultaCadastro = 'SELECT * FROM sds_clientes WHERE clienteId = :idCliente';

	try{		
		$query_consultaCadastro = $connect->prepare($sql_consultaCadastro);
		$query_consultaCadastro->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_consultaCadastro->execute();
		
		$resultado_consultaCadastro = $query_consultaCadastro->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_consultarAnuncio){
		echo 'Erro ao consultar';
	}
	
	return $resultado_consultaCadastro;
}

function sds_selectAnuncioPainel($idCliente){
	include "../Connections/config.php";
	
	try{
			
			$sql_consultaCadastro = 'SELECT anuncio.* FROM sds_anuncio anuncio, sds_estados estados WHERE anuncio.idCliente_FK = :idCliente';
			
			$query_consultaCadastro = $connect->prepare($sql_consultaCadastro);
			$query_consultaCadastro->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
			$query_consultaCadastro->execute();
			
			$resultado_consultaCadastro = $query_consultaCadastro->fetchAll(PDO::FETCH_ASSOC);
			
		}catch(PDOException $erro_consultarAnuncio){
			echo 'Erro ao consultar';
		}
		
		
		return $resultado_consultaCadastro;
}

function sds_verificaUrl($url){
	include "../Connections/config.php";
	
	try{
			
			$sql_verificaUrl = 'SELECT anuncio.* FROM sds_anuncio anuncio WHERE linkPessoalAnuncio = :url';
			
			$query_verificaUrl = $connect->prepare($sql_verificaUrl);
			$query_verificaUrl->bindValue(':url', $url, PDO::PARAM_STR);
			$query_verificaUrl->execute();
			
			$resultado_verificaUrl = $query_verificaUrl->fetchAll(PDO::FETCH_ASSOC);
			
		}catch(PDOException $erro_consultarAnuncio){
			echo 'Erro ao consultar';
		}
		
		
		return $resultado_verificaUrl;
}

function sds_selectEstados(){
    
	include "../Connections/config.php";
	
	$sql_buscaPorEstado = 'SELECT * FROM sds_estados';
	
	try{
		
		$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
		$query_buscaPorEstado->execute();
		
		$resultado_buscaPorEstado= $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
		
		
	}catch(PDOException $erro_buscaPorEstado){
		echo 'Erro ao consultar por estado';
	}
	
	return $resultado_buscaPorEstado;
}

function sds_selectEstadoUF($estado){
    
	include "../Connections/config.php";
	
	$sql_buscaPorEstado = 'SELECT * FROM sds_estados WHERE id = :id';
	
	try{
		
		$query_buscaPorEstado = $connect->prepare($sql_buscaPorEstado);
		$query_buscaPorEstado->bindValue(':id', $estado, PDO::PARAM_STR);
		$query_buscaPorEstado->execute();
		
		$resultado_buscaPorEstado= $query_buscaPorEstado->fetchAll(PDO::FETCH_ASSOC);
		
		
	}catch(PDOException $erro_buscaPorEstado){
		echo 'Erro ao consultar por estado';
	}
	
	foreach($resultado_buscaPorEstado as $res_estado){
		$estadoUf = $res_estado['uf'];
	}

	return $estadoUf;;
}

function sds_selectDadosPessoaisPatrocinio($idCliente){
	
	include "../Connections/config.php";
	
	try{
		$sql_verificaSituacaoCliente = 'SELECT * FROM sds_clientes WHERE clienteId = :idCliente ORDER BY modificadoEM ASC';
		
		$query_verificaSituacaoCliente = $connect->prepare($sql_verificaSituacaoCliente);
		$query_verificaSituacaoCliente->bindValue('idCliente', $idCliente , PDO::PARAM_STR);
		$query_verificaSituacaoCliente->execute();
		
		$resultado_verificaSituacaoCliente = $query_verificaSituacaoCliente->fetchAll(PDO::FETCH_ASSOC);
	
	}catch(PDOException $erro_verificaSituacaoCliente){
		echo 'Erro ao verificar a situação do cliente';
	}
	
	return $resultado_verificaSituacaoCliente;	
}

function sds_selectAnunciosStatus($statusMensagem){
	
	include "../Connections/config.php";
	
	$sql_clienteAtivos = 'SELECT * FROM sds_clientes WHERE status = :status ORDER BY modificadoEM ASC';
	
	try{
		$query_clienteAtivos = $connect->prepare($sql_clienteAtivos);
		$query_clienteAtivos->bindValue(':status',$statusMensagem,PDO::PARAM_STR);
		$query_clienteAtivos->execute();
		
		$resultado_clienteAtivos = $query_clienteAtivos->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOexception $error_clienteAtivos){
	   echo 'Erro ao selecionar pendentes';
	}
	
	return $resultado_clienteAtivos;
}

function sds_selectPatrocinioVencidos($statusMensagem){
	
	include "../Connections/config.php";
	
	$sql_selectPatrocinioVencidos = 'SELECT * FROM sds_clientes WHERE status = :status AND vencimentoPatrocinio < date(NOW())';
	
	try{
		$query_selectPatrocinioVencidos= $connect->prepare($sql_selectPatrocinioVencidos);
		$query_selectPatrocinioVencidos->bindValue(':status',$statusMensagem,PDO::PARAM_STR);
		$query_selectPatrocinioVencidos->execute();
		
		$resultado_selectPatrocinioVencidos= $query_selectPatrocinioVencidos->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOexception $error_selectPatrocinioVencidos){
	   echo 'Erro ao selecionar pendentes';
	}
	
	return $resultado_selectPatrocinioVencidos;
}

function sds_selectAnunciosDenunciados(){
	
	include "../Connections/config.php";
	
	$sql_clienteDenunciados = 'SELECT clientes.clienteId, clientes.nome, clientes.email, denuncias.idDenuncia, denuncias.denuncia, denuncias.dataDenuncia 
							   FROM sds_clientes clientes, sds_denuncias denuncias 
							   WHERE denuncias.idCliente_fk = clientes.clienteId ORDER BY denuncias.dataDenuncia DESC';
            
	try{
		$query_clienteDenunciados = $connect->prepare($sql_clienteDenunciados);
		$query_clienteDenunciados->execute();
		
		$resultado_clienteDenunciados = $query_clienteDenunciados->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOexception $error_clienteDenunciados){
	   echo 'Erro ao selecionar pendentes';
	}
	
	return $resultado_clienteDenunciados;
}

function sds_selectAnuncioDenunciadoGerenciador($idDenuncia){
	
	include "../Connections/config.php";
	
	$sql_clienteDenunciados = 'SELECT clientes.*, denuncias.* FROM sds_clientes clientes, sds_denuncias denuncias 
							   WHERE denuncias.idCliente_fk = clientes.clienteId AND idDenuncia = :idDenuncia ORDER BY denuncias.dataDenuncia ASC';
            
	try{
		$query_clienteDenunciados = $connect->prepare($sql_clienteDenunciados);
		$query_clienteDenunciados->bindValue(':idDenuncia', $idDenuncia, PDO::PARAM_STR);
		$query_clienteDenunciados->execute();
		
		$resultado_clienteDenunciados = $query_clienteDenunciados->fetchAll(PDO::FETCH_ASSOC);
		$resultado_cont = $query_clienteDenunciados->rowCount(PDO::FETCH_ASSOC);
		
		if($resultado_cont == 0){
				echo '<H4>&nbsp;NÃO HÁ CLIENTES DENUNCIADOS</H4>';
			}
		
	}catch(PDOexception $error_clienteDenunciados){
	   echo 'Erro ao selecionar pendentes';
	}
	
	return $resultado_clienteDenunciados;
}

function sds_selectValidador($validator){

	include "../Connections/config.php";

	$sql_selecionaValidador = 'SELECT status, validador FROM sds_clientes WHERE validador = :validador';

	try{
		
		$query_selecionaValidador = $connect->prepare($sql_selecionaValidador);
		$query_selecionaValidador->bindValue(':validador', $validator, PDO::PARAM_STR);
		$query_selecionaValidador->execute();
		
		$resultado_selecionaValidador = $query_selecionaValidador->fetchAll(PDO::FETCH_ASSOC);

	}catch(PDOException $erro_validar){
		echo 'Erro ao validar';
	}
	
	foreach($resultado_selecionaValidador as $res_selecionaValidador){
		$validadorUser = $res_selecionaValidador['validador'];
		$status = $res_selecionaValidador['status'];
	}

	if($status == 'pendente'){
		return $validadorUser;
	}else{
		return NULL;
	}
}

function sds_selecionaPagamentosPendente(){
	
	include "../Connections/config.php";
	
	$statusPagamento = 'em processamento';
            
	$sql_pagamento = 'SELECT * FROM sds_pagamento WHERE statusPagamento = :statusPagamento ORDER BY dataPagamento ASC';

	try{
		$query_pagamento = $connect->prepare($sql_pagamento);
		$query_pagamento->bindValue(':statusPagamento',$statusPagamento,PDO::PARAM_STR);
		$query_pagamento->execute();
		
		$resultado_pagamento = $query_pagamento->fetchAll(PDO::FETCH_ASSOC);

	}catch(PDOexception $error_pagamento){
	   echo 'Erro ao selecionar pagamentos em processamento';
	}	
	
	return $resultado_pagamento;
}

function sds_selectSearch($contatoNome){
	
	include "../Connections/config.php";

	$sql_searchAdmin = 'SELECT * FROM sds_contato_cliente WHERE nomeUsuario LIKE :contatoNome OR emailUsuario LIKE :contatoEmail';
	$sql_searchAdmin .= ' ORDER BY dataMensagem ASC';

	try{
		$query_searchAdmin = $connect->prepare($sql_searchAdmin);
		$query_searchAdmin->bindValue(':contatoNome','%'.$contatoNome.'%',PDO::PARAM_STR);
		$query_searchAdmin->bindValue(':contatoEmail','%'.$contatoNome.'%',PDO::PARAM_STR);
		$query_searchAdmin->execute();
		
		$resultado_searchAdmin = $query_searchAdmin->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOexception $error_searchAdmin){
	   echo 'Erro ao selecionar e-mails respondidos';
	}
	
	return $resultado_searchAdmin;	
}

function sds_selectEmail($esqueciEmail){
	
	include "../Connections/config.php";

	$sql_verifica_email = 'SELECT email FROM sds_clientes WHERE email = :email;';
							
	try{
		$query_verifica_email = $connect->prepare($sql_verifica_email);
		$query_verifica_email->bindValue(':email', $esqueciEmail , PDO::PARAM_STR);
		$query_verifica_email->execute();
		
		$res_verifica_email = $query_verifica_email->rowCount(PDO::FETCH_ASSOC);

	}catch(PDOException $erro_verifica_email){
		echo "Erro ao verificar email";
	}
	
	return $res_verifica_email;
}

function sds_buscaComentarios($idCliente){

	include "../Connections/config.php";
	
	$sql_buscaComentarios = 'SELECT avaliacao.*, cliente.* FROM sds_avaliacao avaliacao, sds_clientes cliente
                             WHERE avaliacao.idCliente_fk = :idCliente_fk AND cliente.clienteId = avaliacao.idAvaliador
							 ORDER BY avaliacao.dataAvaliacao DESC';
	try{	
		$query_buscaComentarios = $connect->prepare($sql_buscaComentarios);
		$query_buscaComentarios->bindValue(':idCliente_fk', $idCliente , PDO::PARAM_STR);
		$query_buscaComentarios->execute();
		
		$resultado_buscaComentarios = $query_buscaComentarios->fetchAll(PDO::FETCH_ASSOC);
			
	}catch(PDOException $erro_buscaComentarios){
		echo 'Não foi possível buscar os comentarios';
	}

	return $resultado_buscaComentarios;
	
}

function sds_selectVerificaVisitaPainel($idCliente){

	include "../Connections/config.php";
	
	$sql_verificaVisitas = 'SELECT * FROM sds_visitas WHERE idCliente_fk = :idCliente';
	
	try{
		$query_verificaVisitas = $connect->prepare($sql_verificaVisitas);
		$query_verificaVisitas->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_verificaVisitas->execute();
		
		$resultado_verificaVisitas = $query_verificaVisitas->rowCount(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_verificaVisita){
		echo 'Erro ao verificar visitantes';	
	}
	
	return $resultado_verificaVisitas;
}

function sds_selectPriAcesso($idCliente){
	
	include "../Connections/config.php";
	
	$sql_verificaPriAcesso = 'SELECT clientes.modificadoEM FROM sds_clientes clientes WHERE clienteId = :idCliente';
	
	try{
		$query_verificaPriAcesso = $connect->prepare($sql_verificaPriAcesso);
		$query_verificaPriAcesso->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_verificaPriAcesso->execute();
		
		$resultado_verificaPriAcesso = $query_verificaPriAcesso->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_verificaPriAcesso){
		echo 'Não foi possível verificar primeiro acesso';
	}
	
	return $resultado_verificaPriAcesso;

}

?>
