<?php

function salvaImagemPerfil($idAnuncio, $nomeAnunciante){
	
	include_once( 'function.php');

	$thumbdir = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/';
		if(!is_dir($thumbdir))
			mkdir('../img/uploads/'. md5($nomeAnunciante).'/thumbs', 0777, true);

	$max_file_size = 1024*1024*2; // 200kb
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$sizes = array(200 => 200);

	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['userImage'])) {
		if( $_FILES['userImage']['size'] < $max_file_size ){
			// get file extension
			$ext = strtolower(pathinfo($_FILES['userImage']['name'], PATHINFO_EXTENSION));
			if (in_array($ext, $valid_exts)) {
				/* resize image */
				foreach ($sizes as $w => $h) {
					$files[] = resizeP($w, $h, $nomeAnunciante);
				}

			} else {
				$msg = 'Unsupported file';
			}
		} else{
			$msg = '';
		}
	}

	if(is_uploaded_file($_FILES['userImage']['tmp_name'])){

		$nomeAnunciante = md5($nomeAnunciante);
		$dir = '../img/uploads/'.$nomeAnunciante.'/';

		if(!is_dir($dir))
			mkdir('../img/uploads/'.$nomeAnunciante, 0777, true);

		$_UP['pasta'] = $dir; //'../img/uploads/';

		// Tamanho mÃ¡ximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024*2; // 1Mb

		// Array com as extensÃµes permitidas
		$_UP['extensoes'] = array('jpeg', 'jpg', 'png', 'gif');

		// Renomeia o arquivo? (Se true, o arquivo serÃ¡ salvo como .jpg e um nome Ãºnico)
		$_UP['renomeia'] = true;

		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($_FILES['userImage']['error'] != 0) {
		  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['userImage']['error']]);
		  exit; // Para a execuÃ§Ã£o do script
		}

		// Caso script chegue a esse ponto, Não houve erro com o upload e o PHP pode continuar

		// Faz a verificaÃ§Ã£o da extensÃ£o do arquivo
		$nome_arquivo = explode(".", $_FILES['userImage']['name']); 
		$extensao = strtolower(end($nome_arquivo));
		if (array_search($extensao, $_UP['extensoes']) === false) {
		  echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
		  exit;
		}

		// Faz a verificaÃ§Ã£o do tamanho do arquivo
		if ($_UP['tamanho'] < $_FILES['userImage']['size']) {
		  echo "O arquivo enviado é muito grande, envie arquivos de até 1Mb.";
		  exit;
		}

		// O arquivo passou em todas as verificaÃ§Ãµes, hora de tentar movÃª-lo para a pasta

		// Primeiro verifica se deve trocar o nome do arquivo
		if ($_UP['renomeia'] == true) {
		  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensÃ£o .jpg
		  //$nome_final = md5(time()).'.jpg';
			$nome_final = $nomeAnunciante.'_image_profile.jpg';
		} else {
		  // MantÃ©m o nome original do arquivo
		  $nome_final = $_FILES['userImage']['name'];
		}
		  
		// Depois verifica se Ã© possível mover o arquivo para a pasta escolhida
		if (move_uploaded_file($_FILES['userImage']['tmp_name'], $_UP['pasta'] . $nome_final)) {
		  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
		  
		  insert_img($idAnuncio, 'profile');
		  
		  echo '<div class="container"><div class="alert alert-info" role="alert">Upload da foto de perfil efetuado com sucesso! </div></div>';

		  // echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
		} else {
		  // Não foi possível fazer o upload, provavelmente a pasta estÃ¡ incorreta
		  echo "Não foi possível enviar o arquivo, tente novamente";
		}
	} 
}

