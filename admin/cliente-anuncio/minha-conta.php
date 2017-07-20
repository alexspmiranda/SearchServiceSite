<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
<?php include_once("header.php"); ?>


<?php
	
$resultado_consultaCadastro =  sds_selectMeusDados($idCliente);

foreach($resultado_consultaCadastro as $res_consultaCadastro){
	$clienteId     = $res_consultaCadastro['clienteId'];
	$clienteNome   = $res_consultaCadastro['nome'];
	$clienteCpf    = $res_consultaCadastro['cpfCnpj'];
	$clienteSexo   = $res_consultaCadastro['sexo'];
	$clienteEmail  = $res_consultaCadastro['email'];
	$clienteStatus = $res_consultaCadastro['status'];
	$clientePlano  = $res_consultaCadastro['plano'];
}

$idAnuncio = sds_selectPainel($idCliente);
$idAnuncio = explode("::", $idAnuncio);
$idAnuncio = $idAnuncio[4];

if(isset($_POST['salvar-cadastra-cliente'])){
	sds_atualizaDadosPessoais($idCliente, $clienteNome, $clienteCpf, $clienteSexo, $clienteEmail);
	echo '<meta http-equiv="refresh" name="Refresh" content="0;">';
}

if(isset($_POST['bt-salva-foto'])){			
	salvaImagemPerfil($idAnuncio, $email);
}


if($nivelAcesso == 'cliente'){
?>
	<!--<div id="anuncio-patrocinado">
	
	</div><!--FECHA ANUNCIO PATROCINADO -->

<?php	
}

$imagemPerfil      = 'http://saldaodeservicos.com/img/uploads/'. md5($email).'/thumbs/'.md5($email).'_thumb_profile_userImage.jpg';

?>

<?php //	include_once("right_sidebar.php"); ?>
	    
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
                    <img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="160" height="93"  />				
<?php          } ?>
        		
		</div>

            <input id="fakeupload" name="fakeupload3" class="fakeupload" type="text" placeholder="Selecionar" />
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
             
        
            
<?php 
            
        // if($clienteStatus == 'desativado'){
        //     echo '<h5 style="color:red; margin-top  :15px; background:#fff; float:left; width:;">
        //     Seu status está como '.$clienteStatus.'. <br />
        //     Para ativa-lo você precisará publicar o seu anúncio.
        //     Publique <a href="http://saldaodeservicos.com/admin/painel/anuncio/">clicando aqui.</a></h5>'; 
        // }elseif($clienteStatus == 'aguardando'){
        //     echo '<h5 style="color:blue; margin-top:15px; background:#fff; float:left; width:650px;">
        //     Parabéns! Você publicou seu anúncio e agora está '.$clienteStatus.' a aprovação. <br />
        //     Em breve seu anúncio estará no ar, boa sorte.<br /></h5>';   
        // }            
?>       
<div class="my-account">
            <form method="post" enctype="multipart/form-data">
                
                <h5>Nome: </h5>
                <input type="text" name="nome-completo" value="<?php echo $clienteNome; ?>" required />

                <h5>CPF: </h5>
                    <?php if(empty($clienteCpf)){ ?>
                        <input type="text" name="cpf-cnpj" pattern="[0-9]{11}" maxlength="11" class="cpf_cnpj" placeholder="12345678910 (Só números)" value="<?php echo $clienteCpf; ?>" size="30" />
                    <?php }else{
                        echo '<input type="text" name="cpf-cnpj" pattern="[0-9]{11}" maxlength="11" class="cpf_cnpj" readonly="readonly" placeholder="12345678910 (Só números)" value="'. $clienteCpf .'" size="30" required />';
                    }?>
                <h5>Sexo: </h5>
                <select name="sexo" required >
                    <option value="<?php echo $clienteSexo; ?>" value="<?php echo $clienteSexo; ?>" selected>
                
                    <?php echo $clienteSexo; ?></option>
                            
                    <option name="Masculino" value="Masculino">Masculino</option>
                    <option name="Feminino" value="Feminino">Feminino</option>
                
                </select>

                <h5>Email: </h5>
                <input type="text" required name="email" value="<?php echo $email; ?>" readonly="readonly" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" size="35"  style="border:0;"/>
        </div>
        
        <div class="my-account" style="width:120px;">      
            <h5>Status: </h5>                            
            <span style="margin:0; padding:0; font:14px Arial, Helvetica, sans-serif; float:left; clear:both;">
            <?php echo $clienteStatus; ?>
            </span>                        
<?php 
    
                if($clienteStatus == "patrocinado"){
?>      

                    <h5 style="margin-top:10px;">Plano: </h5>
                    <input type="text" required name="status" class="input-mini" value="<?php echo $clientePlano; ?>" readonly="readonly" size="10"  style="border:0; float:left;"/>
<?php
                }                        
?>                
            <input type="submit" name="salvar-cadastra-cliente" value="Salvar dados" class="btn btn-primary" style="clear:both; float:right; margin:160px 0 0 0;" />  
            </form>               
            </div>
        </div>
    </div><!-- FECHA MINHA CONTA -->
</article><!-- FECHA CONTAINER PRINCIPAL -->

    
	<?php
		if(isset($_POST['desativar-conta'])){
			sds_updateDesativarConta($idCliente);
		}
	?>
<?php include_once("footer.php"); ?>

