<?php
	require_once('nav/func/funcoes.php');
	
	$pesquisa = strip_tags(trim($_POST['keyword']));
	
	sds_selectCityHomeSearch($pesquisa);
?>