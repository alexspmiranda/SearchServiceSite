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
	
	$resultado_verificaSituacaoCliente = sds_selectDadosPessoaisPatrocinio($idCliente);
	
	foreach($resultado_verificaSituacaoCliente as $res_verificaSituacaoCliente){
		$status = $res_verificaSituacaoCliente['status'];
		$nomeCliente = $res_verificaSituacaoCliente['nome'];
		$cpf = $res_verificaSituacaoCliente['cpfCnpj'];
		$vencimento = $res_verificaSituacaoCliente['vencimentoPatrocinio'];
		$inicioPatrocinio = $res_verificaSituacaoCliente['inicioPatrocinio'];
	}
    
	?>
	<article class="container">
	<?php
	if($status != 'patrocinado'){
     
	?>        
	
        <br><br>
		<h3>Anúncio patrocinado</h3>
    
        <div class="payment">
            <small>Primeira vez aqui? Para maiores informações <a href="#">clique aqui</a>. </small>
           
            <br><br>
            <h4>Informações:</h4><br>
            <label>Titular da conta: <?php echo $nomeCliente; ?></label>
            <label for="email">Email: <?php echo $email; ?></label>

            <span class="pagamento" style="background:#FFFED9;">
                <h5 style="border:0; color:#900; margin:0;">CPF: 
                    <?php 
                        if(!empty($cpf)){
                            echo $cpf;
                        }else{ 
                            echo 'Nenhum CPF informado';} 
                    ?>
                </h5>
            </span><br>


            <ul class="unstyled"> 
                
                 <li>
                    <center>Valores</center><br>
                    <center>Página dos estados</center><br>
                    <center>Página dos anúncios</center><br>
                    <center>Página inicial</center><br>
                    <center>Publicidade no facebook</center>
                </li>

                <li>
                    <center>R$ 9,90/mês</center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/check.png"></center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/nocheck.png"></center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/nocheck.png"></center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/nocheck.png"></center>
                    <!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
                    <form action="https://pagseguro.uol.com.br/checkout/v2/payment.html';  
                        }else{
                            echo 'http://www.saldaodeservicos.com/admin/painel/anuncio';
                        }
        
                    ?>"method="post" onsubmit="
                    <?php 
                    
                        if(!empty($nomeCliente) || !empty($cpf)){
                            echo 'PagSeguroLightbox(this); return false;';  
                        }
        
                    ?>">
                    <!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
                    <input type="hidden" name="code" value="
                    <?php 
                    
                        if(!empty($nomeCliente) || !empty($cpf)){
                            echo '1733B78D6464E38114CC5F97784686BF';  
                        }
                        
                    ?>" />
                    <input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/84x35-pagar.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!"  style="margin-left:20px" />
                    </form>
                    <script type="text/javascript" src="
                    <?php 
                    
                        if(!empty($nomeCliente) || !empty($cpf)){
                            echo 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js';  
                        }
                        
                    ?>">
                    </script>
                    <!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
                </li>
                
                <li>
                    <center>R$ 19,90/mês</center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/check.png"></center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/check.png"></center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/nocheck.png"></center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/nocheck.png"></center>
                    <!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
                    <form action="<?php 
        
                        if(!empty($nomeCliente) || !empty($cpf)){
                            echo 'https://pagseguro.uol.com.br/checkout/v2/payment.html';  
                        }else{
                            echo '#';
                        }
        
                    ?>"method="post" onsubmit="
                    <?php 
                    
                        if(!empty($nomeCliente) || !empty($cpf)){
                            echo 'PagSeguroLightbox(this); return false;';  
                        }
        
                    ?>">
                    <!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
                    <input type="hidden" name="code" value="
                    <?php 
                    
                        if(!empty($nomeCliente)  || !empty($cpf)){
                            echo '8F73CB137575989DD4C3FF9FC28071A9';  
                        }
                        
                    ?>" />
                    <input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/84x35-pagar.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" style="margin-left:20px" />
                    </form>
                    <script type="text/javascript" src="
                    <?php 
                    
                        if(!empty($nomeCliente)  || !empty($cpf)){
                            echo 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js';  
                        }
                        
                    ?>">
                    </script>
                    <!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
                </li>
                
                <li>
                    <center>R$ 49,00/mês</center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/check.png"></center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/check.png"></center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/check.png"></center><br>
                    <center><img src="<?php echo URL::getBase() ?>img/icon/check.png"></center>
                    <!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
                    <form action="<?php 
        
                        if(!empty($nomeCliente) || !empty($cpf)){
                            echo 'https://pagseguro.uol.com.br/checkout/v2/payment.html';  
                        }else{
                            echo '#';
                        }
        
                    ?>"method="post" onsubmit="
                    <?php 
                    
                        if(!empty($nomeCliente) || !empty($cpf)){
                            echo 'PagSeguroLightbox(this); return false;';  
                        }
        
                    ?>">
                    <!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
                    <input type="hidden" name="code" value="
                    <?php 
                    
                        if(!empty($nomeCliente) || !empty($cpf)){
                            echo '78C398B66464BDA0048FEF8B0C482CA0';  
                        }
                        
                    ?>" />
                    <input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/84x35-pagar.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" style="margin-left:20px" />
                    </form>
                    <script type="text/javascript" src="
                    <?php 
                    
                        if(!empty($nomeCliente) || !empty($cpf)){
                            echo 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js';  
                        }
                        
                    ?>">
                    </script>
                    <!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
                </li>
                
            </ul>
            <small>Certifique-se de que os dados informados na compra serão os mesmos dados apresentados acima. Isto agilizará a identificação do pagamento. <a href="#">Clique aqui para saber mais sobre <strong>como comprar com segurança</strong></a>.</small>

        </div>
        
        <aside class="sidebar">
            <div class="paymentdata">
           		<h3>Já pagou ?</h3>
                
                <h4>Informe o pagamento aqui:</h4><br /><br />	
                
                
                <form name="informar-pagamento" action="" method="post" enctype="multipart/form-data" class="form-pagamento">
                    
                    <h5 style="border:0;">Código da transação: <a href="#" style="font-size:10px;">o que é isso?</a></h5>
                    <input type="text" required name="codigo-pagamento" class="input-xlarge" size="50" style="margin:0;" placeholder="4D8DD372-93CD-49FF-9C5A-72FF2C8436C6" />
                    
                
                <?php 
                if(isset($_POST['envia-confirma-pagamento'])){
    				
    				$codigoPagamento = strip_tags(trim($_POST['codigo-pagamento']));
    				$confirmadoComSucesso = sds_insertPatrocinados($idCliente, $codigoPagamento);
    				
    			}
                ?>
                <h5 style="float:left; background:#06F; color:#fff; padding:0 5px; border:0; margin-top:5px; width:200px;">
    				<?php echo $confirmadoComSucesso;?>
                </h5>
               
                <small>* Lembre-se que o tempo de compensação bancária é de até 3 dias úteis.</small>

          		<input type="submit" value="Confirmar pagamento" class="btn btn-info" name="envia-confirma-pagamento" style="float:right; margin-top:20px;" />
                
                </form>            
            </div>
            
        </aside>
        
        <div class="bottom-info">
            <div class="alert alert-success" role="success" style="float:left;">O sistema de pagamento é completamente processado pelo pagseguro.</div>
        </div>
      <?php
	    
      }else{
		  
		  	$resultado_consultaCadastro =  sds_selectMeusDados($idCliente);
			
			foreach($resultado_consultaCadastro as $res_consultaCadastro){
				$clienteId     = $res_consultaCadastro['clienteId'];
				$clienteNome   = $res_consultaCadastro['nome'];
				$clienteCpf    = $res_consultaCadastro['cpfCnpj'];
				$clienteSexo   = $res_consultaCadastro['sexo'];
				$clienteEmail  = $res_consultaCadastro['email'];
				$clienteStatus = $res_consultaCadastro['status'];
				$clientePlano  = $res_consultaCadastro['plano'];
			}
		
		?>
        <article class="container-principal" style="clear:both; margin:10px 0 0 30px;">
            
                <span class="titulo-principal">Painel de controle</span><br />
                
            <span style="border:1px solid #ccc; float:left; padding:10px; clear:both;">
                <h4 style="clear:both;">Status: PATROCINADO</h4>
                <h4>Plano: <?php echo strtoupper($clientePlano); ?></h4>
                <!--<h4>Data inicial: 10/12/2014</h4>-->
                <h4 style="clear:both;">Data de vencimento: <?php echo date('d/m/Y', strtotime($vencimento)) ?> </h4>
                <h4>Número de visualizações: <?php echo sds_selectVerificaVisitaPainel($idCliente); ?> </h4>          
            	
                <?php 
				
					$diferenca = strtotime($vencimento) - strtotime(date('Y-m-d'));
					$dias = floor($diferenca / (60 * 60 * 24));
				
				?>
	            <h4 style="clear:both;">Faltam <?php echo $dias; ?> dias para seu anúncio patrocinado expirar</h4>
            </span>
       	</article>
        <?php
		
		
	  }
	  ?>
      </div>
</article><!-- FECHA CONTAINER PRINCIPAL -->

<?php include_once("footer.php"); ?>