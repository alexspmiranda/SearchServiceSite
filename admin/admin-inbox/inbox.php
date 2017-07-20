<?php include_once("sistema/restrito_admin.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
   

<?php

if($nivelAcesso == 'admin'){

?>

<?php include_once("header.php"); ?>
	
    <article class="container-principal">

		<h2> Mensagens </h2>
        
        <nav>
        	<ul>
                <li class="submenu"><a href="painel.php?exe=admin-inbox/inbox"> Mensagens do site 
                        <?php if(sds_mensagemSite() > 0){?>
                            <div class="notifica-circulo"><?php echo sds_mensagemSite(); ?></div>
                        <?php } ?>
                </a></li>
                
                <li class="submenu"><a href="painel.php?exe=admin-inbox/respondidos"> Mensagens respondidas </a></li>
            </ul>
        </nav>
        
        <form name="s_emailAdmin" action="painel.php?exe=admin-inbox/search" id="s_emailAdmin" enctype="multipart/form-data" method="post">
            <label>
            <input type="text" name="busca" size="50" />
            <input type="submit" name="executar" id="executar" value="Pesquisar pelo nome" />
            
            </label>
        </form>
        
        
    	<div class="carregando">            
            
            <ul id="cabecalho-email" style="color:#fff;">
                <li style="width:130px;">NOME:</li>
                <li style="width:227px;">EMAIL:</li>
                <li style="width:285px;">ASSUNTO:</li>
                <li style="width:80px;">DATA:</li>
            </ul>
            
            <?php
            
				$pag = strip_tags(trim("$_GET[pag]"));
				if($pag >= '1'){
				 $pag = $pag;
				}else{
				 $pag = '1';
				}
			
                $resultado_inboxAdmin = sds_selectResultadoInbox($pag);
				
				$cont = 0;
                foreach($resultado_inboxAdmin as $res_inboxAdmin){
                    $emailId        = $res_inboxAdmin['contatoId'];
                    $emailNome      = $res_inboxAdmin['contatoNome'];
                    $emailEmail     = $res_inboxAdmin['contatoEmail'];
                    $emailAssunto     = $res_inboxAdmin['contatoAssunto'];
                    $emailMensagem  = $res_inboxAdmin['contatoMensagem'];
                    $emailData      = $res_inboxAdmin['dataMensagem'];
                    $statusMensagem    = $res_inboxAdmin['statusMensagem'];
                    $emailResposta  = $res_inboxAdmin['respostaMensagem'];
                    $i++;
                    if($i % 2 == 0){
                        $cor = 'style="background:#D9D9D9"';
                    }else{
                        $cor = 'style="background:#f4f4f4;"';
                    }
					
					sds_mensagemSiteLido();
            
            ?>  
    
              <a href="painel.php?exe=admin-inbox/resposta&emailId=<?php echo $emailId;?>">
                  <ul <?php echo $cor;?> id="email-mensagens">
                    <li style="width:130px;"><?php echo $emailNome; ?></li>
                    <li style="width:227px;"><?php echo $emailEmail; ?></li>
                    <li style="width:285px;"><?php echo substr($emailAssunto,0, 25); echo '...' ?></li>
                    <li style="width:80px;"><?php $emailData; echo date('d/m/Y', strtotime($emailData))?></li>
                  </ul>
             </a>
              
            <?php
			$cont++;
            }
			if($cont == 0){
				echo '<H4>&nbsp;NÃO HÁ E-MAIL NA CAIXA DE ENTRADA</H4>';
			}
            ?> 
            
            <?php
				
				//USE A MESMA SQL QUE QUE USOU PARA RECUPERAR OS RESULTADOS
				//SE TIVER A PROPRIEDADE WHERE USE A MESMA TAMBÉM
				$sql_res = 'SELECT * FROM sds_contato WHERE statusMensagem = :statusMensagem';
	
				try{
					$query_res = $connect->prepare($sql_res);
					$query_res->bindValue(':statusMensagem',$statusMensagem,PDO::PARAM_STR);
					$query_res->execute();
					
					$total = $query_res->rowCount(PDO::FETCH_ASSOC);
					
				}catch(PDOexception $error_res){
				   echo 'Erro ao selecionar pendentes';
				}
								
				$paginas = ceil($total/10);
				$links = '4'; //QUANTIDADE DE LINKS NO PAGINATOR
				
				if($total > 0){
				
				echo "
				
				<h5>
				
				<a href=\"painel.php?exe=admin-inbox/inbox&amp;pag=1\">Primeira Página</a>&nbsp;&nbsp;&nbsp;";
				
				for ($i = $pag-$links; $i <= $pag-1; $i++){
				if ($i <= 0){
				}else{
				echo"<a href=\"painel.php?exe=admin-inbox/inbox&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;";
				}
				}echo "$pag &nbsp;&nbsp;&nbsp;";
				
				for($i = $pag +1; $i <= $pag+$links; $i++){
				if($i > $paginas){
				}else{
				echo "<a href=\"painel.php?exe=admin-inbox/inbox&amp;pag=$i\">$i</a>&nbsp;&nbsp;&nbsp;";
				}
				}
				echo "<a href=\"painel.php?exe=admin-inbox/inbox&amp;pag=$paginas\">Última página</a>&nbsp;&nbsp;&nbsp;
				
				</h5>
				";
				}
				?>
        </div><!-- FECHA CARREGANDO -->
    
    </article><!-- FECHA CONTAINER PRINCIPAL -->
  
<?php

}else{
include "deslogar.php";
}
 
?>
<?php include_once("footer.php"); ?>