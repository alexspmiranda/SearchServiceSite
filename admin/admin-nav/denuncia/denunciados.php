<?php include_once("sistema/restrito_admin.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>       	
            
            
       		
<?php

if($nivelAcesso == 'admin'){

?>

<?php include_once("header.php"); ?>
	
    <article class="container-principal">
    
    	<h2>Usuários Denunciados</h2>
    	<?php include_once("sistema/carregando.php"); ?>
        
        <form name="s_emailAdmin" action="painel.php?exe=admin-inbox/search" id="s_emailAdmin" enctype="multipart/form-data" method="post">
            <label>
            <input type="text" name="busca" size="50" />
            <input type="submit" name="executar" id="executar" value="Pesquisar pelo nome" />
            
            </label>
        </form>
        
        
    	<div class="carregando">            
            
            <ul id="cabecalho-email" style="color:#fff;">
                <li style="width:170px;">CLIENTE DENUNCIADO:</li>
                <li style="width:267px;">EMAIL:</li>
                <li style="width:185px;">DENUNCIA:</li>
                <li style="width:100px;">DATA:</li>

            </ul>
            
             
            <?php            
            
			$resultado_clienteDenunciados = sds_selectAnunciosDenunciados();
			
            $cont=0;   
			foreach($resultado_clienteDenunciados as $res_clienteDenunciados){
				$clienteId        = $res_clienteDenunciados['clienteId'];
				$idDenuncia 	  = $res_clienteDenunciados['idDenuncia'];
				$nomeCliente      = $res_clienteDenunciados['nome'];
				$emailCliente     = $res_clienteDenunciados['email'];
				$denuncia    	  = $res_clienteDenunciados['denuncia'];
				$dataDenuncia     = $res_clienteDenunciados['dataDenuncia'];
				
				$i++;
				if($i % 2 == 0){
					$cor = 'style="background:#D9D9D9"';
				}else{
					$cor = 'style="background:#f4f4f4;"';
				}
				
				sds_denunciadosLido();
            ?>  
    
              <a href="painel.php?exe=admin-nav/denuncia/gerenciador-denuncias&id=<?php echo $clienteId ?>&denuncia=<?php echo $idDenuncia ?>">
                  <ul <?php echo $cor;?> id="email-mensagens">
                    
                    <li style="width:170px; height:18px;"><?php
					
					
					echo substr($nomeCliente,0, 15); echo '...'
					
								 
					 ?></li>
                     
                    <li style="width:267px; height:18px;"><?php echo substr($emailCliente,0, 29); echo '...'; ?></li>
                    <li style="width:185px; height:18px;"><?php echo substr($denuncia,0, 23); echo '...'; ?></li>
                    <li style="width:100px; height:18px;"><?php $dataDenuncia;  echo date('d/m/Y', strtotime($dataDenuncia)); ?></li>
                  </ul>
             </a>
              
            <?php
            $cont++;
			}
			
			if($cont == 0){
				echo '<H4>&nbsp;NÃO HÁ CLIENTES DENUNCIADOS</H4>';
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