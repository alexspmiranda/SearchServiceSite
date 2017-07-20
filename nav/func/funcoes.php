<?php
function sds_homePostsPatrocinados(){
	
	include "Connections/config.php";

	$statusCliente = 'patrocinado';
	$planoCliente = 'gold';
		
	try{
		
		$sql_consultaAnuncio = 'SELECT clientes.*, anuncio.* FROM sds_anuncio anuncio, sds_clientes clientes
								WHERE status = :statusCliente AND plano = :planoCliente AND anuncio.idCliente_FK = clientes.clienteId
								ORDER BY RAND() LIMIT 4';
		
		$query_consultaAnuncio = $connect->prepare($sql_consultaAnuncio);
		$query_consultaAnuncio->bindValue(':statusCliente', $statusCliente, PDO::PARAM_STR);
		$query_consultaAnuncio->bindValue(':planoCliente', $planoCliente, PDO::PARAM_STR);
		$query_consultaAnuncio->execute();
		
		$resultado_consultaAnuncio = $query_consultaAnuncio->fetchAll(PDO::FETCH_ASSOC);
		
	}catch(PDOException $erro_consultaAnuncios){
		echo "Erro ao consultar anuncio";
	}
	
	return $resultado_consultaAnuncio;
}

function geraNumAleatorio($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
	
	// Caracteres de cada tipo
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	 
	// Variáveis internas
	$retorno = '';
	$caracteres = '';
	 
	// Agrupamos todos os caracteres que poderão ser utilizados
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;
	 
	// Calculamos o total de caracteres possíveis
	$len = strlen($caracteres);
	 
	for ($n = 1; $n <= $tamanho; $n++) {
		// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
		$rand = mt_rand(1, $len);
		// Concatenamos um dos caracteres na variável $retorno
		$retorno .= $caracteres[$rand-1];
	}
 
return $retorno;
}

function dataExata(){
	$data = date('Y-m-d');
	$hora = date('H:i:s');
	
	$hora = explode(":", $hora);
	$horaH = $hora[0]-3;
	$hora = $horaH.':'.$hora[1].':'.$hora[2];
	
	$dataAtual = $data.' '.$hora;
	
	return $dataAtual;
}

function retira_acentos( $texto ) 
{ 
  $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç" 
                     , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" ); 
  $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c" 
                     , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" ); 
  return str_replace( $array1, $array2, $texto ); 
} 


function sds_verificaEstados($estadoAnuncio){
	
	if($estadoAnuncio == 'distrito-federal'){
		$estadoAnuncio = 'Distrito Federal';
	}elseif($estadoAnuncio == 'brasilia' || $estadoAnuncio == 'brasília'){
		$estadoAnuncio = 'Distrito Federal';
	}elseif($estadoAnuncio == 'espirito-santo'){
		$estadoAnuncio = 'Espirito Santo';
	}elseif($estadoAnuncio == 'minas-gerais'){
		$estadoAnuncio = 'Minas Gerais';
	}elseif($estadoAnuncio == 'mato-grosso-do-sul'){
		$estadoAnuncio = 'Mato Grosso Do Sul';
	}elseif($estadoAnuncio == 'mato-grosso'){
		$estadoAnuncio = 'Mato Grosso';
	}elseif($estadoAnuncio == 'rio-de-janeiro'){
		$estadoAnuncio = 'Rio de Janeiro';
	}elseif($estadoAnuncio == 'rio-grande-do-norte'){
		$estadoAnuncio = 'Rio Grande do Norte';
	}elseif($estadoAnuncio == 'rio-grande-do-sul'){
		$estadoAnuncio = 'Rio Grande do Sul';
	}elseif($estadoAnuncio == 'santa-catarina'){
		$estadoAnuncio = 'Santa Catarina';
	}elseif($estadoAnuncio == 'sao-paulo'){
		$estadoAnuncio = 'Sao Paulo';
	}
	
	return $estadoAnuncio;
	
}

