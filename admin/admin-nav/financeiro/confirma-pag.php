<?php include_once("sistema/restrito_admin.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>

<?php

if($nivelAcesso == 'admin'){

?>

<?php include_once("header.php"); ?>

<?php
	
	include "../Connections/config.php";
	
	$idCliente = strip_tags(trim($_GET['id']));
	            
	$resultado_clienteAtivos = sds_selectMeusDados($idCliente);

	foreach($resultado_clienteAtivos as $res_inboxAdmin){
		$nomeCliente         = $res_inboxAdmin['nome'];
		$emailCliente        = $res_inboxAdmin['email'];
		$cpf		         = $res_inboxAdmin['cpfCnpj'];
		$statusCliente       = $res_inboxAdmin['status'];

	}
	
	if(isset($_POST['bt-confirmar'])){			
			
		$cadastradoComSucesso = sds_atualizaStatusPagamento($idCliente);		
		
		try{
			
			$statusModificacao = 'patrocinado';
			$plano = strip_tags(trim($_POST['plano-patrocinado']));
			$dataStatusModificacao = date('Y-m-d H:i:s');
				
			$cadastradoComSucesso = sds_updateStatusCliente($statusModificacao, $plano, $dataStatusModificacao, $idCliente);
			
			echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/patrocinados">';
			
		}catch(PDOException $erro_cadastrar){
			echo 'Não possível patrocinar.';
		}
	}	
?>

<article class="container-principal">
	
    <h2>Dados do cliente</h2>
    
	<span style="float:left; width:735px; background:#06C; font:14px Arial, Helvetica, sans-serif; color:#fff; padding:0 5px;">

		<?php echo $cadastradoComSucesso ?>

	</span>
   
   <?PHP
   
		echo '<h4 style="float:left; clear:both; margin-left:10px; margin-top:10px;">Nome do cliente: '.$nomeCliente.'</h4>';
		echo '<h4 style="float:left; clear:both; margin-left:10px;">E-mail do cliente: '.$emailCliente.'</h4>';
		echo '<h4 style="float:left; clear:both; margin-left:10px;">CPF/CNPJ do cliente: '.$cpf.'</h4>';
		echo '<h4 style="float:left; clear:both; margin-left:10px;">Status atual do cliente: '.$statusCliente.'</h4>';
		echo '<h4 style="float:left; clear:both; margin-left:10px;">Código do pagamento: </h4>';
   
   ?>
    
    <div id="janelaModalPatrocinar" class="reveal-modal">
        <h1>Escolha o plano:</h1>
        
        <form  method="post" enctype="multipart/form-data">
        	<label><input name="plano-patrocinado" type="radio" class="radio-plano-patrocinado" value="topo" required /> Plano topo (R$ 4,90)</label>
            <label><input name="plano-patrocinado" type="radio" class="radio-plano-patrocinado" value="basico" required /> Plano básico (R$ 9,90) </label>
            <label><input name="plano-patrocinado" type="radio" class="radio-plano-patrocinado" value="plus" required /> Plano plus (R$ 19,90)</label>
            <label><input name="plano-patrocinado" type="radio" class="radio-plano-patrocinado" value="gold" required /> Plano gold (R$ 49,90)</label>
										            
            <input type="submit" name="bt-confirmar" class="bt-confirma-plano" value="Confirmar plano" />
        </form>
        
    	<a class="close-reveal-modal">×</a>
    </div>
   
   <div class="bt-gerenciar">
   
   		 <form name="bt-gerenciadores" action="" method="post" enctype="multipart/form-data">
         		
                <input type="submit" name="bt-negar" value="Pagamento Inexistente" class="bt-gerenciador" />
         		<input type="button" name="botao-patrocinar" value="Confirmar pagamento" id="botao-patrocinar"  class="bt-gerenciador" />

                
         
         </form>
   
   </div><!-- FECHA BOTÃO GERENCIAR -->
   
</article><!-- FECHA CONTAINER PRINCIPAL -->
<?php include_once("footer.php"); ?>
<?php
}else{
include "deslogar.php";
}
 
?>