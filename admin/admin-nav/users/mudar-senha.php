<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
<?php include_once("header.php"); ?>

<?php
	
	include "../Connections/config.php";
	
	if(isset($_POST['envia-nova-senha'])){
		
		$senhaAtual =  strip_tags(trim($_POST['senha-atual'])).''.$email;
		$senhaAtual = sha1(md5($senhaAtual));
		$senhaNova =  strip_tags(trim($_POST['senha-nova'])).''.$email;
		$senhaNova = sha1(md5($senhaNova));
		$senhaNovaRepita = strip_tags(trim($_POST['senha-nova-repita'])).''.$email;
		$senhaNovaRepita = sha1(md5($senhaNovaRepita));
			
		$resultadoMudaSenha = sds_atualizaSenha($idCliente, $senhaAtual, $senhaNova, $senhaNovaRepita);

	}
?>

<?php 

if($nivelAcesso == 'cliente'){
?>
	<div id="anuncio-patrocinado">
	
	</div><!--FECHA ANUNCIO PATROCINADO -->

<?php	
}
?>
	
    <article class="container">
       	<div class="user-admin-manager">
       
       <span style="float:left; width:250px; background:#03F; color:#fff; font:14px Arial, Helvetica, sans-serif;" >	
        <?php 	
				echo $resultadoMudaSenha;
		?>
        
        </span>
        
        	<h4>Mudar senha</h4>
            
            <form  method="post" enctype="multipart/form-data">
            	<h5>Senha atual: </h5>
            		<input type="password" required name="senha-atual" />
                    <h5>Nova senha: </h5>
	                    <input type="password" required name="senha-nova" />
    		                <h5>Repita nova senha: </h5>
            			        <input type="password" required name="senha-nova-repita" />  <br>
                        			<input type="submit" name="envia-nova-senha" class="btn btn-primary" value="Mudar senha" />  	    
            </form>
        </div><!-- FECHA MUDAR SENHA -->
    </article><!-- FECHA CONTAINER PRINCIPAL -->

<?php include_once("footer.php"); ?>