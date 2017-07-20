<?php

function sds_patrocinadosPage($estadoAnuncio){
	
	include "Connections/config.php";
	
	$sql_buscarPatrocinados  = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio, sds_estados uf
							    WHERE clientes.clienteId = anuncio.idCliente_fk AND anuncio.estadoAnuncio = uf.id AND uf.uf = :estadoAnuncio
								AND clientes.status = "patrocinado"
								AND clientes.plano NOT IN (SELECT clientes.plano FROM sds_clientes clientes WHERE clientes.plano = "topo")
								AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes WHERE clientes.status = "desativado" OR clientes.status = "aguardando")
								ORDER BY RAND() LIMIT 4';
		
	try{
		$query_buscarPatrocinados = $connect->prepare($sql_buscarPatrocinados);
		$query_buscarPatrocinados->bindValue(':estadoAnuncio', $estadoAnuncio , PDO::PARAM_STR);
		$query_buscarPatrocinados->execute();
	
		$resultado_buscarPatrocinados = $query_buscarPatrocinados->fetchAll(PDO::FETCH_ASSOC);
	
	}catch(PDOException $erro_buscarPatrocinados){
		echo 'Não foi possível buscar clientes patrocinados';
	}
	
	 return $resultado_buscarPatrocinados;
	
}

function sds_buscaPatrocinadosPorCidade($cidadeAnuncio, $estadoAnuncio){
	
	include "Connections/config.php";
	
	$sql_buscarPatrocinados  = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio, sds_estados uf
							    WHERE clientes.clienteId = anuncio.idCliente_fk AND anuncio.estadoAnuncio = uf.id AND uf.uf = :estadoAnuncio
								AND anuncio.cidadeAnuncio = :cidadeAnuncio AND clientes.plano NOT IN 
							   (SELECT clientes.plano FROM sds_clientes clientes WHERE clientes.plano = "topo")
							   	AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes WHERE clientes.status = "desativado" OR clientes.status = "aguardando")
								ORDER BY RAND() LIMIT 4';
		
	try{
		$query_buscarPatrocinados = $connect->prepare($sql_buscarPatrocinados);
		$query_buscarPatrocinados->bindValue(':estadoAnuncio', $estadoAnuncio , PDO::PARAM_STR);
		$query_buscarPatrocinados->bindValue(':cidadeAnuncio', $cidadeAnuncio , PDO::PARAM_STR);
		$query_buscarPatrocinados->execute();
		
		$resultado_buscarPatrocinadosPorCidade = $query_buscarPatrocinados->fetchAll(PDO::FETCH_ASSOC);
		$resultado_buscarPatrocinadosPorCidadeCont = $query_buscarPatrocinados->rowCount(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_buscarPatrocinados)
	{
		echo 'Não foi possível buscar clientes patrocinados';
	}
	
	return $resultado_buscarPatrocinadosPorCidade;
		
}

function sds_buscaPatrocinadosPorCategoria($categoriaAnuncio, $estadoAnuncio){
	
	include "Connections/config.php";
	
	$sql_buscarPatrocinadosPorCategoria  = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio, sds_estados uf
							    		   	WHERE clientes.clienteId = anuncio.idCliente_fk AND anuncio.estadoAnuncio = uf.id AND uf.uf = :estadoAnuncio
										   	AND anuncio.categoriaAnuncio LIKE :categoriaAnuncio AND clientes.plano NOT IN 
							              	(SELECT clientes.plano FROM sds_clientes clientes WHERE clientes.plano = "topo")
										  	AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes WHERE clientes.status = "desativado" OR clientes.status = "aguardando")
										  	ORDER BY RAND() LIMIT 4';
		
	try{
		$query_buscarPatrocinadosPorCategoria = $connect->prepare($sql_buscarPatrocinadosPorCategoria);
		$query_buscarPatrocinadosPorCategoria->bindValue(':estadoAnuncio', $estadoAnuncio , PDO::PARAM_STR);
		$query_buscarPatrocinadosPorCategoria->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%' , PDO::PARAM_STR);
		$query_buscarPatrocinadosPorCategoria->execute();
		
		$resultado_buscarPatrocinadosPorCategoria = $query_buscarPatrocinadosPorCategoria->fetchAll(PDO::FETCH_ASSOC);

	}catch(PDOException $erro_buscarPatrocinados)
	{
		echo 'Não foi possível buscar clientes patrocinados';
	}
	
	return $resultado_buscarPatrocinadosPorCategoria;
		
}

