<?php include_once("sistema/restrito_admin.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>


<?php

if($nivelAcesso == 'admin'){

?>

<?php include_once("header.php"); ?>    
	
    <article class="container-principal">
    	
        <h2> Mensagens respondidas </h2>
        
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
        
    	<div class="carregando">            
            
            <ul id="cabecalho-email" style="color:#fff;">
                <li style="width:130px;">NOME:</li>
                <li style="width:227px;">EMAIL:</li>
                <li style="width:285px;">ASSUNTO:</li>
                <li style="width:80px;">DATA:</li>
            </ul>
            
            <?php
            $emailId = strip_tags(trim($_GET['emailId']));
			
			$resultado_respostaAdmin = sds_selectRespostaInbox($emailId);
                
			foreach($resultado_respostaAdmin as $res_respostaAdmin){
				$emailId        	= $res_respostaAdmin['contatoId'];
				$emailNome      	= $res_respostaAdmin['contatoNome'];
				$emailEmail    		= $res_respostaAdmin['contatoEmail'];
				$emailAssunto     	= $res_respostaAdmin['contatoAssunto'];
				$emailMensagem  	= $res_respostaAdmin['contatoMensagem'];
				$emailData      	= $res_respostaAdmin['dataMensagem'];
				$statusMensagem    	= $res_respostaAdmin['statusMensagem'];
				$respostaMensagem  	= $res_respostaAdmin['respostaMensagem'];
				$i++;
				$cor = 'style="background:#D9D9D9"';
          ?>  
    

                  <ul <?php echo $cor;?> id="email-mensagens">
                    <li style="width:130px;"><?php echo $emailNome; ?></li>
                    <li style="width:227px;"><?php echo $emailEmail; ?></li>
                    <li style="width:285px;"><?php echo $emailAssunto; ?></li>
                    <li style="width:80px;"><?php $emailData; echo date('d/m/Y', strtotime($emailData))?></li>
                  </ul>
			 	 
                 <span style="color:#333; margin:10px; float:left; font: 14px Arial, Helvetica, sans-serif;">MENSAGEM:</span>
                 <p id="exibir-mensagem"><?php echo $emailMensagem ?></p>
                 
                 <span style="color:#333; clear:both; margin:10px; float:left; font: 14px Arial, Helvetica, sans-serif;">RESPOSTA ANTERIOR:</span>
                 <p id="exibir-mensagem"><?php
				 
				 if(empty($respostaMensagem)){
				 	echo 'Mensagem automática: NENHUMA RESPOSTA ANTERIOR FOI DADA A ESTE E-MAIL!';
				 }else{
					 echo $respostaMensagem; 
                 }
				 
                 ?></p>
                 
                 
            <?php
            }
            ?> 
            
            <?php include_once("sistema/carregando.php"); ?>
                        
            <?php if(isset($_POST['executar'])){
				$emailAdmin    = 'alexspmiranda@gmail.com';
				$emailAssunto  = 'CONTATO SALDÃO DE SERVIÇOS';
				$statusMensagem   = 'respondido';
				$dataResposta = date('Y-m-d');
				
				$headers = "From: $emailAdmin\n";
				$header .= "content-type: text/html; charset=\"utf-8\"\n\n";
				
				$emailId           = strip_tags(trim($_POST['contatoId']));
				$respostaMensagem     = strip_tags(trim($_POST['mensagem']));
				$emailClienteEmail = strip_tags(trim($_POST['contatoEmail']));
				$emailNome         = strip_tags(trim($_POST['contatoNome']));
				
				$recebidoEm = strip_tags(trim($_POST['dataMensagem']));
				$mensagemEm = strip_tags(trim($_POST['emailMensagem']));
				
				$sql_enviaAdmin  = 'UPDATE sds_contato SET ';
				$sql_enviaAdmin .= 'statusMensagem = :contatoStatus, dataResposta = :dataResposta, respostaMensagem = :respostaMensagem WHERE contatoId = :emailId';
				
				
				
				   try{
					   $query_enviaAdmin = $connect->prepare($sql_enviaAdmin);
					   $query_enviaAdmin->bindValue(':contatoStatus',$statusMensagem,PDO::PARAM_STR);
					   $query_enviaAdmin->bindValue(':dataResposta',$dataResposta,PDO::PARAM_STR);
					   $query_enviaAdmin->bindValue(':respostaMensagem',$respostaMensagem,PDO::PARAM_STR);
					   $query_enviaAdmin->bindValue(':emailId',$emailId, PDO::PARAM_STR);
					   $query_enviaAdmin->execute();
					   
					   echo '<div id="ok">Mensagem Enviada com sucesso</div>';
					   
						 $mensagemEnvio = "Olá, $emailNome. Este e-mail é uma resposta a mensagem:
$emailMensagem

Resposta: $respostaMensagem
						 ";
						 
						 mail($emailClienteEmail,$emailAssunto,$mensagemEnvio,$headers);
					   
					   
					   }catch(PDOexception $error_adminEmail){
						   echo 'Erro ao atualizar o email'.$error_adminEmail->getMessage();
				   }
				}?>
            
            
            <form name="responderEmail" action="" enctype="multipart/form-data" method="post">
    
                <label>
                   <span style="float:left; clear:both; font:14px Arial, Helvetica, sans-serif; margin:10px; ">Responder:</span>
                   <textarea name="mensagem" id="mensagem" value=""></textarea>
                </label>
                
                <input type="hidden" name="contatoId" value="<?php echo $emailId ;?>" />
                <input type="hidden" name="contatoEmail" value="<?php echo $emailEmail;?>" />
                <input type="hidden" name="dataMensagem" value="<?php echo $emailData;?>" />
                <input type="hidden" name="contatoMensagem" value="<?php echo $emailMensagem;?>" />
                <input type="hidden" name="contatoNome" value="<?php echo $emailNome;?>" />
                
                <input type="submit" name="executar" id="executar" value="Enviar Resposta" />
            
            </form>
            
            
        </div><!-- FECHA CARREGANDO -->
    
    </article><!-- FECHA CONTAINER PRINCIPAL -->

<?php

}else{
include "deslogar.php";
}
 
?>

<?php include_once("footer.php"); ?>