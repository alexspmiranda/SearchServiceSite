<?php include_once("sistema/restrito_admin.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>       	
            
            
       		
<?php

if($nivelAcesso == 'admin'){

?>

<?php include_once("header.php"); ?>

    <article class="container-principal">
    
    	<h2>Pagamentos em processamento</h2>
        
    	<div class="carregando">            
            
            <ul id="cabecalho-email" style="color:#fff;">
                <li style="width:205px;">E-MAIL:</li>
                <li style="width:377px;">CÓDIGO DE PAGAMENTO:</li>
                <li style="width:142px;">ENVIADO EM:</li>
            </ul>
            
             
            <?php
				
				$resultado_pagamento = sds_selecionaPagamentosPendente();
				
                $cont=0;
                foreach($resultado_pagamento as $res_pagamento){
                    $clienteId        = $res_pagamento['idClientePatrocinado_fk'];
                    $codigoPagamento      = $res_pagamento['codigoPagamento'];
                    $dataPagamento    = $res_pagamento['dataPagamento'];
                    $i++;
                    if($i % 2 == 0){
                        $cor = 'style="background:#D9D9D9"';
                    }else{
                        $cor = 'style="background:#f4f4f4;"';
                    }
					
					//MARCA PAGAMENTO COMO LIDO	
					sds_pagamentoInformadoLido();
									
					$resultado_pagamentoConsultaCliente = sds_selectMeusDados($idCliente);
						
						foreach($resultado_pagamentoConsultaCliente as $res_pagamentoConsultaCliente);
							$clienteEmail = $res_pagamentoConsultaCliente['email'];
					
            ?>  
    
              <a href="painel.php?exe=admin-nav/financeiro/confirma-pag&id=<?php echo $clienteId ?>">
                  <ul <?php echo $cor;?> id="email-mensagens">
                    <li style="width:205px; height:18px;"><?php echo $clienteEmail; ?></li>
                    <li style="width:377px; height:18px;"><?php echo $codigoPagamento; ?></li>
                    <li style="width:141px; height:18px;"><?php $dataPagamento; echo date('d/m/Y', strtotime($dataPagamento))?></li>
                  </ul>
             </a>
              
            <?php
            $cont++;
			}
			
			if($cont == 0){
				echo '<H4>&nbsp;NÃO HÁ PAGAMENTO EM PROCESSAMENTO</H4>';
			}
            ?> 
             
       </div> <!-- FECHA CARREGANDO -->
    </article><!-- FECHA CONTAINER PRINCIPAL -->
    
 
 <?php

}else{
include "deslogar.php";
}
 
?>

<?php include_once("footer.php"); ?>