function sds_buscaPatrocinadosPorCategoriaECidade($categoriaAnuncio, $cidadeAnuncio, $estadoAnuncio){
		
	include "Connections/config.php";
	
	$sql_buscarPatrocinadosPorCategoria  = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio, sds_estados uf
							    		   	WHERE clientes.clienteId = anuncio.idCliente_fk AND anuncio.estadoAnuncio = uf.id AND uf.uf = :estadoAnuncio
										   	AND anuncio.categoriaAnuncio LIKE :categoriaAnuncio AND anuncio.cidadeAnuncio = :cidadeAnuncio AND clientes.plano NOT IN 
							              	(SELECT clientes.plano FROM sds_clientes clientes WHERE clientes.plano = "topo")
										  	AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes WHERE clientes.status = "desativado" OR clientes.status = "aguardando")
										   	ORDER BY RAND() LIMIT 4';
		
	try{
		$query_buscarPatrocinadosPorCategoria = $connect->prepare($sql_buscarPatrocinadosPorCategoria);
		$query_buscarPatrocinadosPorCategoria->bindValue(':estadoAnuncio', $estadoAnuncio , PDO::PARAM_STR);
		$query_buscarPatrocinadosPorCategoria->bindValue(':cidadeAnuncio', $cidadeAnuncio , PDO::PARAM_STR);
		$query_buscarPatrocinadosPorCategoria->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%' , PDO::PARAM_STR);
		$query_buscarPatrocinadosPorCategoria->execute();
		
		$resultado_buscarPatrocinadosPorCategoria = $query_buscarPatrocinadosPorCategoria->fetchAll(PDO::FETCH_ASSOC);

	}catch(PDOException $erro_buscarPatrocinados)
	{
		echo 'Não foi possível buscar clientes patrocinados';
	}
	
	return $resultado_buscarPatrocinadosPorCategoria;
		
}

function sds_buscaPatrocinadosRestanteCategoriaECidade($categoriaAnuncio, $cidadeAnuncio ,$estadoAnuncio, $limiteAnuncio){

	include "Connections/config.php";
	
	$sql_buscaPatrocinadosRestantesCategoria  = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio, sds_estados uf
   											     WHERE clientes.clienteId = anuncio.idCliente_fk AND anuncio.estadoAnuncio = uf.id AND uf.uf = :estadoAnuncio
												 AND anuncio.categoriaAnuncio IN (SELECT anuncio.categoriaAnuncio FROM sds_anuncio anuncio 
												 WHERE anuncio.categoriaAnuncio LIKE :categoriaAnuncio) AND anuncio.cidadeAnuncio != :cidadeAnuncio	
											     AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes WHERE clientes.status = "desativado")
												 AND clientes.plano NOT IN (SELECT clientes.plano FROM sds_clientes clientes WHERE clientes.plano = "topo" OR clientes.status = "aguardando")
												 ORDER BY RAND() LIMIT '.$limiteAnuncio;
		
	try{
		$query_buscaPatrocinadosRestantesCategoria = $connect->prepare($sql_buscaPatrocinadosRestantesCategoria);
		$query_buscaPatrocinadosRestantesCategoria->bindValue(':estadoAnuncio', $estadoAnuncio , PDO::PARAM_STR);
		$query_buscaPatrocinadosRestantesCategoria->bindValue(':cidadeAnuncio', $cidadeAnuncio , PDO::PARAM_STR);
		$query_buscaPatrocinadosRestantesCategoria->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%' , PDO::PARAM_STR);
		$query_buscaPatrocinadosRestantesCategoria->execute();
		
		$resultado_buscaPatrocinadosRestantesCategoria 	= $query_buscaPatrocinadosRestantesCategoria->fetchAll(PDO::FETCH_ASSOC);
				
	}catch(PDOException $erro_buscarPatrocinados)
	{
		echo 'Não foi possível buscar clientes patrocinados';
	}
	
	return $resultado_buscaPatrocinadosRestantesCategoria;
	
}