function sds_retornaLinkEstado($estadoAnuncio){
	
	if($estadoAnuncio == 'AC'){
		$estadoAnuncio = 'Acre';
	}elseif($estadoAnuncio == 'AL'){
		$estadoAnuncio = 'Alagoas';
	}elseif($estadoAnuncio == 'AM'){
		$estadoAnuncio = 'Amazonas';
	}elseif($estadoAnuncio == 'AP'){
		$estadoAnuncio = 'Amapa';
	}elseif($estadoAnuncio == 'BA'){
		$estadoAnuncio = 'Bahia';
	}elseif($estadoAnuncio == 'CE'){
		$estadoAnuncio = 'Ceara';
	}elseif($estadoAnuncio == 'DF'){
		$estadoAnuncio = 'distrito-federal';
	}elseif($estadoAnuncio == 'ES'){
		$estadoAnuncio = 'espirito-santo';
	}elseif($estadoAnuncio == 'GO'){
		$estadoAnuncio = 'Goias';
	}elseif($estadoAnuncio == 'MA'){
		$estadoAnuncio = 'Maranhao';
	}elseif($estadoAnuncio == 'MG'){
		$estadoAnuncio = 'minas-gerais';
	}elseif($estadoAnuncio == 'MS'){
		$estadoAnuncio = 'mato-grosso-do-sul';
	}elseif($estadoAnuncio == 'MT'){
		$estadoAnuncio = 'mato-grosso';
	}elseif($estadoAnuncio == 'PA'){
		$estadoAnuncio = 'Para';
	}elseif($estadoAnuncio == 'PB'){
		$estadoAnuncio = 'Paraiba';
	}elseif($estadoAnuncio == 'PE'){
		$estadoAnuncio = 'Pernambuco';
	}elseif($estadoAnuncio == 'PI'){
		$estadoAnuncio = 'Piaui';
	}elseif($estadoAnuncio == 'PR'){
		$estadoAnuncio = 'Parana';
	}elseif($estadoAnuncio == 'RJ'){
		$estadoAnuncio = 'rio-de-janeiro';
	}elseif($estadoAnuncio == 'RO'){
		$estadoAnuncio = 'Rondonia';
	}elseif($estadoAnuncio == 'RN'){
		$estadoAnuncio = 'rio-grande-do-norte';
	}elseif($estadoAnuncio == 'RR'){
		$estadoAnuncio = 'Roraima';
	}elseif($estadoAnuncio == 'RS'){
		$estadoAnuncio = 'rio-grande-do-sul';
	}elseif($estadoAnuncio == 'SC'){
		$estadoAnuncio = 'santa-catarina';
	}elseif($estadoAnuncio == 'SE'){
		$estadoAnuncio = 'Sergipe';
	}elseif($estadoAnuncio == 'SP'){
			$estadoAnuncio = 'sao-paulo';
	}elseif($estadoAnuncio == 'TO'){
		$estadoAnuncio = 'Tocantins';
	}
	
	return strtolower($estadoAnuncio);
	
}

function sds_verificaUF($estadoAnuncio){
	
	if($estadoAnuncio == 'Acre'){
		$estadoAnuncio = 'AC';
	}elseif($estadoAnuncio == 'Alagoas'){
		$estadoAnuncio = 'AL';
	}elseif($estadoAnuncio == 'Amazonas'){
		$estadoAnuncio = 'AM';
	}elseif($estadoAnuncio == 'Amapa'){
		$estadoAnuncio = 'AP';
	}elseif($estadoAnuncio == 'Bahia'){
		$estadoAnuncio = 'BA';
	}elseif($estadoAnuncio == 'Ceara'){
		$estadoAnuncio = 'CE';
	}elseif($estadoAnuncio == 'distrito-federal'){
		$estadoAnuncio = 'DF';
	}elseif($estadoAnuncio == 'espirito-santo'){
		$estadoAnuncio = 'ES';
	}elseif($estadoAnuncio == 'Goias'){
		$estadoAnuncio = 'GO';
	}elseif($estadoAnuncio == 'Maranhao'){
		$estadoAnuncio = 'MA';
	}elseif($estadoAnuncio == 'minas-gerais'){
		$estadoAnuncio = 'MG';
	}elseif($estadoAnuncio == 'mato-grosso-do-sul'){
		$estadoAnuncio = 'MS';
	}elseif($estadoAnuncio == 'mato-grosso'){
		$estadoAnuncio = 'MT';
	}elseif($estadoAnuncio == 'Para'){
		$estadoAnuncio = 'PA';
	}elseif($estadoAnuncio == 'Paraiba'){
		$estadoAnuncio = 'PB';
	}elseif($estadoAnuncio == 'Pernambuco'){
		$estadoAnuncio = 'PE';
	}elseif($estadoAnuncio == 'Piaui'){
		$estadoAnuncio = 'PI';
	}elseif($estadoAnuncio == 'Parana'){
		$estadoAnuncio = 'PR';
	}elseif($estadoAnuncio == 'rio-de-janeiro'){
		$estadoAnuncio = 'RJ';
	}elseif($estadoAnuncio == 'Rondonia'){
		$estadoAnuncio = 'RO';
	}elseif($estadoAnuncio == 'rio-grande-do-norte'){
		$estadoAnuncio = 'RN';
	}elseif($estadoAnuncio == 'Roraima'){
		$estadoAnuncio = 'RR';
	}elseif($estadoAnuncio == 'rio-grande-do-sul'){
		$estadoAnuncio = 'RS';
	}elseif($estadoAnuncio == 'santa-catarina'){
		$estadoAnuncio = 'SC';
	}elseif($estadoAnuncio == 'Sergipe'){
		$estadoAnuncio = 'SE';
	}elseif($estadoAnuncio == 'sao-paulo'){
			$estadoAnuncio = 'SP';
	}elseif($estadoAnuncio == 'Tocantins'){
		$estadoAnuncio = 'TO';
	}
	
	return $estadoAnuncio;
	
}

