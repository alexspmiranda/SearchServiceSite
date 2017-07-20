<?php include_once("sistema/restrito_admin.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>

<?php

if($nivelAcesso == 'admin'){

?>

<?php include_once("header.php"); ?>
<div class="container">
	<br>
	<nav class="submenu-admin">
	    <ul class="inline unstyled">
	        <a href="<?php echo URL::getBase() ?>painel/clientes/ativos"><li class="submenu"> Ativos    </li></a>
	        <a href="<?php echo URL::getBase() ?>painel/clientes/pendentes"><li class="submenu"> Pendentes </li></a>  
	        <a href="<?php echo URL::getBase() ?>painel/clientes/desativados"><li class="submenu"> Desativados </li></a>       
	        <a href="<?php echo URL::getBase() ?>painel/clientes/processo"><li class="submenu"> Aguardando aprovação </li></a>
	        <a href="<?php echo URL::getBase() ?>painel/clientes/patrocinados"><li class="submenu"> Patrocinados</li></a>
	    </ul>
	</nav>
</div>
<?php
		
	$idCliente = strip_tags(trim($_GET['id']));
		
	$resultado_consultaCadastro = sds_selectDadosCliente($idCliente);	
	
		
	foreach($resultado_consultaCadastro as $res_consultaCadastro){
		//PERTENCE A TABELA CLIENTE
		$clienteNome = $res_consultaCadastro['nome'];
		$clienteCpf = $res_consultaCadastro['cpfCnpj'];
		$clienteSexo = $res_consultaCadastro['sexo'];
		$clienteEmail = $res_consultaCadastro['email'];
		$clienteStatus = $res_consultaCadastro['status'];
		$clientePlano = $res_consultaCadastro['plano'];
		$fbid 			= $res_consultaCadastro['fbid'];
		$clienteInicioPlano = $res_consultaCadastro['inicioPatrocinio'];
		$clienteVencimentoPlano = $res_consultaCadastro['vencimentoPatrocinio'];
		$clienteUltimoAcesso = $res_consultaCadastro['modificadoEM'];
		//PERTENCE A TABELA ANUNCIO
		$anuncioUrl			= $res_consultaCadastro['linkPessoalAnuncio'];
		$idAnuncio = $res_consultaCadastro['idAnuncio'];
		$anuncioNome = $res_consultaCadastro['nomeFantasiaAnuncio'];
		$anuncioTitulo = $res_consultaCadastro['tituloAnuncio'];
		$anuncioCategoria = $res_consultaCadastro['categoriaAnuncio'];
		$anuncioPreco = $res_consultaCadastro['precoAnuncio'];
		$anuncioEndereco = $res_consultaCadastro['enderecoAnuncio'];
		$anuncioComplemento = $res_consultaCadastro['complementoAnuncio'];
		$anuncioCep = $res_consultaCadastro['cepAnuncio'];
		$anuncioBairro = $res_consultaCadastro['bairroAnuncio'];
		$anuncioCidade = $res_consultaCadastro['cidadeAnuncio'];
		$anuncioEstado = $res_consultaCadastro['estadoAnuncio'];
		$anuncioTelefone = $res_consultaCadastro['telefoneAnuncio'];
		$anuncioTelefone2 = $res_consultaCadastro['telefoneAnuncio2'];
		$anuncioTelefone3 = $res_consultaCadastro['telefoneAnuncio3'];
		$anuncioDescricao = $res_consultaCadastro['descricaoAnuncio'];

	}
	
	$imagens = explode("::", listaImagem($idAnuncio));

	if(isset($_POST['cadastra-anuncio'])){

			$anuncioNome = strip_tags(trim($_POST['nome']));
			$anuncioTitulo = strip_tags(trim($_POST['titulo']));
			$anuncioCategoria = strip_tags(trim($_POST['categoria']));
			$anuncioPreco = strip_tags(trim($_POST['preco']));
			$anuncioEndereco = strip_tags(trim($_POST['endereco']));
			$anuncioComplemento = strip_tags(trim($_POST['complemento']));
			$anuncioCep = strip_tags(trim($_POST['cep']));
			$anuncioBairro = strip_tags(trim($_POST['bairro']));
			$anuncioCidade = strip_tags(trim($_POST['cidade']));	
			$anuncioEstado = strip_tags(trim($_POST['estado']));
			$anuncioTelefone = strip_tags(trim($_POST['telefone']));
			$anuncioTelefone2 = strip_tags(trim($_POST['telefone2']));
			$anuncioTelefone3 = strip_tags(trim($_POST['telefone3']));
			$anuncioDescricao = strip_tags(trim($_POST['descricao']));
			$clienteInicioPlano = strip_tags(trim($_POST['clienteInicioPlano']));
			$clienteVencimentoPlano = strip_tags(trim($_POST['clienteVencimentoPlano']));
			$anuncioDataCadastro = date('Y-m-d H:i:s');

			$resultado_verificaUrl =  sds_verificaUrl($anuncioUrl);

			foreach($resultado_verificaUrl as $res_verificaUrl){
				$idAnuncioUrl 	= $res_verificaUrl['idAnuncio'];
				if($idAnuncioUrl != $idAnuncio){
					$anuncioUrl = $anuncioUrl.''.rand(1, 9);
				}
			}
			

			$anuncioTituloUrl = retira_acentos( $anuncioTitulo );
			$anuncioTituloUrl = str_replace('-', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace('.', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace(',', '', $anuncioTituloUrl);
			$anuncioTituloUrl = str_replace(' ', '-', $anuncioTituloUrl);
			$anuncioTituloUrl = strtolower($anuncioTituloUrl.'-'.$idCliente);

			
			sds_updateDadosPessoaisCliente($clienteInicioPlano, $clienteVencimentoPlano, $idCliente);
			
			sds_atualizaDadosAnuncio($idCliente, $anuncioUrl, $anuncioNome,$anuncioTitulo,$anuncioSite,$anuncioCategoria,$anuncioPreco, $anuncioEndereco,$anuncioComplemento,$anuncioNum,
								 	 $anuncioCep, $anuncioBairro,$anuncioCidade, $anuncioEstado,$anuncioTelefone,$anuncioTelefone2,$anuncioTelefone3,$anuncioDescricao,
								  	 $notificadoAnuncio, $anuncioTituloUrl);
	}
	
	$resultado_buscaPorEstado = sds_selectEstados();
	$estadoNome = sds_selectEstadoUF($anuncioEstado);

	if(isset($_POST['bt-ativar'])){
		
		try{
			
			if(empty($clientePlano)){
				$dataStatusModificacao = date('Y-m-d H:i:s');
				$statusModificacao = 'ativo';
				$plano = NULL;
				
				sds_updateStatusCliente($statusModificacao, $plano, $dataStatusModificacao, $idCliente);
				
			}else{
				
				$statusModificacao = 'patrocinadoReativar';
				$plano = $clientePlano;
				
				sds_updateStatusCliente($statusModificacao, $plano, $dataStatusModificacao, $idCliente);
			
			}
			
			//sds_updateStatusCliente($statusModificacao, $plano, $dataStatusModificacao, $idCliente);
			
			$executadoComSucesso = 'Cliente ativado com sucesso';
						
			if($clienteStatus == 'ativo' || $clienteStatus == 'desativado' || $clienteStatus == 'patrocinado' || $clienteStatus == 'pendente'){
				//echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/'.$clienteStatus.'s">';
			}else{
				//echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/ativos">';
			}
			
		}catch(PDOException $erro_cadastrar){
			echo 'Não possível ativar.';
		}			
	}
	
	
	if(isset($_POST['bt-desativar'])){		
		
		$statusModificacao = 'desativado';
		$dataStatusModificacao = date('Y-m-d H:i:s');
		$plano = NULL;
			
		sds_updateStatusCliente($statusModificacao, $plano, $dataStatusModificacao, $idCliente);
			
		$executadoComSucesso = 'Cliente desativado com sucesso';
			
		if($clienteStatus == 'ativo' || $clienteStatus == 'desativado' || $clienteStatus == 'patrocinado' || $clienteStatus == 'pendente'){
			//echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/'.$clienteStatus.'s">';
		}else{
			//echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/ativos">';
		}						
	}
	
	if(isset($_POST['bt-patrocinar'])){

		$statusModificacao = 'patrocinado';
		$plano = strip_tags(trim($_POST['plano-patrocinado']));
		$dataStatusModificacao = date('Y-m-d H:i:s');
		
		sds_updateStatusCliente($statusModificacao, $plano, $dataStatusModificacao, $idCliente);
						
		$executadoComSucesso = 'Cliente patrocinado com sucesso';
		
		if($clienteStatus == 'ativo' || $clienteStatus == 'desativado' || $clienteStatus == 'patrocinado' || $clienteStatus == 'pendente'){
			//echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/'.$clienteStatus.'s">';
		}else{
			//echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/ativos">';
		}
	}
	
	if(isset($_POST['bt-excluir'])){
		
		sds_deleteCliente($idCliente);
		
		$executadoComSucesso = 'Cliente excluído com sucesso';
			
		//echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/ativos">';					
	}
?>

<?php 


	$imagem_um 		= 'http://saldaodeservicos.com/img/uploads/'. md5($clienteEmail).'/thumbs/'.md5($clienteEmail).'_thumb_userImage1.jpg';
    $imagem_dois 	= 'http://saldaodeservicos.com/img/uploads/'. md5($clienteEmail).'/thumbs/'.md5($clienteEmail).'_thumb_userImage2.jpg';
    $imagem_tres 	= 'http://saldaodeservicos.com/img/uploads/'. md5($clienteEmail).'/thumbs/'.md5($clienteEmail).'_thumb_userImage3.jpg';
    $imagem_quatro 	= 'http://saldaodeservicos.com/img/uploads/'. md5($clienteEmail).'/thumbs/'.md5($clienteEmail).'_thumb_userImage4.jpg';
    $imagem_cinco 	= 'http://saldaodeservicos.com/img/uploads/'. md5($clienteEmail).'/thumbs/'.md5($clienteEmail).'_thumb_userImage5.jpg';


if($nivelAcesso == 'admin'){
}

if(!empty($executadoComSucesso)){
?>
<span style="float:left; width:99%; background:#06C; font:14px Arial, Helvetica, sans-serif; color:#fff; padding:5px; text-align:center;">

		<?php echo $executadoComSucesso ?>

</span>
<?php } ?>
<article class="container"><br>
	<h4>Dados do cliente</h4>
   
   <div class="btn-toolbar btn-group text-right" style="float:right; width:100%;">
   		 <form name="bt-gerenciadores" action="" method="post" enctype="multipart/form-data">
			
			<a data-toggle="modal" href="#" data-target="#deleteUser">
				<button type="button" name="botao-excluir" value="Excluir" class="btn">Excluir</button>
			</a>
			
			<a data-toggle="modal" href="#" data-target="#patrocinarUser">
				<button type="button" name="botao-patrocinar" value="Patrocinar" class="btn">Patrocinar</button>
    		</a>

    		<a data-toggle="modal" href="#" data-target="#desativarUser">
            	<button type="button" name="botao-desativar" value="Desativar" class="btn">Desativar</button>
			</a>
			<a data-toggle="modal" href="#" data-target="#ativarUser">
            	<button type="button" name="botao-ativar" value="Ativar" class="btn">Ativar</button>
         	</a>
         </form>
   </div>

	<!--- MODAL DE EXCLUIR -->		 

		<div class="modal hide fade" id="deleteUser">
		 <div class="modal-header">
		   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		   <h3 id="myModalLabel">Gerenciador de usuários</h3>
		 </div>
		 <div class="modal-body">
		   	Você tem certeza que deseja excluir este usuário?
		 </div>
		 <div class="modal-footer">
		   <form method="post" enctype="multipart/form-data">
		   		<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
			    <input type="submit" name="bt-excluir" value="Excluir cliente" class="btn btn-primary" />
		 	</form>
		 </div>
		</div>

   	<!--- MODAL DE PATROCINAR -->

   		<div class="modal hide fade" id="patrocinarUser">
		 <div class="modal-header">
		   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		   <h3 id="myModalLabel">Gerenciador de usuários</h3>
		 </div>
		 <div class="modal-body">
		   	Escolha o plano:

		   	<form  method="post" enctype="multipart/form-data">		    
		        
		        <label><input name="plano-patrocinado" type="radio" value="topo" required /> Plano topo (R$ 4,90)</label>
		        <label><input name="plano-patrocinado" type="radio" value="basico" required /> Plano básico (R$ 9,90) </label>
		        <label><input name="plano-patrocinado" type="radio" value="plus" required /> Plano plus (R$ 19,90)</label>
		        <label><input name="plano-patrocinado" type="radio" value="gold" required /> Plano gold (R$ 49,90)</label>

		 </div>
		 <div class="modal-footer">
		   
		   		<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
			   	<input type="submit" name="bt-patrocinar" value="Patrocinar cliente" class="btn btn-primary" />
		 	</form>
		 </div>
		</div>

   	<!--- MODAL DE DESATIVAR -->
		<div class="modal hide fade" id="desativarUser">
		 <div class="modal-header">
		   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		   <h3 id="myModalLabel">Gerenciador de usuários</h3>
		 </div>
		 <div class="modal-body">
		   	Você tem certeza que deseja desativar este usuário?
		 </div>
		 <div class="modal-footer">
		   	<form method="post" enctype="multipart/form-data">
		   		<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
			    <input type="submit" name="bt-desativar" value="Desativar cliente" class="btn btn-primary" />
		 	</form>
		 </div>
		</div>
   	<!--- MODAL DE ATIVAR -->
   		<div class="modal hide fade" id="ativarUser">
		 <div class="modal-header">
		   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		   <h3 id="myModalLabel">Gerenciador de usuários</h3>
		 </div>
		 <div class="modal-body">
		   	Você tem certeza que deseja ativar este usuário?
		 </div>
		 <div class="modal-footer">
		   	<form method="post" enctype="multipart/form-data">
		   		<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
			   <input type="submit" name="bt-ativar" value="Ativar cliente" class="btn btn-primary" />
		 	</form>
		 </div>
		</div>

	<h5>  <?php if(!empty($fbid)){echo 'FBID: '.$fbid; }?> </h5><br>
  	<div class="my-notice-admin">
		<form name="cadastra-anuncio" id="#cadastra-anuncio" method="post" enctype="multipart/form-data">
        	
        	<span class="info-align">
	        	<h4>Titular da conta:</h4>
	            <input type="text" name="nome-completo" value="<?php echo $clienteNome; ?>" size="50" />
			</span>

            <span class="info-align">
            	<h4>CPF: </h4>
                <input type="text" name="cpf-cnpj" pattern="[0-9]{11}" class="cpf_cnpj" value="<?php echo $clienteCpf; ?>" size="30" />
            </span>
            
            <span class="info-align">         
	            <h4>Sexo: </h4>
    	        <select name="sexo" style="clear:both; margin:0;">
		            <option value="<?php echo $clienteSexo; ?>" value="<?php echo $clienteSexo; ?>" selected style="background:#ccc;">
		            <?php echo $clienteSexo; ?></option>
		                        
		            <option name="Masculino" value="Masculino">Masculino</option>
		            <option name="Feminino" value="Feminino">Feminino</option>
            	</select>
        	</span>    		
            
            <span class="info-align" style="clear:both;">
				<h4>Email: </h4>
                <input type="text" required name="email" value="<?php echo $clienteEmail; ?>" readonly="readonly" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  style="border:0;"/>
            </span>
                    
            <span class="info-align">
            	<h4>Status: </h4>                            
                <input type="text" required name="status" value="<?php echo $clienteStatus; ?>" readonly="readonly" size="10"  style="border:0;"/>
			</span>
			            
<?php 		if($clienteStatus == "patrocinado"){ ?>
				<span class="info-align">
                	<h4>Plano: </h4>
                    <input type="text" required name="status" value="<?php echo $clientePlano; ?>" readonly="readonly" size="10"  style="border:0;"/>
				</span>

			<span class="info-align" style="clear:both;">
				<h4>Inicio do atual plano:</h4>
                <input type="text" name="clienteInicioPlano" value="<?php echo $clienteInicioPlano; ?>" size="50" />
                <!-- <input type="date" name="clienteInicioPlano" value="<?php echo $clienteInicioPlano; ?>" size="50" /> -->
			</span>
			
			<span class="info-align">
            	<h4>Vencimento: </h4>
                <input type="text" name="clienteVencimentoPlano" value="<?php echo $clienteVencimentoPlano; ?>" size="30" />
			</span>
     
 <?php 		}
?>     		

     		<span class="info-align" style="clear:both;">
        		<h4>Nome do anunciante: </h4>
        		<input type="text" name="nome" class="input-xxlarge" value="<?php echo $anuncioNome; ?>" placeholder="Ex: Alex designer, Casa da arte, Artdesigner" size="45" required maxlength="35" />
        	</span>

        	<span class="info-align" style="clear:both;">
        		<h4>Título do anúncio: </h4>
        		<input type="text" name="titulo" class="input-xxlarge"  value="<?php echo $anuncioTitulo; ?>" placeholder="Ex: Site e cartão de visita com ótimo preço" size="55" required maxlength="60" />
        	</span>
        
        	<span class="info-align" style="clear:both;">
		        <h4>URL do seu site:</h4>
        		<input type="text" name="website" class="input-xlarge" value="<?php echo $anuncioSite; ?>"  placeholder="http://www.seusite.com.br (opcional)" size="40" maxlength="60" />
        	</span>

        	<span class="info-align">
       			<h4>Categoria do anúcio: </h4>
        		<input type="text" name="categoria" class="input-xlarge" value="<?php echo $anuncioCategoria; ?>"  placeholder="Ex: Designer gráfico, Diarista" size="35" maxlength="60" />
        	</span>
        
        	<span class="info-align">        
        		<h4>Valor do serviço: </h4>
        		<input type="text" name="preco" value="<?php echo $anuncioPreco; ?>" size="20" placeholder="R$ 0,00" alt="" title="Deixe em branco para negociar" />
        	</span>
        	<span class="info-align">
        		<h4>Telefone fixo: </h4>
        		<input type="text" name="telefone" value="<?php echo $anuncioTelefone; ?>" size="20" id="telefone" maxlength="10" />
        	</span>

	        <span class="info-align">
	        	<h4>Telefone celular: </h4>
	        	<input type="text" name="telefone2" value="<?php echo $anuncioTelefone2; ?>" size="20" id="telefone2" maxlength="11" />
	        </span>

        
        	<span class="info-align" style="clear:both;">
		        <h4>CEP:</h4>
		        <input id="cep" name="cep" type="text" maxlength="9" value="<?php echo $anuncioCep; ?>" placeholder="Informe o CEP" onKeyPress="mascara(this, '#####-###')" size="12" />
        	</span>

	        <span class="info-align">
	        	<h4>Nome da Rua / Logradouro:</h4>
	        	<input id="rua" name="endereco" type="text" value="<?php echo $anuncioEndereco; ?>" placeholder="Avenida Barão de Japurá" size="40" />
	        </span>
	        
	        <span class="info-align">
	        	<h4>Complemento:</h4>
	        	<input id="complemento" name="complemento" value="<?php echo $anuncioComplemento; ?>" type="text" placeholder="Alameda A" size="40" />
	        </span>
        
        	<span class="info-align">
	        	<h4>Nº:</h4>
	        	<input id="num" name="num" value="<?php echo $anuncioNum; ?>" type="text" placeholder="1024" size="5"/>
        	</span>

	        <span class="info-align">
	        	<h4>Bairro:</h4>
	        	<input id="bairro" name="bairro" value="<?php echo $anuncioBairro; ?>" type="text" placeholder="Informe o Bairro"/>
	        </span>
	        
	        <span class="info-align">
	        	<h4>Cidade:</h4>
	        	<input id="cidade" name="cidade" value="<?php echo $anuncioCidade; ?>" type="text" placeholder="Informe a Cidade"/>
	        </span>
	        
	        <span class="info-align">
	        	<h4>UF:</h4>
		        <select name="estado" required >
		        <option name="<?php echo $anuncioEstado; ?>" value="<?php echo $anuncioEstado; ?>" style="background:#ccc;" selected> <?php echo $estadoNome; ?> </option>
		        <?php 
		    	foreach($resultado_buscaPorEstado as $res_buscaPorEstado){
		            $idEstado = $res_buscaPorEstado['id'];
		            $uf = $res_buscaPorEstado['uf'];
		            
		            ?>
		            <option name="<?php echo $idEstado; ?>" value="<?php echo $idEstado; ?>"><?php echo $uf; ?></option>
		            <?php
		        }
			
		        ?>
		        </select>
	        </span>
        	
        	<span class="info-align" style="clear:both; width:95%;">
		        <h4>Descrição:</h4>
		        <textarea name="descricao" class="textarea-manager" maxlength="420" required><?php echo $anuncioDescricao; ?></textarea>
	    	</span>    
        
        <input type="submit" name="cadastra-anuncio" value="Alterar anúncio" class="btn btn-primary" style="width:99%; margin:0; margin:10px 0;" />
      
      </form>
      
      <div class="meu-anuncio-midia">
   	
    <form method="post" enctype="multipart/form-data">
	<ul class="inline unstyled user-image-admin">
    	<li>
    
            <!-- FOTO UM  -->
            <span class="imagens-painel">   		
               	<?php
                    if(verificar_urlAdmin($idAnuncio, '1')){ ?>
                		<img src="<?php echo $imagem_um; ?>" width="185" height="104"  />
                 	<?php }else{?>
                		<img src="<?php echo URL::getBase() ?>images/sem_imagens.png" width="185" height="104"  />    
                <?php } ?>
            </span>
       </li>      
       
       <li>      
            <!-- FOTO DOIS  -->    
            <span class="imagens-painel">
                	<?php
                    if(verificar_urlAdmin($idAnuncio, '2')){ ?>
                		<img src="<?php echo $imagem_dois; ?>" width="185" height="104"  />
                 	<?php }else{?>
                		<img src="<?php echo URL::getBase() ?>images/sem_imagens.png" width="185" height="104"  />    
                <?php } ?>
           </span>
      	</li>
        
      	<li>      
            <!-- FOTO TRÊS  -->
            <span class="imagens-painel">
                	<?php
                    if(verificar_urlAdmin($idAnuncio, '3')){ ?>
                		<img src="<?php echo $imagem_tres; ?>" width="185" height="104"  />
                 	<?php }else{?>
                		<img src="<?php echo URL::getBase() ?>images/sem_imagens.png" width="185" height="104"  />    
                <?php } ?>
            </span>
        </li>
            
     	<li>       
            <!-- FOTO QUATRO  -->
            <span class="imagens-painel">   		
                	<?php
                    if(verificar_urlAdmin($idAnuncio, '4')){ ?>
                		<img src="<?php echo $imagem_quatro; ?>" width="185" height="104"  />
                 	<?php }else{?>
                		<img src="<?php echo URL::getBase() ?>images/sem_imagens.png" width="185" height="104"  />    
                <?php } ?>
            </span>
        </li>
    	
        <li>        
            <!-- FOTO CINCO  -->
            <span class="imagens-painel">
                	<?php
                    if(verificar_urlAdmin($idAnuncio, '5')){ ?>
                		<img src="<?php echo $imagem_cinco; ?>" width="185" height="104"  />
                 	<?php }else{?>
                		<img src="<?php echo URL::getBase() ?>images/sem_imagens.png" width="185" height="104"  />    
                <?php } ?>
            </span>
        </li>
       
       <label>	<input type="hidden" name="userImage" /></label>
            
        <label>	<input type="hidden" name="userImage1" /></label>
        <label>	<input type="hidden" name="userImage2" /></label>
        <label>	<input type="hidden" name="userImage3" /></label>
        <label>	<input type="hidden" name="userImage4" /></label>
        <label>	<input type="hidden" name="userImage5" /></label>

    </ul>	    
   	</form>
	
    </div></div>
         
	</div>
       
	</div>


	<div class="container">
		<?php

			if(isset($_POST['alert'])){
				$alerta = strip_tags(trim($_POST['option']));
				

				$mail = new PHPMailer();
				$mail->setLanguage('pt');
				
				$from	 	= 'naoresponda@saldaodeservicos.com';
				$fromName 	= 'Saldão de serviços';
				
				$host		= 'mail.saldaodeservicos.com';
				$username	= 'clientlist@saldaodeservicos.com';
				$password	= 'lequinho23';
				$port		= 587;
				$secure		= 'tls';
				
				$mail->isSMTP();
				$mail->Host 		= $host;
				$mail->SMTPAuth 	= true;
				$mail->Username 	= $username;
				$mail->Password 	= $password;
				$mail->Port 		= $port;
				$mail->SMTPSecure   = $secure;
				
				$mail->From 		= $from;
				$mail->FromName		= $fromName;
				$mail->addReplyTo($from, $fromName);
				
				$mail->addAddress($clienteEmail , $clienteEmail);
				$mail->isHTML(true);
				$mail->CharSet 	= 'utf-8';
				$mail->WordWrap = 70;
				$mail->Subject 	= 'Falta pouco';
				
				$criadoEm = date('d/m/Y H:i:s', strtotime($criadoEm));
				$mail_data = date('d/m/Y H:i:s', strtotime($mail_data));
				
				$mensagemCliente = "
				
				$alerta <br><br>
				
				Esta mensagem é gerada automaticamente pelo nosso sistema, por favor, não responda!<br><br>
				
				Atenciosamente,<br>
				Equipe Saldão de serviços.
				
				<br><br>
				
				Mensagem enviada em $mail_data
				";
				
				$mail->Body		= $mensagemCliente;
				$mail->AltBody	= $mensagemCliente;
				
				if($mail->send()){
					echo  "<h5 style=\"float:left; width:300px; padding:5px; background:#fff; margin-top:5px;\">
				
							Mensagem enviada com sucesso!
						
						</h5>";
				}else{
					echo 'Erro: '.$mail->ErrorInfo;;	
				}						
				

			}
		?>
		<form method="post" enctype="multipart/form-data">
			<select name="option">
				<option></option>
				<option name="option1" value="Falta pouco!!! Insira pelo menos o nome do bairro, cidade e estado para que seu anúncio seja aprovado">Enviar alerta para inserir bairro, cidade, estado</option>
				<option name="option2" value="Falta pouco!!! Verificamos que há uma pendência no nome, titulo, categoria ou contato do anuncio. Conserte a pendência para que o anúncio seja aprovado.">Enviar alerta para inserir nome, titulo, categoria ou contato</option>
				<option name="option2" value="Falta pouco!!!"></option>
			</select>

			<input type="submit" name="alert">
		</form>

	</div>
</article><!-- FECHA CONTAINER PRINCIPAL -->

<?php
}else{
include "deslogar.php";
}
 
?>

<?php include_once("footer.php"); ?>