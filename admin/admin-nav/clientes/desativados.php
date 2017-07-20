<?php include_once("sistema/restrito_admin.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>       	
            
            
       		
<?php

if($nivelAcesso == 'admin'){

?>

<?php include_once("header.php"); ?><br>
    <article class="container">
    	<h4>Usuários Desativados</h4>
    	
        <nav class="submenu-admin">
            <ul class="inline unstyled">
                <a href="<?php echo URL::getBase() ?>painel/clientes/ativos"><li class="submenu"> Ativos    </li></a>
                <a href="<?php echo URL::getBase() ?>painel/clientes/pendentes"><li class="submenu"> Pendentes </li></a>  
                <a href="<?php echo URL::getBase() ?>painel/clientes/desativados"><li class="submenu"> Desativados </li></a>       
                <a href="<?php echo URL::getBase() ?>painel/clientes/processo"><li class="submenu"> Aguardando aprovação </li></a>
                <a href="<?php echo URL::getBase() ?>painel/clientes/patrocinados"><li class="submenu"> Patrocinados</li></a>
            </ul>
        </nav>
        <form name="s_emailAdmin" action="painel.php?exe=admin-inbox/search" class="s_emailAdmin" enctype="multipart/form-data" method="post">
            <label>
            <input type="text" name="busca" size="50" />
            <input type="submit" name="executar" class="btn btn-primary btn-search" value="Pesquisar pelo nome" />
            
            </label>
        </form>
 
    	<div class="row-fluid">            
            <ul class="inline unstyled">
                <li class="span3 text-center">NOME:</li>
                <li class="span3 text-center">EMAIL:</li>
                <li class="span3 text-center">STATUS:</li>
                <li class="span3 text-center">ÚLTIMO ACESSO:</li>
            </ul>
        </div>
            
             
            <?php
            $statusMensagem = 'desativado';
            
            $resultado_clienteAtivos = sds_selectAnunciosStatus($statusMensagem);
			
            $cont=0;
				
			foreach($resultado_clienteAtivos as $res_inboxAdmin){
				$clienteId        = $res_inboxAdmin['clienteId'];
				$nomeCliente      = $res_inboxAdmin['nome'];
				$emailCliente    = $res_inboxAdmin['email'];
				$ultimoAcesso     = $res_inboxAdmin['modificadoEM'];
				$statusCliente  = $res_inboxAdmin['status'];
				$i++;
				if($i % 2 == 0){
					$cor = 'style="background:#D9D9D9"';
				}else{
					$cor = 'style="background:#f4f4f4;"';
				}
		
            ?>  
    
    <div class="row-fluid user-by-status">    
        <a href="<?php echo URL::getBase() ?>painel/clientes/gerenciador?id=<?php echo $clienteId ?>">
            <ul class="inline unstyled">
                <li class="span3 text-center"><?php echo substr($nomeCliente,0, 15); echo '...' ?></li>
                <li class="span3 text-center"><?php echo $emailCliente; ?></li>
                <li class="span3 text-center"><?php echo $statusCliente; ?></li>
                <li class="span3 text-center"><?php $ultimoAcesso; echo date('d/m/Y', strtotime($ultimoAcesso))?></li>
            </ul>
        </a>
    </div>
              
            <?php
            $cont++;
			}
			
			if($cont == 0){
				echo '<H4>&nbsp;NÃO HÁ CLIENTES DESATIVADOS</H4>';
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