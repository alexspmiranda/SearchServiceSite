<?php
	require_once('nav/func/funcoes.php');
	
	$pesquisa = strip_tags(trim($_POST['keyword']));
	
	$query_resultadoBusca = sds_selectCategoriaSearch($pesquisa);

	foreach ($query_resultadoBusca as $query_resBusca) {
		$categoria = $query_resBusca['nome'];
		echo '<a href="#"><li onclick="set_item(\''.str_replace("'", "\'", $categoria).'\')">'.$categoria.'</li></a>';
	}
?>