<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>

<?php include_once("header.php"); ?>

<article class="container">  
    <div class="painel-controle" style="clear:both;">
        <br><h4>Painel de controle</h4><br>
        
<?php 

        $resultado_consultaCadastro = sds_selectAnuncioPainel($idCliente);
        
        foreach($resultado_consultaCadastro as $res_consultaCadastro){
            $idAnuncio          = $res_consultaCadastro['idAnuncio'];
            $anuncioNome        = $res_consultaCadastro['nomeFantasiaAnuncio'];
            $anuncioTitulo      = $res_consultaCadastro['tituloAnuncio'];
            $anuncioPreco       = $res_consultaCadastro['precoAnuncio'];
            $anuncioUrl         = $res_consultaCadastro['urlAnuncio'];
            $linkPessoalAnuncio = $res_consultaCadastro['linkPessoalAnuncio'];

            
            if(empty($anuncioPreco)){
                $anuncioPreco = 'À negociar';   
            }else{
                $anuncioPreco = 'R$ '.$anuncioPreco;
            }
        }
        
        $resultado_consultaCadastro =  sds_selectMeusDados($idCliente);

        foreach($resultado_consultaCadastro as $res_consultaCadastro){
            $emailAnunciante    = $res_consultaCadastro['email'];
            $clienteStatus      = $res_consultaCadastro['status'];
        }
?>
        <span style="padding:5px; border:1px solid #ccc; float:left; margin:10px; clear:both;">

<?php
        $imagem_um  = 'http://saldaodeservicos.com/img/uploads/'. md5($emailAnunciante).'/thumbs/'.md5($emailAnunciante).'_thumb_userImage1.jpg';

        if(verificar_urlAdmin($idAnuncio, '1')){?>			
            <img src="<?php echo $imagem_um; ?>" width="165" height="93" />
		<?php }else{?> 
            <img src="<?php echo URL::getBase() ?>img/others/sem_imagens.png" width="165" height="93"  />				
<?php 
        }
?>
        </span>
        
        <span style="float:left;">
            <h5 style=" margin:0 10px;"><?php echo $anuncioNome; ?></h5>
            <h5 style="clear:both; margin:0 10px;"><?php echo $anuncioTitulo; ?></h5>
            <h5 style="clear:both;margin:10px;">
            <?php if(!empty($anuncioPreco)){
                echo 'Preço:'. $anuncioPreco .'</h5>';
            }else{
                echo 'Preço: Não cadastrado';   
            } ?>
            

            <h5 style="margin:10px;">

            <?php if(sds_selectVerificaVisitaPainel($idCliente) != 0){
                echo 'Nº visitas: '. sds_selectVerificaVisitaPainel($idCliente) .'</h5>';
            }else{
                echo 'Nº visitas: Nenhuma visualização';
            } ?>
            
            <h5 style="float:left; margin-left:5px;"><a href="<?php echo URL::getBase() ?>painel/anuncio">[ editar anúncio ]</a></h5>
<?php
		
        if($clienteStatus == 'desativado' || $clienteStatus == 'aguardando' ){?>

            <h5 style="float:left; margin-left:5px; color:#ccc;">[ ver meu anúncio ]</h5>

<?php   }else{ ?>

            <h5 style="float:left; margin-left:5px;"><a href="<?php echo URL::getBase() ?>../anuncio/<?php echo $anuncioUrl ?>" target="_blank"> [ ver meu anúncio ]</a></h5>
<?php 
        } 
?>
        </span>	
    </div>

    <div class="res-msg ">
        <h4>Mensagens recentes</h4>

        <div class="msg">
            <ul>
<?php
            $pag = strip_tags(trim("$_GET[pag]"));
            if($pag >= '1'){
             $pag = $pag;
            }else{
             $pag = '1';
            }

            $maximo = '4'; 
            $inicio = ($pag * $maximo) - $maximo;
            $resultado_inboxCliente = sds_selectInbox($idCliente, $inicio, $maximo);

            if(empty($resultado_inboxCliente)){
                echo '<li>Nenhuma mensagem recente</li>';
            }

            foreach($resultado_inboxCliente as $res_inboxCliente){
                $idMensagem        = $res_inboxCliente['idMensagem'];
                $mensagemUsuario   = $res_inboxCliente['mensagemUsuario'];
                $i++;   
            ?> 
                <a href="<?php echo URL::getBase() ?>painel/inbox/resposta?emailId=<?php echo $idMensagem;?>">
                    <li><?php echo substr($mensagemUsuario,0, 47); echo '...' ?></li>
                </a>
<?php
            }
?>    
            </ul>
        </div>
        <h5 style="text-align:right;"><a href="<?php echo URL::getBase() ?>painel/inbox/">Ver todos</a></h5>
    </div>

</article><!-- FECHA CONTAINER PRINCIPAL -->

<?php if(!empty($linkPessoalAnuncio)){?>
<div class="container">
    <span class="link">
        <h4>Compartilhe seu link com os seus amigos:</h4>    
        <a href="<?php echo URL::getBase() ?>../<?php echo $linkPessoalAnuncio; ?>" target="_blank">http://saldaodeservicos.com/<?php echo $linkPessoalAnuncio; ?></a>
    </div>
</span>

<br>
<?php 
}
include_once("footer.php"); 
?>