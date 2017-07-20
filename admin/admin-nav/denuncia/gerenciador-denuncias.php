<?php include_once("sistema/restrito_admin.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>

<?php

if($nivelAcesso == 'admin'){

?>

<?php include_once("header.php"); ?>

<?php
	
	include "../Connections/config.php";
	
	$idCliente = strip_tags(trim($_GET['id']));
	$idDenuncia = strip_tags(trim($_GET['denuncia']));

	$resultado_consultaCadastro = sds_selectDadosCliente($idCliente);	
	
		
	foreach($resultado_consultaCadastro as $res_consultaCadastro){
		//PERTENCE A TABELA CLIENTE
		$clienteNome = $res_consultaCadastro['nome'];
		$clienteCpf = $res_consultaCadastro['cpfCnpj'];
		$clienteSexo = $res_consultaCadastro['sexo'];
		$clienteEmail = $res_consultaCadastro['email'];
		$clienteStatus = $res_consultaCadastro['status'];
		$clientePlano = $res_consultaCadastro['plano'];
		$clienteUltimoAcesso = $res_consultaCadastro['modificadoEM'];
		//PERTENCE A TABELA ANUNCIO
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
			$anuncioDataCadastro = date('Y-m-d H:i:s');
			
			sds_updateDadosCliente($anuncioNome, $anuncioTitulo, $anuncioCategoria, $anuncioPreco, $anuncioEndereco, $anuncioComplemento, $anuncioCep, $anuncioBairro,
								   $anuncioCidade, $anuncioEstado, $anuncioTelefone, $anuncioTelefone2, $anuncioTelefone3, $anuncioDescricao, $anuncioDataCadastro);				
			
	}
	
	
	if(isset($_POST['bt-ativar'])){
		
		try{
			
			$statusModificacao = 'ativo';
			$dataStatusModificacao = date('Y-m-d H:i:s');
			$plano = NULL;
			
			sds_updateStatusCliente($statusModificacao, $plano, $dataStatusModificacao, $idCliente);
			
			$executadoComSucesso = 'Cliente ativado com sucesso';
						
			if($clienteStatus == 'ativo' || $clienteStatus == 'desativado' || $clienteStatus == 'patrocinado' || $clienteStatus == 'pendente'){
				echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/'.$clienteStatus.'s">';
			}else{
				echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/ativos">';
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
			echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/'.$clienteStatus.'s">';
		}else{
			echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/ativos">';
		}						
	}
	
	if(isset($_POST['bt-patrocinar'])){

		$statusModificacao = 'patrocinado';
		$plano = strip_tags(trim($_POST['plano-patrocinado']));
		$dataStatusModificacao = date('Y-m-d H:i:s');
		
		sds_updateStatusCliente($statusModificacao, $plano, $dataStatusModificacao, $idCliente);
						
		$executadoComSucesso = 'Cliente patrocinado com sucesso';
		
		if($clienteStatus == 'ativo' || $clienteStatus == 'desativado' || $clienteStatus == 'patrocinado' || $clienteStatus == 'pendente'){
			echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/'.$clienteStatus.'s">';
		}else{
			echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/ativos">';
		}
	}
	
	if(isset($_POST['bt-excluir'])){
		
		sds_deleteCliente($idCliente);
		
		$executadoComSucesso = 'Cliente excluído com sucesso';
			
		echo '<meta http-equiv="refresh" name="Refresh" content="1; URL=painel.php?exe=admin-nav/clientes/ativos">';					
	}
?>

<?php 

if($nivelAcesso == 'admin'){
}
?>



<article class="container-principal">

	<span style="float:left; width:735px; background:#06C; font:14px Arial, Helvetica, sans-serif; color:#fff; padding:0 5px;">

		<?php echo $cadastradoComSucesso ?>

	</span>
   
   <div class="bt-gerenciar">
   
   		 <form name="bt-gerenciadores" action="" method="post" enctype="multipart/form-data">
         
         		<input type="submit" name="bt-excluir" value="Excluir"  id="bt-gerenciador" />
                <input type="submit" name="bt-patrocinar" value="Patrocinar" id="bt-gerenciador" />
                <input type="submit" name="bt-desativar" value="Desativar" id="bt-gerenciador" />
         		<input type="submit" name="bt-ativar" value="Ativar" id="bt-gerenciador" />
                
         
         </form>
   
   </div><!-- FECHA BOTÃO GERENCIAR -->
   
    	<div class="carregando">            
            
            <ul id="cabecalho-email" style="color:#fff;">
                <li style="width:170px;">CLIENTE DENUNCIADO:</li>
                <li style="width:267px;">EMAIL:</li>
                <li style="width:185px;">DENUNCIA:</li>
                <li style="width:100px;">DATA:</li>

            </ul>
            
             
            <?php            
            	$resultado_clienteDenunciados = sds_selectAnuncioDenunciadoGerenciador($idDenuncia);
                
                foreach($resultado_clienteDenunciados as $res_clienteDenunciados){
                    $clienteId        = $res_clienteDenunciados['clienteId'];
                    $idDenuncia        = $res_clienteDenunciados['idDenuncia'];
                    $nomeCliente      = $res_clienteDenunciados['nome'];
					$emailCliente     = $res_clienteDenunciados['email'];
                    $denuncia    	  = $res_clienteDenunciados['denuncia'];
					$dataDenuncia     = $res_clienteDenunciados['dataDenuncia'];
					$respostaDenuncia = $res_clienteDenunciados['respostaDenuncia'];
					
                    $i++;
                    if($i % 2 == 0){
                        $cor = 'style="background:#D9D9D9"';
                    }else{
                        $cor = 'style="background:#f4f4f4;"';
                    }
            
            ?>  
    
              <a href="painel.php?exe=admin-nav/gerenciador&id=<?php echo $clienteId ?>">
                  <ul <?php echo $cor;?> id="email-mensagens">
                    
                    <li style="width:170px; height:18px;"><?php
					
					
					echo substr($nomeCliente,0, 15); echo '...'
					
								 
					 ?></li>
                     
                    <li style="width:267px; height:18px;"><?php echo substr($emailCliente,0, 29); echo '...'; ?></li>
                    <li style="width:185px; height:18px;"><?php echo substr($denuncia,0, 27); echo '...'; ?></li>
                    <li style="width:100px; height:18px;"><?php $dataDenuncia;  echo date('d/m/Y', strtotime($dataDenuncia)); ?></li>
                  </ul>
             </a>
              
            <?php
            }
			$idCliente = $idCliente*(10-(1)+2*3*5*7);
            ?> 
             <span style="color:#333; margin:10px; float:left; font: 14px Arial, Helvetica, sans-serif;">DENÚNCIA:</span>
             <p id="exibir-mensagem"><?php echo $denuncia ?></p>

             <span style="color:#333; margin:10px; float:left; font: 14px Arial, Helvetica, sans-serif; clear:both;">PERFIL DENUNCIADO:</span>
             <p id="exibir-mensagem"><a href="http://localhost/saldaodeservicos/index.php?pg=single&anuncio=<?php echo $idCliente ?>" target="_blank">Ver anúncio</a></p>
             
             <span style="color:#333; margin:10px; float:left; font: 14px Arial, Helvetica, sans-serif; clear:both;">ÚLTIMA RESPOSTA:</span>
             <p id="exibir-mensagem">
			 
			 <?php
             
             if(empty($respostaDenuncia)){
                echo 'Mensagem automática: NENHUMA RESPOSTA ANTERIOR FOI DADA A ESTE E-MAIL!';
             }else{
                 echo $respostaDenuncia; 
             }
			 
			 if(isset($_POST['executar'])){
			 	$mensagemResposta = strip_tags(trim($_POST['mensagem']));
				
				sds_atualizaRespostaDenunciados($mensagemResposta, $idDenuncia);
			 }
				 
            ?></p>
            
             <form name="responderEmail" action="" enctype="multipart/form-data" method="post">
    
                <label>
                   <span style="float:left; clear:both; font:14px Arial, Helvetica, sans-serif; margin:10px; ">RESPOSTA:</span>
                   <textarea name="mensagem" id="mensagem" value=""></textarea>
                </label>
                
                <input type="submit" name="executar" id="executar" value="Enviar Resposta" style="width:725px" />
            
            </form>
            	
            
            
       </div> <!-- FECHA CARREGANDO -->
   
</article><!-- FECHA CONTAINER PRINCIPAL -->

<?php
}else{
include "deslogar.php";
}
 
?>

<?php include_once("footer.php"); ?>