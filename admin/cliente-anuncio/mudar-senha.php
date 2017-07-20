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
		
		$resutadoSenha = sds_atualizaSenha($idCliente, $senhaAtual, $senhaNova, $senhaNovaRepita);
	}
?>

<?php 

$idAnuncio = sds_selectPainel($idCliente);
$idAnuncio = explode("::", $idAnuncio);
$idAnuncio = $idAnuncio[4];

// LISTAR IMAGEM DO PERFIL
$imagemPerfil      = 'http://saldaodeservicos.com/img/uploads/'. md5($email).'/thumbs/'.md5($email).'_thumb_profile_userImage.jpg';

if(isset($_POST['bt-salva-foto'])){			
	salvaImagemPerfil($idAnuncio);
}

if($nivelAcesso == 'cliente'){
?>
	<div id="anuncio-patrocinado">
	
	</div><!--FECHA ANUNCIO PATROCINADO -->

<?php	
}
?>

<article class="container">
<br>
    <h4>Minha conta </h4>
    <h5>Sua privacidade é muito importante para nós! Fique tranquilo, seus dados não serão divulgados a terceiros!</h5>

    <div class="container-profile-picture"><br>
        
        <h5>Foto do perfil</h4>            
      
        <div class="panel-profile-picture">
    
        <form method="POST" enctype="multipart/form-data">
            
<?php
                if(verificar_urlAdmin($idAnuncio, 'profile')){?>
                    <img src="<?php echo $imagemPerfil; ?>" width="160" height="160" name="foto-1" />
               <?php }else{ ?>
                    <img src="<?php echo URL::getBase() ?>images/sem_imagens.png" width="160" height="93"  />       
<?php          } ?>
            
    </div>

            <input id="fakeupload" name="fakeupload3" class="fakeupload" type="text" placeholder="Selecionar uma imagem" />
            <input id="realupload" name="userImage" class="realupload" type="file" onchange="this.form.fakeupload3.value = this.value;"/>   
          <input type="submit" class="btn-primary btn-profile-picture" name="bt-salva-foto" value="Salvar foto" />
            
            <a href="<?php echo URL::getBase() ?>painel/conta"><h5>Minha conta</h5></a>
            <a href="<?php echo URL::getBase() ?>painel/conta/mudar-senha"><h5>Mudar senha</h5></a><br>

            <a data-toggle="modal" href="#" data-target="#desativar-conta">
                <input type="button" class="btn btn-primary" value="[ Desativar conta ]"  />
            </a>

            <div class="modal hide fade" id="desativar-conta">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Desativar conta</h3>
                </div>
             
                <div class="modal-body">
                    <div class="description-msg">
                        <h5>Você tem certeza que desejar desativar sua conta ? </h5>
                    </div>

                </div>
             
                <div class="modal-footer">
                    <form  method="post" enctype="multipart/form-data">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                        <input type="submit" class="btn btn-primary" name="desativar-conta" value="Desativar conta"  />
                    </form>
                </div>
            </div>     
        </form>       
    </div>
            
  	<div class="my-account">      
       <span style="float:left; width:250px; background:#03F; color:#fff; font:14px Arial, Helvetica, sans-serif;" >	
        <?php 	
			echo $resutadoSenha		
		?>
        
        </span>
        
        <form  method="post" enctype="multipart/form-data">
        	<h5>Senha atual: </h5>
    		<input type="password" required name="senha-atual" />
            <h5>Nova senha: </h5>
            <input type="password" required name="senha-nova" />
            <h5>Repita nova senha: </h5>
	        <input type="password" required name="senha-nova-repita" />  
            <input type="submit" name="envia-nova-senha" value="Mudar senha" class="btn btn-primary " style="float:right; margin-right:40px;" />  	    
        </form>
	</div>
</article>
<br>

<?php include_once("footer.php"); ?>