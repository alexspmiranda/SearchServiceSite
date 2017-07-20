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
	<h2> Suporte </h2>
    
    <article class="container-principal" style="clear:both; margin-left:30px;">
		
    	<div id="carregando">            
                        
        </div><!-- FECHA CARREGANDO -->
    </article><!-- FECHA CONTAINER PRINCIPAL -->

<?php include_once("footer.php"); ?>