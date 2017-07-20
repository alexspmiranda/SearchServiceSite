<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
<?php include_once("header.php"); ?>    


<?php 

if($nivelAcesso == 'cliente'){

?>
	
<div class="container">
    <nav class="notice-submenu">
        <ul class="inline unstyled">
            <li class="btn btn-primary"><a href="<?php echo URL::getBase() ?>painel/inbox/"> Minhas mensagens</a></li>
            <li class="btn btn-primary"><a href="<?php echo URL::getBase() ?>painel/inbox/respondidos">Mensagens respondidas</a></li>
        </ul>
    </nav>
        
    <form name="s_emailAdmin" action="<?php echo URL::getBase() ?>painel/inbox/search" class="s_emailAdmin" enctype="multipart/form-data" method="post">
        <label>
            <input type="text" required name="busca" size="50" />
            <input type="submit" name="executar" class="btn btn-primary btn-search" value="Pesquisar" />
        </label>
    </form>
</div>
        
<article class="container-fluid">
    <div class="row-fluid">            
            
        <ul class="inline unstyled">
            <li class="span2 text-center">NOME:</li>
            <li class="span2 text-center">EMAIL:</li>
            <li class="span4 text-center">MENSAGEM:</li>
            <li class="span2 text-center">DATA:</li>
            <li class="span2 text-center">EXCLUIR:</li>
        </ul>
    </div>
            
            <?php
            $contatoNome = strip_tags(trim($_POST['busca']));
			
            $resultado_searchAdmin = sds_selectSearch($contatoNome);
			
			$cont = 0;
			foreach($resultado_searchAdmin as $res_searchAdmin){
				$emailId        = $res_searchAdmin['idMensagem'];
				$emailNome      = $res_searchAdmin['nomeUsuario'];
				$emailEmail     = $res_searchAdmin['emailUsuario'];
				$emailMensagem  = $res_searchAdmin['mensagemUsuario'];
				$emailData      = $res_searchAdmin['dataMensagem'];
				$i++;
				if($i % 2 == 0){
					$cor = 'style="background:#D9D9D9"';
				}else{
					$cor = 'style="background:#f4f4f4;"';
				}
		
            ?>  
            <div class="row-fluid inbox">
                <ul class="inline unstyled">
                    <a href="<?php echo URL::getBase() ?>painel/inbox/resposta?emailId=<?php echo $emailId;?>">
                        <li class="span2 text-center"><?php echo $emailNome; ?></li>
                        <li class="span2 text-center"><?php echo $emailEmail; ?></li>
                        <li class="span4 text-center"><?php echo substr($emailMensagem,0, 35); echo '...' ?></li>
                        <li class="span2 text-center"><?php $emailData; echo date('d/m/Y', strtotime($emailData))?></li>
                    </a>
            
                    <li class="span2 text-center"><a href="#">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idMensagem" value="<?php echo $idMensagem; ?>" />
                            <input type="submit" value="Excluir" class="btn btn-primary" name="excluir-mensagem" />
                        </form>
                    </li>
                </ul>  

            <?php
            $cont++;
			}
			
			if($cont == 0){
				echo '<H4>&nbsp;NENHUM RESULTADO ENCONTRADO</H4>'; 
			}
            ?> 
                
            </div>
        </div><!-- FECHA CARREGANDO -->
</article><!-- FECHA CONTAINER PRINCIPAL -->

<?php 
}
?>
<?php include_once("footer.php"); ?>