//FUNÇAO QUE LISTA A IMAGEM DO PERFIL
function listaImagemPerfil($idAnuncio){
	 include "Connections/config.php";
	 
	 $sql_buscaImagens = "SELECT * FROM sds_midia WHERE idAnuncio_fk = :idAnuncio AND nomeFotoPerfil = 'foto_cliente_zero'";
	 
	 $query_buscaImagens = $connect->prepare($sql_buscaImagens);
	 $query_buscaImagens->bindValue(':idAnuncio', $idAnuncio, PDO::PARAM_STR);
	 $query_buscaImagens->execute();
	 
	 $resultado_buscauImagens = $query_buscaImagens->fetchAll(PDO::FETCH_ASSOC);

	 foreach($resultado_buscauImagens as $res_buscauImagens){
        $idImagem = $res_buscauImagens["idMidia"];	
	}
	return $idImagem;	
}
//FUNÇAO QUE LISTA A IMAGEM DA GALERIA
function showImages($nomeAnunciante, $idImagem){

	$imagem = URL::getBase() .'img/uploads/'. md5($nomeAnunciante).'/'.md5($nomeAnunciante).'_image_'.$idImagem.'.jpg';

	return $imagem;
}

function sds_buscaUrl($pagina){
	include "Connections/config.php";
	 
	 $sql_buscaUrl = "SELECT * FROM sds_anuncio WHERE linkPessoalAnuncio = :link";
	 
	 $query_buscaUrl = $connect->prepare($sql_buscaUrl);
	 $query_buscaUrl->bindValue(':link', $pagina, PDO::PARAM_STR);
	 $query_buscaUrl->execute();
	 
	 $resultado_buscaUrl = $query_buscaUrl->fetchAll(PDO::FETCH_ASSOC);
	 $cont = $query_buscaUrl->rowCount(PDO::FETCH_ASSOC);

	 foreach($resultado_buscaUrl as $res_urlAnuncio){
        $url = $res_urlAnuncio["urlAnuncio"];	
	}

	if($cont==1){

		echo '<meta http-equiv="refresh" name="Refresh" content="0; URL= http://saldaodeservicos.com/anuncio/'.$url.'">	';
	}else{
		require "404.php";
	}
}

function verificar_url($idAnuncio, $idFoto){

	include "Connections/config.php";
	 
	$sql_validaUrl = "SELECT midia.* FROM sds_midia midia WHERE idAnuncio_fk = :idAnuncio AND nomeFoto = :idFoto";
	 
	$query_validaUrl = $connect->prepare($sql_validaUrl);
	$query_validaUrl->bindValue(':idAnuncio', $idAnuncio, PDO::PARAM_STR);
	$query_validaUrl->bindValue(':idFoto', $idFoto, PDO::PARAM_STR);
	$query_validaUrl->execute();
	 
	$resultado_validaUrl = $query_validaUrl->fetchAll(PDO::FETCH_ASSOC);

	foreach($resultado_validaUrl as $res_validaUrl){
        $url = $res_validaUrl["caminhoFoto"];	
	}

	if($url == 1){
		$url = true;
	}else{
		$url = false;
	}

	return $url;
}

