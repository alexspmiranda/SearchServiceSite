<?php

function sds_inserePalavraChaveCidade($catKeyWords, $citKeyWords){
	
	include "Connections/config.php";
	
	$sql_keyWords = 'INSERT INTO sds_key_words(catKeyWords, citKeyWords, dataKeyWords) VALUES(:catKeyWords, :citKeyWords, :dataKeyWords)';
		
	try{
		$query_keyWords = $connect->prepare($sql_keyWords);
		$query_keyWords->bindValue(':catKeyWords', $catKeyWords , PDO::PARAM_STR);
		$query_keyWords->bindValue(':citKeyWords', $citKeyWords , PDO::PARAM_STR);
		$query_keyWords->bindValue(':dataKeyWords', dataExata() , PDO::PARAM_STR);
		$query_keyWords->execute();
		
	}catch(PDOException $erro_enviarKeyWords)
	{
		echo 'Erro ao enviar key words';
	}
}

function sds_inserePalavraChaveCategoria($citKeyWords, $catKeyWords){
	
	include "Connections/config.php";
	
	$sql_keyWords = 'INSERT INTO sds_key_words(catKeyWords, citKeyWords, dataKeyWords) VALUES(:catKeyWords, :citKeyWords, :dataKeyWords)';
		
		try{
			$query_keyWords = $connect->prepare($sql_keyWords);
			$query_keyWords->bindValue(':catKeyWords', $catKeyWords , PDO::PARAM_STR);
			$query_keyWords->bindValue(':citKeyWords', $citKeyWords , PDO::PARAM_STR);
			$query_keyWords->bindValue(':dataKeyWords', dataExata() , PDO::PARAM_STR);
			$query_keyWords->execute();
			
		}catch(PDOException $erro_enviarKeyWords)
		{
			echo 'Erro ao enviar key words';
		}
}

?>