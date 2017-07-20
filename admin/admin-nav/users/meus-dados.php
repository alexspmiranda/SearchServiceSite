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
    <article class="container">
    	<div class="user-admin-manager">
        	<h4>Opções de usuário</h4>
    
            <ul class="inline unstyled">
                <a href="painel.php?exe=admin-nav/users/mudar-senha"><li>Mudar senha</li></a>
                <a href="#"><li>Novo usuário</li></a>
            </ul>
		</div>       
    </article>

<?php
} 
?>

<?php include_once("footer.php"); ?>