function sds_selectCategoriaSearch($pesquisa){

	
	include('Connections/config.php');

	try{
		$sql = 'SELECT profissoes.* FROM sds_profissoes profissoes
				WHERE profissoes.nome LIKE :pesquisa LIMIT 5';
		
		$query_selectBusca = $connect->prepare($sql);
		$query_selectBusca->bindValue(':pesquisa', '%'.$pesquisa.'%', PDO::PARAM_STR);
		$query_selectBusca->execute();

		$query_resultadoBusca 		= $query_selectBusca->fetchAll(PDO::FETCH_ASSOC);
		$query_resultadoBuscaCont 	= $query_selectBusca->rowCount(PDO::FETCH_ASSOC);
	
	}catch(PDOException $erro_buscar){
		echo 'Erro tentar efetuar a busca dos dados';
	}

	if($query_resultadoBuscaCont == 0){
		echo '<li> Nenhum resultado encontrado </li>';
	}

	return $query_resultadoBusca;
}

function sds_selectCitySearch($pesquisa){
	
	include('Connections/config.php');

	try{
		$sql = 'SELECT * FROM cidade
				WHERE nomeCidade LIKE :pesquisa LIMIT 5	';
		
		$query_selectBusca = $connect->prepare($sql);
		$query_selectBusca->bindValue(':pesquisa', '%'.$pesquisa.'%', PDO::PARAM_STR);
		$query_selectBusca->execute();

		$query_resultadoBusca 		= $query_selectBusca->fetchAll(PDO::FETCH_ASSOC);
		$query_resultadoBuscaCont 	= $query_selectBusca->rowCount(PDO::FETCH_ASSOC);
	
	}catch(PDOException $erro_buscar){
		echo 'Erro tentar efetuar a busca dos dados';
	}

	if($query_resultadoBuscaCont == 0){
		echo '<li> Nenhum resultado encontrado </li>';
	}

	return $query_resultadoBusca;
}

