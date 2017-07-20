<?php

function sds_selectPatrocinadosBasic($categoriaAnuncio, $idCliente){
	
	include "Connections/config.php";
	
	$status = 'patrocinado';
	$statusTopo = 'topo';
	$statusBasic = 'basico';	
	$sql_patrocinadosBasic = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio
							  WHERE anuncio.idCliente_fk = clientes.clienteId AND clientes.status = :status
							  AND anuncio.categoriaAnuncio = :categoriaAnuncio AND clientes.plano NOT IN (SELECT clientes.plano FROM sds_clientes clientes
							  WHERE clientes.plano = :statusTopo) AND clientes.plano NOT IN (SELECT clientes.plano FROM sds_clientes clientes
							  WHERE clientes.plano = :statusBasic) AND anuncio.idCliente_fk NOT IN (SELECT anuncio.idCliente_fk FROM sds_anuncio anuncio
							  WHERE anuncio.idCliente_fk = :idCliente)
							  ORDER BY RAND() LIMIT 2';
	
	try{
		$query_patrocinadosBasic = $connect->prepare($sql_patrocinadosBasic);
		$query_patrocinadosBasic->bindValue(':status', $status , PDO::PARAM_STR);
		$query_patrocinadosBasic->bindValue(':statusTopo', $statusTopo , PDO::PARAM_STR);
		$query_patrocinadosBasic->bindValue(':statusBasic', $statusBasic , PDO::PARAM_STR);
		$query_patrocinadosBasic->bindValue(':categoriaAnuncio', $categoriaAnuncio , PDO::PARAM_STR);
		$query_patrocinadosBasic->bindValue(':idCliente', $idCliente , PDO::PARAM_STR);
		$query_patrocinadosBasic->execute();
		
		$resultado_patrocinadosBasic = $query_patrocinadosBasic->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_patrocinadoBasic){
		echo 'Erro ao buscar patrocinados basic';
	}
	
	return $resultado_patrocinadosBasic;

}

function sds_selectPatrocinadosBasicRestante($idCliente, $tituloAnuncio, $estadoAnuncio, $limiteCategorias){
	
	include "Connections/config.php";
	
	$status = 'patrocinado';
	$statusTopo = 'topo';
	$statusBasic = 'basico';
	
	$sql_patrocinadosBasicRestante = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio
							  		WHERE anuncio.idCliente_fk = clientes.clienteId AND clientes.status = :status
							  		AND clientes.plano NOT IN (SELECT clientes.plano FROM sds_clientes clientes
							  		WHERE clientes.plano = :statusTopo) AND clientes.plano NOT IN (SELECT clientes.plano FROM sds_clientes clientes
							  		WHERE clientes.plano = :statusBasic) AND anuncio.idCliente_fk NOT IN (SELECT anuncio.idCliente_fk FROM sds_anuncio anuncio
							  		WHERE anuncio.idCliente_fk = :idCliente) AND anuncio.tituloAnuncio NOT IN (SELECT anuncio.tituloAnuncio FROM sds_anuncio anuncio
							  		WHERE anuncio.tituloAnuncio = :tituloAnuncio) AND anuncio.estadoAnuncio = :estadoAnuncio
							  		ORDER BY RAND() LIMIT '.$limiteCategorias;
	
	try{
		$query_patrocinadosBasicRestante = $connect->prepare($sql_patrocinadosBasicRestante);
		$query_patrocinadosBasicRestante->bindValue(':status', $status , PDO::PARAM_STR);
		$query_patrocinadosBasicRestante->bindValue(':statusTopo', $statusTopo , PDO::PARAM_STR);
		$query_patrocinadosBasicRestante->bindValue(':statusBasic', $statusBasic , PDO::PARAM_STR);
		$query_patrocinadosBasicRestante->bindValue(':idCliente', $idCliente , PDO::PARAM_STR);
		$query_patrocinadosBasicRestante->bindValue(':tituloAnuncio', $tituloAnuncio , PDO::PARAM_STR);
		$query_patrocinadosBasicRestante->bindValue(':estadoAnuncio', $estadoAnuncio , PDO::PARAM_STR);
		$query_patrocinadosBasicRestante->execute();
		
		$resultado_patrocinadosBasicRestante = $query_patrocinadosBasicRestante->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_patrocinadoBasicRestante){
		echo 'Erro ao buscar patrocinados basic restante';
	}	
	
	return $resultado_patrocinadosBasicRestante;
}