function salvaImagemAnuncioUm($idAnuncio, $nomeAnunciante){

	include_once( 'function.php');

	$thumbdir = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/';
		if(!is_dir($thumbdir))
			mkdir('../img/uploads/'. md5($nomeAnunciante).'/thumbs', 0777, true);

	$max_file_size = 1024*1024*2; // 200kb
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$sizes = array(340 => 192);

	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['userImage1'])) {
		if( $_FILES['userImage1']['size'] < $max_file_size ){
			// get file extension
			$ext = strtolower(pathinfo($_FILES['userImage1']['name'], PATHINFO_EXTENSION));
			if (in_array($ext, $valid_exts)) {
				/* resize image */

				foreach ($sizes as $w => $h) {
					$files[] = resize($w, $h, $nomeAnunciante);
				}

			} else {
				$msg = 'Unsupported file';
			}
		} else{
			$msg = '';
		}
	}

	if(is_uploaded_file($_FILES['userImage1']['tmp_name'])){

		$nomeAnunciante = md5($nomeAnunciante);
		$dir = '../img/uploads/'.$nomeAnunciante.'/';

		if(!is_dir($dir))
			mkdir('../img/uploads/'.$nomeAnunciante, 0777, true);

		$_UP['pasta'] = $dir; //'../img/uploads/';

		// Tamanho mÃ¡ximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024*2; // 1Mb

		// Array com as extensÃµes permitidas
		$_UP['extensoes'] = array('jpeg', 'jpg', 'png', 'gif');

		// Renomeia o arquivo? (Se true, o arquivo serÃ¡ salvo como .jpg e um nome Ãºnico)
		$_UP['renomeia'] = true;

		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($_FILES['userImage1']['error'] != 0) {
		  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['userImage1']['error']]);
		  exit; // Para a execuÃ§Ã£o do script
		}

		// Caso script chegue a esse ponto, Não houve erro com o upload e o PHP pode continuar

		// Faz a verificaÃ§Ã£o da extensÃ£o do arquivo
		$nome_arquivo = explode(".", $_FILES['userImage1']['name']); 
		$extensao = strtolower(end($nome_arquivo));
		if (array_search($extensao, $_UP['extensoes']) === false) {
		  echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
		  exit;
		}

		// Faz a verificaÃ§Ã£o do tamanho do arquivo
		if ($_UP['tamanho'] < $_FILES['userImage1']['size']) {
		  echo "O arquivo enviado é muito grande, envie arquivos de até 1Mb.";
		  exit;
		}

		// O arquivo passou em todas as verificaÃ§Ãµes, hora de tentar movÃª-lo para a pasta

		// Primeiro verifica se deve trocar o nome do arquivo
		if ($_UP['renomeia'] == true) {
		  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensÃ£o .jpg
		  //$nome_final = md5(time()).'.jpg';
			$nome_final = $nomeAnunciante.'_image_1.jpg';
		} else {
		  // MantÃ©m o nome original do arquivo
		  $nome_final = $_FILES['userImage1']['name'];
		}
		  
		// Depois verifica se Ã© possível mover o arquivo para a pasta escolhida
		if (move_uploaded_file($_FILES['userImage1']['tmp_name'], $_UP['pasta'] . $nome_final)) {
		  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
		  
		  insert_img($idAnuncio, '1');

		  echo '<div class="container"><div class="alert alert-info" role="alert">Upload da primeira foto efetuado com sucesso! </div></div>';
		  // echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
		} else {
		  // Não foi possível fazer o upload, provavelmente a pasta estÃ¡ incorreta
		  echo "Não foi possível enviar o arquivo, tente novamente";
		}
	}
}

