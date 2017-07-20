<div id="box">

<?php include_once("sidebar_contato.php"); ?>

<article id="central-contato">
	<form name="fale_conosco" method="POST" action=""  enctype="multipart/form-data">
    
    <?php
		
		if(isset($_POST['contato_site'])){
			
			$contatoNome = strip_tags(trim($_POST['nome']));
			$contatoEmail = strip_tags(trim($_POST['email']));
			$contatoAssunto = strip_tags(trim($_POST['assunto']));
			$contatoMensagem = strip_tags(trim($_POST['mensagem']));
			$dataMensagem = date('Y-m-d H-i-s');
			$codData = date('d-H-i');
			$codMensagem = $codData.'-'.$contatoEmail;
			$statusMensagem = 'pendente';
			
			$sql_verificaContato = 'SELECT contatoCod FROM sds_contato WHERE contatoCod = :contatoCod';
			
			try{
				
				$query_verificaContato = $connect->prepare($sql_verificaContato);
				$query_verificaContato->bindValue(':contatoCod', $codMensagem ,PDO::PARAM_STR);
				$query_verificaContato->execute();
				
				$conta_verificaContato = $query_verificaContato->rowCount(PDO::PARAM_STR);
				
			}catch(PDOException $erro_verificaContato){
				
				echo 'Erro ao selecionar o código da mensagem.';
			
			}
if($conta_verificaContato >= 1){
		$aguarde_instantes = '<div id="envioMsg">Por favor aguarde alguns instantes para enviar uma nova mensagem.</div>';
}else{
		
		$sql_contatoSite = 'INSERT INTO sds_contato(contatoNome, contatoEmail, contatoAssunto, contatoMensagem, dataMensagem, statusMensagem, contatoCod)';	
		$sql_contatoSite .= 'VALUES (:contatoNome,:contatoEmail,:contatoAssunto,:contatoMensagem,:dataMensagem,:statusMensagem,:contatoCod)';
		
		try{
			
			$query_contatoSite = $connect->prepare($sql_contatoSite);
			$query_contatoSite->bindValue(':contatoNome', $contatoNome , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':contatoEmail', $contatoEmail , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':contatoAssunto', $contatoAssunto, PDO::PARAM_STR );
			$query_contatoSite->bindValue(':contatoMensagem', $contatoMensagem , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':dataMensagem', $dataMensagem , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':statusMensagem', $statusMensagem , PDO::PARAM_STR );
			$query_contatoSite->bindValue(':contatoCod', $codMensagem , PDO::PARAM_STR );
			$query_contatoSite->execute();
			
			$msg_sucesso = '<div id="envioMsg">Mensagem enviada com sucesso!.</div>';
			
		}catch(PDOException $erro_cadastraMensagem){
			$erro_enviar = 'Erro ao enviar a mensagem';
		}
}
			
		}
	?>
                    <h3>Nome: </h3><br>
                        <input type="text" name="nome" />
                    <h3>E-mail: </h3><br>
                        <input type="text" name="email" />
                    <h3>Assunto: </h3>
                        <input type="text" name="assunto" /><br><br><br>
                       		<h3>Mensagem: </h3>
                        		<textarea  type="text" name="mensagem"></textarea><br><br><br>	
	                        				<input type="submit" value="Enviar" name="contato_site" id="submit" />
            </form><br>

			<?php            
            echo $erro_enviar;
            echo $aguarde_instantes;
            echo $msg_sucesso;
			?>
</article>
</div>