function sds_selectVerificaStatus($idCliente){
	
	include "Connections/config.php";
	
	$sql_verificaStatus = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio
						   WHERE clientes.clienteId = :idCliente AND clientes.clienteId = anuncio.idCliente_fk';
	
	try{		
		$query_verificaStatus = $connect->prepare($sql_verificaStatus);
		$query_verificaStatus->bindValue(':idCliente', $idCliente , PDO::PARAM_STR);
		$query_verificaStatus->execute();
		
		$resultado_verificaStatus = $query_verificaStatus->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_verificaStatus){
		echo 'Não foi possível selecionar o perfil';
	}
	
	return $resultado_verificaStatus;
		
}

function sds_selectGetSingle($idCliente){
	
	include "Connections/config.php";
	
	$sql_getSingle = 'SELECT clientes.*, anuncios.*, uf.uf FROM sds_anuncio anuncios, sds_clientes clientes, sds_estados uf
					  WHERE idCliente_FK = :idCliente AND anuncios.estadoAnuncio = uf.id
					  AND anuncios.idCliente_fk = clientes.clienteId';
	
	try{		
		$query_getSingle = $connect->prepare($sql_getSingle);
		$query_getSingle->bindValue(':idCliente', $idCliente , PDO::PARAM_STR);
		$query_getSingle->execute();
		
		$resultado_getSingle = $query_getSingle->fetchAll(PDO::FETCH_ASSOC);
		$resultado_getSingleCont = $query_getSingle->rowCount(PDO::FETCH_ASSOC);

	}catch(PDOException $erro_getSingle){
		echo 'Não foi possível selecionar o perfil';
	}

	return $resultado_getSingle;
}

function sds_selectPatrocinadosSingleFooter($categoriaAnuncio){
	
	include "Connections/config.php";
	
	$sql_buscaAnunciosRelacionados = 'SELECT clientes.*, anuncio.* FROM sds_anuncio anuncio, sds_clientes clientes 
									  WHERE anuncio.idCliente_fk = clientes.clienteId AND categoriaAnuncio = :categoriaAnuncio 
									  ORDER BY RAND() LIMIT 4';
	
	try{
		$query_buscaAnunciosRelacionados = $connect->prepare($sql_buscaAnunciosRelacionados);
		$query_buscaAnunciosRelacionados->bindValue(':categoriaAnuncio', $categoriaAnuncio , PDO::PARAM_STR);
		$query_buscaAnunciosRelacionados->execute();
		
		$resultado_buscaAnunciosRelacionados = $query_buscaAnunciosRelacionados->fetchAll(PDO::FETCH_ASSOC);										
	
	}catch(PDOException $erro_buscaAnunciosRelacionados){
		echo 'Não foi possível selecionar o perfil';
	}
	
	return $resultado_buscaAnunciosRelacionados;

}

function sds_selectPatrocinadosSingleFooterRelacionados($categoriaAnuncio, $limiteCategorias){
	
	include "Connections/config.php";
	
	$sql_buscaAnuncios = 'SELECT clientes.*, anuncio.* FROM sds_anuncio anuncio, sds_clientes clientes 
						  WHERE anuncio.idCliente_fk = clientes.clienteId AND categoriaAnuncio != :categoriaAnuncio 
						  ORDER BY RAND() LIMIT '.$limiteCategorias;
	try{	
		$query_buscaAnuncios = $connect->prepare($sql_buscaAnuncios);
		$query_buscaAnuncios->bindValue(':categoriaAnuncio', $categoriaAnuncio , PDO::PARAM_STR);
		$query_buscaAnuncios->execute();
		
		$resultado_buscaAnuncios = $query_buscaAnuncios->fetchAll(PDO::FETCH_ASSOC);
		$resultado_cont = $query_buscaAnuncios->rowCount(PDO::FETCH_ASSOC);
			
			
	}catch(PDOException $erro_buscaAnuncios){
		echo 'Não foi possível selecionar o perfil de outras categorias';
	}

	return $resultado_buscaAnuncios;
	
}