function salvaImagemAnuncioDois($idAnuncio, $nomeAnunciante){
	
	
	include_once( 'function.php');

	$thumbdir = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/';
		if(!is_dir($thumbdir))
			mkdir('../img/uploads/'. md5($nomeAnunciante).'/thumbs', 0777, true);

	$max_file_size = 1024*1024*2; // 200kb
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$sizes = array(340 => 192);

	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['userImage2'])) {
		if( $_FILES['userImage2']['size'] < $max_file_size ){
			// get file extension
			$ext = strtolower(pathinfo($_FILES['userImage2']['name'], PATHINFO_EXTENSION));
			if (in_array($ext, $valid_exts)) {
				/* resize image */
				foreach ($sizes as $w => $h) {
					$files[] = resize2($w, $h, $nomeAnunciante);
				}

			} else {
				$msg = 'Unsupported file';
			}
		} else{
			$msg = '';
		}
	}

	if(is_uploaded_file($_FILES['userImage2']['tmp_name'])){

		$nomeAnunciante = md5($nomeAnunciante);
		$dir = '../img/uploads/'.$nomeAnunciante.'/';
		
		if(!is_dir($dir))
			mkdir('../img/uploads/'.$nomeAnunciante, 0777, true);

		$_UP['pasta'] = $dir; //'../img/uploads/';

		// Tamanho mÃ¡ximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024*2; // 1Mb

		// Array com as extensÃµes permitidas
		$_UP['extensoes'] = array('jpeg', 'jpg', 'png', 'gif');

		// Renomeia o arquivo? (Se true, o arquivo serÃ¡ salvo como .jpg e um nome Ãºnico)
		$_UP['renomeia'] = true;

		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($_FILES['userImage2']['error'] != 0) {
		  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['userImage2']['error']]);
		  exit; // Para a execuÃ§Ã£o do script
		}

		// Caso script chegue a esse ponto, Não houve erro com o upload e o PHP pode continuar

		// Faz a verificaÃ§Ã£o da extensÃ£o do arquivo
		$nome_arquivo = explode(".", $_FILES['userImage2']['name']); 
		$extensao = strtolower(end($nome_arquivo));
		if (array_search($extensao, $_UP['extensoes']) === false) {
		  echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
		  exit;
		}

		// Faz a verificaÃ§Ã£o do tamanho do arquivo
		if ($_UP['tamanho'] < $_FILES['userImage2']['size']) {
		  echo "O arquivo enviado é muito grande, envie arquivos de até 1Mb.";
		  exit;
		}

		// O arquivo passou em todas as verificaÃ§Ãµes, hora de tentar movÃª-lo para a pasta

		// Primeiro verifica se deve trocar o nome do arquivo
		if ($_UP['renomeia'] == true) {
		  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensÃ£o .jpg
		  //$nome_final = md5(time()).'.jpg';
			$nome_final = $nomeAnunciante.'_image_2.jpg';
		} else {
		  // MantÃ©m o nome original do arquivo
		  $nome_final = $_FILES['userImage2']['name'];
		}
		  
		// Depois verifica se Ã© possível mover o arquivo para a pasta escolhida
		if (move_uploaded_file($_FILES['userImage2']['tmp_name'], $_UP['pasta'] . $nome_final)) {
		  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo

			insert_img($idAnuncio, '2');
		  	echo '<div class="container"><div class="alert alert-info" role="alert">Upload da segunda foto efetuado com sucesso! </div></div>';
		  // echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
		} else {
		  // Não foi possível fazer o upload, provavelmente a pasta estÃ¡ incorreta
		  echo "Não foi possível enviar o arquivo, tente novamente";
		}
	}
}

function salvaImagemAnuncioTres($idAnuncio, $nomeAnunciante){	
	
	include_once( 'function.php');

	$thumbdir = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/';
		if(!is_dir($thumbdir))
			mkdir('../img/uploads/'. md5($nomeAnunciante).'/thumbs', 0777, true);

	$max_file_size = 1024*1024*2; // 200kb
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$sizes = array(340 => 192);

	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['userImage3'])) {
		if( $_FILES['userImage3']['size'] < $max_file_size ){
			// get file extension
			$ext = strtolower(pathinfo($_FILES['userImage3']['name'], PATHINFO_EXTENSION));
			if (in_array($ext, $valid_exts)) {
				/* resize image */
				foreach ($sizes as $w => $h) {
					$files[] = resize3($w, $h, $nomeAnunciante);
				}

			} else {
				$msg = 'Unsupported file';
			}
		} else{
			$msg = '';
		}
	}

	if(is_uploaded_file($_FILES['userImage3']['tmp_name'])){
		$nomeAnunciante = md5($nomeAnunciante);
		
		$dir = '../img/uploads/'.$nomeAnunciante.'/';

		if(!is_dir($dir))
			mkdir('../img/uploads/'.$nomeAnunciante, 0777, true);


		$_UP['pasta'] = $dir; //'../img/uploads/';

		// Tamanho mÃ¡ximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024*2; // 1Mb

		// Array com as extensÃµes permitidas
		$_UP['extensoes'] = array('jpeg', 'jpg', 'png', 'gif');

		// Renomeia o arquivo? (Se true, o arquivo serÃ¡ salvo como .jpg e um nome Ãºnico)
		$_UP['renomeia'] = true;

		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($_FILES['userImage3']['error'] != 0) {
		  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['userImage3']['error']]);
		  exit; // Para a execuÃ§Ã£o do script
		}

		// Caso script chegue a esse ponto, Não houve erro com o upload e o PHP pode continuar

		// Faz a verificaÃ§Ã£o da extensÃ£o do arquivo
		$nome_arquivo = explode(".", $_FILES['userImage3']['name']); 
		$extensao = strtolower(end($nome_arquivo));
		if (array_search($extensao, $_UP['extensoes']) === false) {
		  echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
		  exit;
		}

		// Faz a verificaÃ§Ã£o do tamanho do arquivo
		if ($_UP['tamanho'] < $_FILES['userImage3']['size']) {
		  echo "O arquivo enviado é muito grande, envie arquivos de até 1Mb.";
		  exit;
		}

		// O arquivo passou em todas as verificaÃ§Ãµes, hora de tentar movÃª-lo para a pasta

		// Primeiro verifica se deve trocar o nome do arquivo
		if ($_UP['renomeia'] == true) {
		  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensÃ£o .jpg
		  //$nome_final = md5(time()).'.jpg';
			$nome_final = $nomeAnunciante.'_image_3.jpg';
		} else {
		  // MantÃ©m o nome original do arquivo
		  $nome_final = $_FILES['userImage3']['name'];
		}
		  
		// Depois verifica se Ã© possível mover o arquivo para a pasta escolhida
		if (move_uploaded_file($_FILES['userImage3']['tmp_name'], $_UP['pasta'] . $nome_final)) {
		  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
		  	insert_img($idAnuncio, '3');
		  	echo '<div class="container"><div class="alert alert-info" role="alert">Upload da terceira foto efetuado com sucesso! </div></div>';
		  // echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
		} else {
		  // Não foi possível fazer o upload, provavelmente a pasta estÃ¡ incorreta
		  echo "Não foi possível enviar o arquivo, tente novamente";
		}
	}	
}