function sds_selectCityHomeSearch($pesquisa){
	
	include('Connections/config.php');

	try{
		$sql = 'SELECT cidade.*, estados.* FROM cidade cidade, sds_estados estados
				WHERE cidade.nomeCidade LIKE :pesquisa AND cidade.estado = estados.uf LIMIT 5	';
		
		$query_selectBusca = $connect->prepare($sql);
		$query_selectBusca->bindValue(':pesquisa', '%'.$pesquisa.'%', PDO::PARAM_STR);
		$query_selectBusca->execute();

		$query_resultadoBusca 		= $query_selectBusca->fetchAll(PDO::FETCH_ASSOC);
		$query_resultadoBuscaCont 	= $query_selectBusca->rowCount(PDO::FETCH_ASSOC);
	
	}catch(PDOException $erro_buscar){
		echo 'Erro ao tentar efetuar a busca da cidade';
	}

	if($query_resultadoBuscaCont == 0){
		
		try{
			$sqlB = 'SELECT bairros.*, cidade.*, estados.* FROM  bairros bairros, cidade cidade, sds_estados estados WHERE bairros.nomeBairro LIKE :pesquisa 
					AND bairros.idCidade = cidade.id AND cidade.estado = estados.uf LIMIT 127';
			
			$query_selectBuscaBairro = $connect->prepare($sqlB);
			$query_selectBuscaBairro->bindValue(':pesquisa', '%'.$pesquisa.'%', PDO::PARAM_STR);
			$query_selectBuscaBairro->execute();

			$query_resultadoBuscaBairro  		= $query_selectBuscaBairro->fetchAll(PDO::FETCH_ASSOC);
			$query_resultadoBuscaBairroCont 	= $query_selectBuscaBairro->rowCount(PDO::FETCH_ASSOC);

			if($query_resultadoBuscaBairroCont == 0){
				echo '<li> Nenhum resultado encontrado </li>';
			}else{
				$i = 0;
				$urlAC = TRUE; $urlAL = TRUE; $urlAM = TRUE; $urlAP = TRUE;
				$urlBA = TRUE; $urlCE = TRUE; $urlDF = TRUE; $urlES = TRUE;
				$urlGO = TRUE; $urlMA = TRUE; $urlMG = TRUE; $urlMS = TRUE;
				$urlMT = TRUE; $urlPA = TRUE; $urlPB = TRUE; $urlPE = TRUE;
				$urlPI = TRUE; $urlPR = TRUE; $urlRJ = TRUE; $urlRO = TRUE;
				$urlRN = TRUE; $urlRR = TRUE; $urlSE = TRUE; $urlSP = TRUE;
				$urlSC = TRUE; $urlSP = TRUE; $urlTO = TRUE;

				foreach ($query_resultadoBuscaBairro as $query_resBuscaBairro) {
					$categoria = $query_resBuscaBairro['nomeBairro'];
					$uf = $query_resBuscaBairro['uf'];
					
					if($uf == 'AC'){
						if($urlAC){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlAC = FALSE;
						}					
					}elseif($uf == 'AL'){
						if($urlAL){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlAL = FALSE;
						}					
					}elseif($uf == 'AM'){
						if($urlAM){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlAM = FALSE;
						}					
					}elseif($uf == 'AP'){
						if($urlAP){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlAP = FALSE;
						}					
					}elseif($uf == 'BA'){
						if($urlBA){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlBA = FALSE;
						}					
					}elseif($uf == 'CE'){
						if($urlCE){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlCE = FALSE;
						}					
					}elseif($uf == 'DF'){
						if($urlDF){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlDF = FALSE;
						}					
					}elseif($uf == 'ES'){
						if($urlES){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlES = FALSE;
						}					
					}elseif($uf == 'GO'){
						if($urlGO){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlGO = FALSE;
						}					
					}elseif($uf == 'MA'){
						if($urlMA){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlMA = FALSE;
						}					
					}elseif($uf == 'MG'){
						if($urlMG){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlMG = FALSE;
						}					
					}elseif($uf == 'MS'){
						if($urlMS){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlMS = FALSE;
						}					
					}elseif($uf == 'MT'){
						if($urlMT){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlMT = FALSE;
						}					
					}elseif($uf == 'PA'){
						if($urlPA){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlPA = FALSE;
						}					
					}elseif($uf == 'PB'){
						if($urlPB){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlPB = FALSE;
						}					
					}elseif($uf == 'PE'){
						if($urlPE){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlPE = FALSE;
						}					
					}elseif($uf == 'PI'){
						if($urlPI){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlPI = FALSE;
						}					
					}elseif($uf == 'PR'){
						if($urlPR){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlPR = FALSE;
						}					
					}elseif($uf == 'RJ'){
						if($urlRJ){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlRJ = FALSE;
						}					
					}elseif($uf == 'RO'){
						if($urlRO){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlRO = FALSE;
						}					
					}elseif($uf == 'RN'){
						if($urlRN){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlRN = FALSE;
						}					
					}elseif($uf == 'RR'){
						if($urlRR){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlRR = FALSE;
						}					
					}elseif($uf == 'RS'){
						if($urlRS){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlRS = FALSE;
						}					
					}elseif($uf == 'SC'){
						if($urlSC){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlSC = FALSE;
						}					
					}elseif($uf == 'SE'){
						if($urlSE){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlSE = FALSE;
						}					
					}elseif($uf == 'SP'){
						if($urlSP){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlSP = FALSE;
						}
					}elseif($uf == 'TO'){
						if($urlTO){
							echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';				
							$urlTO = FALSE;
						}					
					}

					$i++;
				}
			}

		}catch(PDOException $erro_buscar){
			echo 'Erro ao tentar efetuar a busca do bairro';
		}

	}else{
		foreach ($query_resultadoBusca as $query_resBusca) {
			$categoria = $query_resBusca['nomeCidade'];
			$uf = $query_resBusca['uf'];
			echo '<a href="#"><li onclick="set_itemCityHome(\''.str_replace("'", "\'", $categoria.', '.$uf).'\')">'.$categoria.', '.$uf.'</li></a>';
		}
	}
}


?>
