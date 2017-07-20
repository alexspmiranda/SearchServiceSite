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
<?php 
	//EXCLUI AS MENSAGENS
	
	if(isset($_POST['excluir-mensagem'])){
		$idMensagemExcluir = strip_tags(trim($_POST['idMensagem']));
		$excluidoSucesso = sds_deleteExcluiMensagens($idMensagemExcluir);
	}
if(!empty($excluidoSucesso)){ ?>
	<span style="float:left; width:99%; background:#06C; font:14px Arial, Helvetica, sans-serif; color:#fff; padding:5px; margin-bottom:10px; text-align:center;">

			<?php echo $excluidoSucesso ?>

	</span>';
    
<?php } ?>

<div class="container">
    <br><br>
    <h4>Mensagens respondidas</h4>
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
   
    <div class="row-fluid menu-answers">            
            
        <ul class="inline unstyled">
            <li class="span2 text-center">NOME:</li>
            <li class="span2 text-center">EMAIL:</li>
            <li class="span4 text-center">MENSAGEM:</li>
            <li class="span2 text-center">DATA:</li>
            <li class="span2 text-center">EXCLUIR:</li>
        </ul>
    </div>
            
            <?php
            
			$pag = strip_tags(trim("$_GET[pag]"));
			if($pag >= '1'){
			 $pag = $pag;
			}else{
			 $pag = '1';
			}
			
			$maximo = '20'; //RESULTADOS POR PÁGINA
			$inicio = ($pag * $maximo) - $maximo;

				$resultado_respondidosCliente = sds_selectRespondidos($idCliente, $inicio, $maximo);

            foreach($resultado_respondidosCliente as $res_inboxCliente){
				$idMensagem        = $res_inboxCliente['idMensagem'];
				$nomeUsuario       = $res_inboxCliente['nomeUsuario'];
				$emailUsuario      = $res_inboxCliente['emailUsuario'];
				$mensagemUsuario   = $res_inboxCliente['mensagemUsuario'];
				$statusMensagem    = $res_inboxCliente['statusMensagem'];
				$dataMensagem      = $res_inboxCliente['dataMensagem'];
            
                    $i++;
                    if($i % 2 == 0){
                        $cor = 'style="background:#f4f4f4; border-bottom:1px solid #999;"';
                    }else{
                        $cor = 'style="background:#f4f4f4; border-bottom:1px solid #999;"';
                    }
            
            ?>  
    
    <div class="row-fluid inbox">
        <ul class="inline unstyled">
            <a href="<?php echo URL::getBase() ?>painel/inbox/resposta?emailId=<?php echo $idMensagem;?>">
                <li class="span2 text-center"><?php echo substr($nomeUsuario,0, 25); echo '...'; ?></li>
                <li class="span2 text-center"><?php echo substr($emailUsuario,0, 25); echo '...'; ?></li>
                <li class="span4 text-center"><?php echo substr($mensagemUsuario,0, 35); echo '...' ?></li>
                <li class="span2 text-center"><?php $dataMensagem; echo date('d/m/Y', strtotime($dataMensagem))?></li>
            </a>
            
            <li class="span2 text-center"><a href="#">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="idMensagem" value="<?php echo $idMensagem; ?>" />
                    <input type="submit" value="Excluir" class="btn btn-primary" name="excluir-mensagem" />
                </form>
            </li>
        </ul>              
<?php
}
?>
    </div>
        
    </article>

<?php include_once("footer.php"); ?>