function salvaImagemAnuncioQuatro($idAnuncio, $nomeAnunciante){
	
	include_once( 'function.php');

	$thumbdir = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/';
		if(!is_dir($thumbdir))
			mkdir('../img/uploads/'. md5($nomeAnunciante).'/thumbs', 0777, true);

	$max_file_size = 1024*1024*2; // 200kb
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$sizes = array(340 => 192);

	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['userImage4'])) {
		if( $_FILES['userImage4']['size'] < $max_file_size ){
			// get file extension
			$ext = strtolower(pathinfo($_FILES['userImage4']['name'], PATHINFO_EXTENSION));
			if (in_array($ext, $valid_exts)) {
				/* resize image */
				foreach ($sizes as $w => $h) {
					$files[] = resize4($w, $h, $nomeAnunciante);
				}

			} else {
				$msg = 'Unsupported file';
			}
		} else{
			$msg = '';
		}
	}

	if(is_uploaded_file($_FILES['userImage4']['tmp_name'])){
		$nomeAnunciante = md5($nomeAnunciante);
		$dir = '../img/uploads/'.$nomeAnunciante.'/';

		if(!is_dir($dir))
			mkdir('../img/uploads/'.$nomeAnunciante, 0777, true);

		$_UP['pasta'] = $dir; //'../img/uploads/';

		// Tamanho mÃ¡ximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024*2; // 1Mb

		// Array com as extensÃµes permitidas
		$_UP['extensoes'] = array('jpeg', 'jpg', 'png', 'gif');

		// Renomeia o arquivo? (Se true, o arquivo serÃ¡ salvo como .jpg e um nome Ãºnico)
		$_UP['renomeia'] = true;

		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($_FILES['userImage4']['error'] != 0) {
		  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['userImage4']['error']]);
		  exit; // Para a execuÃ§Ã£o do script
		}

		// Caso script chegue a esse ponto, Não houve erro com o upload e o PHP pode continuar

		// Faz a verificaÃ§Ã£o da extensÃ£o do arquivo
		$nome_arquivo = explode(".", $_FILES['userImage4']['name']); 
		$extensao = strtolower(end($nome_arquivo));
		if (array_search($extensao, $_UP['extensoes']) === false) {
		  echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
		  exit;
		}

		// Faz a verificaÃ§Ã£o do tamanho do arquivo
		if ($_UP['tamanho'] < $_FILES['userImage4']['size']) {
		  echo "O arquivo enviado é muito grande, envie arquivos de até 1Mb.";
		  exit;
		}

		// O arquivo passou em todas as verificaÃ§Ãµes, hora de tentar movÃª-lo para a pasta

		// Primeiro verifica se deve trocar o nome do arquivo
		if ($_UP['renomeia'] == true) {
		  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensÃ£o .jpg
		  //$nome_final = md5(time()).'.jpg';
			$nome_final = $nomeAnunciante.'_image_4.jpg';
		} else {
		  // MantÃ©m o nome original do arquivo
		  $nome_final = $_FILES['userImage4']['name'];
		}
		  
		// Depois verifica se Ã© possível mover o arquivo para a pasta escolhida
		if (move_uploaded_file($_FILES['userImage4']['tmp_name'], $_UP['pasta'] . $nome_final)) {
		  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
			 insert_img($idAnuncio, '4');  
			echo '<div class="container"><div class="alert alert-info" role="alert">Upload da quarta foto efetuado com sucesso! </div></div>';
		  // echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
		} else {
		  // Não foi possível fazer o upload, provavelmente a pasta estÃ¡ incorreta
		  echo "Não foi possível enviar o arquivo, tente novamente";
		}
	}
}

