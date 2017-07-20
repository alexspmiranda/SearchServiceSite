<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
<?php include_once("header.php"); ?>    

<?php 

if($nivelAcesso == 'cliente'){
?>
	<div id="anuncio-patrocinado">
	
	</div><!--FECHA ANUNCIO PATROCINADO -->

<?php	
}
?>
	
<article class="container">
	<h4>Minhas avaliações</h4>
		<div class="ratings coments-panel">
        	<ul class="unstyled">
<?php

	$resultado_buscaComentarios = sds_buscaComentarios($idCliente);
	
	$cont=0;
	foreach($resultado_buscaComentarios as $res_buscaComentarios){
		$mensagem 		= $res_buscaComentarios['mensagemAvaliacao'];
		$voto 			= $res_buscaComentarios['votos'];
		$nomeCliente 	= $res_buscaComentarios['nome'];
		
	if($mensagem == NULL){
		$mensagem = 'O usuário não deixou nenhum comentário.';
	}
	
	if($voto == '1'){
		$titulo = 'Péssimo, não recomendo a ninguém';
	}elseif($voto == '3'){
		$titulo = 'Não gostei!';
	}elseif($voto == '3'){
		$titulo = 'Razoável.';
	}elseif($voto == '4'){
		$titulo = 'Bom, recomendo.';
	}elseif($voto == '5'){
		$titulo = 'Muito bom, aconselho à todos!';
	}
	
?>
		<li> 
			<span class="nome"><?php echo  $nomeCliente; ?></span> 
			
			<span class="avaliacao">
				<form style="display:none" title="Average Rating: <?=$voto?>" class="rating">
					<input type="hidden" name="valor" value="1" />
					<select id="r1">
						<option value="1#<?php echo $idCliente; ?>">1</option>
						<option value="2#<?php echo $idCliente; ?>">2</option>
						<option value="3#<?php echo $idCliente; ?>">3</option>
						<option value="4#<?php echo $idCliente; ?>">4</option>
						<option value="5#<?php echo $idCliente; ?>">5</option>
					</select>
				</form>
				<span id="rate-fake"> rating</span>
			</span> 
		
			<li><?php echo '<strong>'.$titulo.'</strong>'; ?></li>
			<li><?php echo $mensagem; ?></li> 
		</li><br>

<?php $cont++; }
	
	if($cont == 0){
	?>
	
		<li><span class="titulo">Nenhum comentário encontrado.</span></li>
	
	<?php 	
	}
?> 	   
			</ul>

		</div>
 </article>

<?php include_once("footer.php"); ?>