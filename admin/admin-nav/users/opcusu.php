<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>

<?php

if($nivelAcesso == 'cliente'){

?>

<meta http-equiv="refresh" name="Refresh" content="0; URL=../index.php">
    
<?php

}elseif($nivelAcesso == 'admin'){

 
?>    

<?php include_once("header.php"); ?>    
    
    <article class="container-principal">
    	<div id="gerenciador">
        	<h2>Opções de usuários</h2>
    
            <ul>
                <a href="#"><li>Criar novo usuário</li></a>
            </ul>
		</div><!-- FECHA GERENCIADOR -->        
    </article><!-- FECHA CONTAINER PRINCIPAL -->

<?php
} 
?>

<?php include_once("footer.php"); ?>