function sds_buscaPatrocinadosRestanteCategoriaECidadeEEstado($categoriaAnuncio, $estadoAnuncio, $limite){
	
	include "Connections/config.php";
	
	$sql_buscarPatrocinados  = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio, sds_estados uf
							    WHERE clientes.clienteId = anuncio.idCliente_fk AND anuncio.estadoAnuncio = uf.id AND uf.uf = :estadoAnuncio
								AND clientes.status = "patrocinado" AND anuncio.categoriaAnuncio NOT IN (SELECT anuncio.categoriaAnuncio FROM sds_anuncio anuncio 
								WHERE anuncio.categoriaAnuncio LIKE :categoriaAnuncio) AND clientes.plano NOT IN (SELECT clientes.plano FROM sds_clientes clientes 
								WHERE clientes.plano = "topo")
								AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes WHERE clientes.status = "desativado" OR clientes.status = "aguardando")
								ORDER BY RAND() LIMIT '.$limite;
		
	try{
		$query_buscarPatrocinados = $connect->prepare($sql_buscarPatrocinados);
		$query_buscarPatrocinados->bindValue(':estadoAnuncio', $estadoAnuncio , PDO::PARAM_STR);
		$query_buscarPatrocinados->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%' , PDO::PARAM_STR);
		$query_buscarPatrocinados->execute();
		
		$resultado_buscarPatrocinados = $query_buscarPatrocinados->fetchAll(PDO::FETCH_ASSOC);

	}catch(PDOException $erro_buscarPatrocinados)
	{
		echo 'Não foi possível buscar clientes patrocinados';
	}
	
	 return $resultado_buscarPatrocinados;
	
}

function sds_buscaPatrocinadosRestantesCidade($cidadeAnuncio, $estadoAnuncio, $limiteAnuncio){
	
	include "Connections/config.php";
	
	$sql_buscaPatrocinadosRestantesCidade  = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio, sds_estados uf
							    		  	  WHERE clientes.clienteId = anuncio.idCliente_fk AND anuncio.estadoAnuncio = uf.id AND uf.uf = :estadoAnuncio
								          	  AND anuncio.cidadeAnuncio NOT IN (SELECT anuncio.cidadeAnuncio FROM sds_anuncio anuncio
											  WHERE anuncio.cidadeAnuncio = :cidadeAnuncio) AND clientes.plano NOT IN 
							  				 (SELECT clientes.plano FROM sds_clientes clientes WHERE clientes.plano = "topo")
											  AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes WHERE clientes.status = "desativado" OR clientes.status = "aguardando")
											  ORDER BY RAND() LIMIT '.$limiteAnuncio;
		
	try{
		$query_buscaPatrocinadosRestantesCidade = $connect->prepare($sql_buscaPatrocinadosRestantesCidade);
		$query_buscaPatrocinadosRestantesCidade->bindValue(':estadoAnuncio', $estadoAnuncio , PDO::PARAM_STR);
		$query_buscaPatrocinadosRestantesCidade->bindValue(':cidadeAnuncio', $cidadeAnuncio , PDO::PARAM_STR);
		$query_buscaPatrocinadosRestantesCidade->execute();
		
		$resultado_buscaPatrocinadosRestantesCidade 	= $query_buscaPatrocinadosRestantesCidade->fetchAll(PDO::FETCH_ASSOC);

	}catch(PDOException $erro_buscarPatrocinados)
	{
		echo 'Não foi possível buscar clientes patrocinados';
	}
	
	return $resultado_buscaPatrocinadosRestantesCidade;
	
}

