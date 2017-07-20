<?php include_once("sistema/restrito_admin.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
<?php include_once("header.php"); ?>
	
    <article class="container-principal">
    	<?php include_once("sistema/carregando.php"); ?>
        
        <form name="s_emailAdmin" action="painel.php?exe=admin-inbox/search" id="s_emailAdmin" enctype="multipart/form-data" method="post">
            <label>
            <input type="text" name="busca" size="50" />
            <input type="submit" name="executar" id="executar" value="Pesquisar pelo nome" />
            
            </label>
        </form>
        
    	<div id="carregando">            
            
            <ul id="cabecalho-email" style="color:#fff;">
                <li style="width:130px;">NOME:</li>
                <li style="width:227px;">EMAIL:</li>
                <li style="width:285px;">ASSUNTO:</li>
                <li style="width:80px;">DATA:</li>
            </ul>
            
            <?php
            $contatoNome = strip_tags(trim($_POST['busca']));
			$contatoEmail = $contatoNome;
			
			$resultado_searchAdmin = sds_selectSearchInbox($contatoNome, $contatoEmail);
			
			$cont = 0;
			foreach($resultado_searchAdmin as $res_searchAdmin){
				$emailId        = $res_searchAdmin['contatoId'];
				$emailNome      = $res_searchAdmin['contatoNome'];
				$emailEmail     = $res_searchAdmin['contatoEmail'];
				$emailAssunto   = $res_searchAdmin['contatoAssunto'];
				$emailMensagem  = $res_searchAdmin['contatoMensagem'];
				$emailData      = $res_searchAdmin['dataMensagem'];
				$statusMensagem = $res_searchAdmin['statusMensagem'];
				$emailResposta  = $res_searchAdmin['respostaMensagem'];
				$i++;
				if($i % 2 == 0){
					$cor = 'style="background:#D9D9D9"';
				}else{
					$cor = 'style="background:#f4f4f4;"';
				}
            
            ?>  
    
              <a href="painel.php?exe=admin-query_searchAdmin/resposta&emailId=<?php echo $emailId;?>">
                  <ul <?php echo $cor;?> id="email-mensagens">
                    <li style="width:130px;"><?php echo $emailNome; ?></li>
                    <li style="width:227px;"><?php echo $emailEmail; ?></li>
                    <li style="width:285px;"><?php echo $emailAssunto; ?></li>
                    <li style="width:80px;"><?php $emailData; echo date('d/m/Y', strtotime($emailData))?></li>
                  </ul>
             </a>
              
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

<?php include_once("footer.php"); ?>