function sds_selectAvaliacao($idCliente, $idAvaliador){
	
	include "Connections/config.php";
	
	$sql_buscaComentarios = 'SELECT avaliacao.* FROM sds_avaliacao avaliacao
                             WHERE avaliacao.idCliente_fk = :idCliente_fk AND avaliacao.idAvaliador = :idAvaliador';
	try{	
		$query_buscaComentarios = $connect->prepare($sql_buscaComentarios);
		$query_buscaComentarios->bindValue(':idCliente_fk', $idCliente , PDO::PARAM_STR);
		$query_buscaComentarios->bindValue(':idAvaliador', $idAvaliador , PDO::PARAM_STR);
		$query_buscaComentarios->execute();
		
		$resultado_buscaComentarios = $query_buscaComentarios->fetchAll(PDO::FETCH_ASSOC);
			
	}catch(PDOException $erro_buscaComentarios){
		echo 'Não foi possível verificar se o comentario existe';
	}

	return $resultado_buscaComentarios;
	
}

function sds_buscaComentarios($idCliente){

	include "Connections/config.php";
	
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

function sds_selectVotosContagem($idCliente){
	
	include "Connections/config.php";
	
	$sql_rate = " SELECT votos FROM sds_avaliacao WHERE idCliente_fk = ".$idCliente;
								
	try{
		$query = $connect->prepare($sql_rate);
		$query->execute();

		$resultado_votacao = $query->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_classificar){
		echo 'Erro ao classificar';
	}	
	
	return $resultado_votacao;
}

function sds_selectIp(){

	$variables = array(REMOTE_ADDR,
	HTTP_X_FORWARDED_FOR,
	HTTP_X_FORWARDED,
	HTTP_FORWARDED_FOR,
	HTTP_FORWARDED,
	HTTP_X_COMING_,
	HTTP_COMING_,
	HTTP_CLIENT_IP);
	
	$return = Unknown;
	
	foreach ($variables as $variable){
		if (isset($_SERVER[$variable])){
			$return.= $_SERVER[$variable]." - ";
		}
	}
	
	return $return;	
}

function sds_selectVerificaVisita($idCliente, $ip){

	include "Connections/config.php";
	
	$sql_verificaVisitas = 'SELECT * FROM sds_visitas WHERE idCliente_fk = :idCliente AND ipVisitante = :ip';
	
	try{
		$query_verificaVisitas = $connect->prepare($sql_verificaVisitas);
		$query_verificaVisitas->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
		$query_verificaVisitas->bindValue(':ip', $ip, PDO::PARAM_STR);
		$query_verificaVisitas->execute();
		
		$resultado_verificaVisitas = $query_verificaVisitas->rowCount(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_verificaVisita){
		echo 'Erro ao verificar visitantes';	
	}

	if($resultado_verificaVisitas == '0'){
		sds_insertNumVisitas($idCliente, $ip);
	}elseif($resultado_verificaVisitas >= 1){
		return false;
	}
}

function sds_buscaId($url){

	include "Connections/config.php";
	$sql_verificaVisitas = 'SELECT idCliente_FK FROM sds_anuncio WHERE urlAnuncio = :url';
	
	try{
		$query_buscaId = $connect->prepare($sql_verificaVisitas);
		$query_buscaId->bindValue(':url', $url, PDO::PARAM_STR);
		$query_buscaId->execute();
		
		$resultado_buscaId = $query_buscaId->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_verificaVisita){
		echo 'Erro ao verificar visitantes';	
	}
	
	foreach ($resultado_buscaId as $res_buscaId) {
		$idCliente = $res_buscaId['idCliente_FK'];
	}

	return $idCliente;

}

function select_descricaoFotos($idAnuncio){
	 include "Connections/config.php";
	 
	 $sql_buscaImagens = "SELECT * FROM sds_midia WHERE idAnuncio_fk = :idAnuncio";
	 
	 $query_buscaImagens = $connect->prepare($sql_buscaImagens);
	 $query_buscaImagens->bindValue(':idAnuncio', $idAnuncio, PDO::PARAM_STR);
	 $query_buscaImagens->execute();
	 
	 $resultado_buscaImagens = $query_buscaImagens->fetchAll(PDO::FETCH_ASSOC);
	  
	 return $resultado_buscaImagens;		
}

?>