function sds_buscaPatrocinadosRestanteCategoria($categoriaAnuncio, $estadoAnuncio, $limiteAnuncio){

	include "Connections/config.php";
	
	$sql_buscaPatrocinadosRestantesCategoria  = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio, sds_estados uf
							    		  	  WHERE clientes.clienteId = anuncio.idCliente_fk AND anuncio.estadoAnuncio = uf.id AND uf.uf = :estadoAnuncio
								          	  AND anuncio.categoriaAnuncio NOT IN (SELECT anuncio.categoriaAnuncio FROM sds_anuncio anuncio
											  WHERE anuncio.categoriaAnuncio LIKE :categoriaAnuncio) AND clientes.plano NOT IN 
							  				 (SELECT clientes.plano FROM sds_clientes clientes WHERE clientes.plano = "topo")
											  AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes WHERE clientes.status = "desativado" OR clientes.status = "aguardando")
											  ORDER BY RAND() LIMIT '.$limiteAnuncio;
		
	try{
		$query_buscaPatrocinadosRestantesCategoria = $connect->prepare($sql_buscaPatrocinadosRestantesCategoria);
		$query_buscaPatrocinadosRestantesCategoria->bindValue(':estadoAnuncio', $estadoAnuncio , PDO::PARAM_STR);
		$query_buscaPatrocinadosRestantesCategoria->bindValue(':categoriaAnuncio', '%'.$categoriaAnuncio.'%' , PDO::PARAM_STR);
		$query_buscaPatrocinadosRestantesCategoria->execute();
		
		$resultado_buscaPatrocinadosRestantesCategoria 	= $query_buscaPatrocinadosRestantesCategoria->fetchAll(PDO::FETCH_ASSOC);
				
	}catch(PDOException $erro_buscarPatrocinados)
	{
		echo 'Não foi possível buscar clientes patrocinados';
	}
	
	return $resultado_buscaPatrocinadosRestantesCategoria;
	
}

function sds_buscaPatrocinadosBrasil($uf, $limiteAnuncio){

	include "Connections/config.php";
	
	$sql_buscaPatrocinadosBrasil  = 'SELECT clientes.*, anuncio.* FROM sds_clientes clientes, sds_anuncio anuncio, sds_estados uf
							     	 WHERE clientes.clienteId = anuncio.idCliente_fk AND anuncio.estadoAnuncio = uf.id
									 AND uf.uf NOT IN (SELECT uf.uf FROM sds_estados uf WHERE uf.uf = :uf) AND clientes.plano NOT IN 
							  		(SELECT clientes.plano FROM sds_clientes clientes WHERE clientes.plano = "topo")
									 AND clientes.status NOT IN (SELECT clientes.status FROM sds_clientes clientes WHERE clientes.status = "desativado" OR clientes.status = "aguardando")
								   	 ORDER BY RAND() LIMIT '.$limiteAnuncio;
		
	try{
		$query_buscaPatrocinadosBrasil = $connect->prepare($sql_buscaPatrocinadosBrasil);
		$query_buscaPatrocinadosBrasil->bindValue(':uf', $uf, PDO::PARAM_STR );
		$query_buscaPatrocinadosBrasil->execute();
		
		$resultado_buscaPatrocinadosBrasil= $query_buscaPatrocinadosBrasil->fetchAll(PDO::FETCH_ASSOC);
				
	}catch(PDOException $erro_buscaPatrocinadosBrasil)
	{
		echo 'Não foi possível buscar clientes patrocinados';
	}
	
	return $resultado_buscaPatrocinadosBrasil;
	
}

?>