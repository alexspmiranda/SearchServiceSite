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

<h2>Meu anúncio </h2>
<h5 class="sub-titulo">Confira nossa sessão de <a href="#">dicas</a> para saber como criar um bom anúncio do seu serviço. <a href="#">Clique aqui</a> </h5>

<div class="meu-anuncio-midia">

	<h3> Fotos do Anúncio </h3>
   
   <form method="post" enctype="multipart/form-data">
	<label>	<input type="file" name="userImage" /></label>
    
    <label>	<input type="file" name="userImage1" /></label>
    <label>	<input type="file" name="userImage2" /></label>
    <label>	<input type="file" name="userImage3" /></label>
    <label>	<input type="file" name="userImage4" /></label>
    <label>	<input type="file" name="userImage5" /></label>
    
    <input type="submit" name="envia-blob" />	

	</form>
    
    <?php
		if(isset($_POST['envia-blob'])){
			
			salvaImagemPerfil($idAnuncio);
			salvaImagemAnuncioUm($idAnuncio);
			salvaImagemAnuncioDois($idAnuncio);
			salvaImagemAnuncioTres($idAnuncio);
			salvaImagemAnuncioQuatro($idAnuncio);
			salvaImagemAnuncioCinco($idAnuncio);
			
		}
		listaImagem($idAnuncio)
	?>
</div> 

<?php include_once("footer.php"); ?>