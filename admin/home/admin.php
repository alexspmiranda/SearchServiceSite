<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>

<?php

if($nivelAcesso == 'cliente'){

?>

<meta http-equiv="refresh" name="Refresh" content="0; URL=../index.php">
    
<?php

}elseif($nivelAcesso == 'admin'){

include_once("header.php");

?>    
    
    <article class="container-principal">
    	<div id="gerenciador">

				

		</div><!-- FECHA GERENCIADOR -->        
    </article><!-- FECHA CONTAINER PRINCIPAL -->

<?php
} 
?>

<?php include_once("footer.php"); 

?>