function salvaImagemAnuncioCinco($idAnuncio, $nomeAnunciante){
	
	include_once( 'function.php');

	$thumbdir = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/';
		if(!is_dir($thumbdir))
			mkdir('../img/uploads/'. md5($nomeAnunciante).'/thumbs', 0777, true);

	$max_file_size = 1024*1024*2; // 200kb
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	// thumbnail sizes
	$sizes = array(340 => 192);

	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['userImage5'])) {
		if( $_FILES['userImage5']['size'] < $max_file_size ){
			// get file extension
			$ext = strtolower(pathinfo($_FILES['userImage5']['name'], PATHINFO_EXTENSION));
			if (in_array($ext, $valid_exts)) {
				/* resize image */
				foreach ($sizes as $w => $h) {
					$files[] = resize5($w, $h, $nomeAnunciante);
				}

			} else {
				$msg = 'Unsupported file';
			}
		} else{
			$msg = '';
		}
	}

	if(is_uploaded_file($_FILES['userImage5']['tmp_name'])){
		$nomeAnunciante = md5($nomeAnunciante);
		$dir = '../img/uploads/'.$nomeAnunciante.'/';

		if(!is_dir($dir))
			mkdir('../img/uploads/'.$nomeAnunciante, 0777, true);

		$_UP['pasta'] = $dir; //'../img/uploads/';

		// Tamanho mÃ¡ximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024*2; // 1Mb

		// Array com as extensÃµes permitidas
		$_UP['extensoes'] = array('jpeg', 'jpg', 'png', 'gif');

		// Renomeia o arquivo? (Se true, o arquivo serÃ¡ salvo como .jpg e um nome Ãºnico)
		$_UP['renomeia'] = true;

		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($_FILES['userImage5']['error'] != 0) {
		  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['userImage5']['error']]);
		  exit; // Para a execuÃ§Ã£o do script
		}

		// Caso script chegue a esse ponto, Não houve erro com o upload e o PHP pode continuar

		// Faz a verificaÃ§Ã£o da extensÃ£o do arquivo
		$nome_arquivo = explode(".", $_FILES['userImage5']['name']); 
		$extensao = strtolower(end($nome_arquivo));
		if (array_search($extensao, $_UP['extensoes']) === false) {
		  echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
		  exit;
		}

		// Faz a verificaÃ§Ã£o do tamanho do arquivo
		if ($_UP['tamanho'] < $_FILES['userImage5']['size']) {
		  echo "O arquivo enviado é muito grande, envie arquivos de até 1Mb.";
		  exit;
		}

		// O arquivo passou em todas as verificaÃ§Ãµes, hora de tentar movÃª-lo para a pasta

		// Primeiro verifica se deve trocar o nome do arquivo
		if ($_UP['renomeia'] == true) {
		  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensÃ£o .jpg
		  //$nome_final = md5(time()).'.jpg';
			$nome_final = $nomeAnunciante.'_image_5.jpg';
		} else {
		  // MantÃ©m o nome original do arquivo
		  $nome_final = $_FILES['userImage5']['name'];
		}
		  
		// Depois verifica se Ã© possível mover o arquivo para a pasta escolhida
		if (move_uploaded_file($_FILES['userImage5']['tmp_name'], $_UP['pasta'] . $nome_final)) {
		  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
			insert_img($idAnuncio, '5');
		 	echo '<div class="container"><div class="alert alert-info" role="alert">Upload da quinta foto efetuado com sucesso! </div></div>';
		  // echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
		} else {
		  // Não foi possível fazer o upload, provavelmente a pasta estÃ¡ incorreta
		  echo "Não foi possível enviar o arquivo, tente novamente";
		}
	}
}

function listaImagem($emailAnunciante){

	$dir = '../img/uploads/'.md5($emailAnunciante).'/'.md5($emailAnunciante).'_image_1.jpg';

	return $dir;
}
?>
