<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
 
<?php

if($nivelAcesso == 'admin'){

?>

<?php include_once("header.php"); ?>
	
    <article class="container-principal">
    	
        <div class="carregando">
        	 <h2>Suporte ao cliente</h2>
        </div>
    </article><!-- FECHA CONTAINER PRINCIPAL -->
  
<?php

}else{
include "deslogar.php";
}
 
?>
<?php include_once("footer.php"); ?>