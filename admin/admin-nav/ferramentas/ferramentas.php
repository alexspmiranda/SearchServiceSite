<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>
 
<?php

if($nivelAcesso == 'admin'){

?>

<?php include_once("header.php"); ?>
	
<article class="container">
    <br>  
	<h4>Ferramentas</h4>
    
    <nav class="submenu-admin">
        <ul class="inline unstyled">
            <a href="<?php echo URL::getBase() ?>painel/ferramentas/"><li class="submenu"> Ferramentas  </li></a>
        </ul>
    </nav>

    	<?php 
    		include "../Connections/config.php";

    		if(isset($_POST['cadastraProfissao'])){
    			
    			$nome = strip_tags(trim($_POST['profissao']));

	    		try{
					$sql_alteraProfissao  = 'INSERT INTO sds_profissoes (nome) VALUES(:nome)';
					
					$query_alteraProfissao = $connect->prepare($sql_alteraProfissao);
					$query_alteraProfissao->bindValue(':nome', $nome, PDO::PARAM_STR);
					$query_alteraProfissao->execute();
					
					$cadastradoComSucesso = 'Atualizado com sucesso';
					
				}catch(PDOException $erro_atualizarSenha){
					echo 'Erro ao atualizar senha';
				}
			}
?>
			<form id="form-pesquisa" class="search-bar" method="post" enctype="multipart/form-data">
				<input type="text" name="profissao" id="pesquisa"  onkeyup="autoCompleteCat()" > 
				<ul id="pesquisa_list_id"></ul>
    			<input type="submit" name="cadastraProfissao" class="btn btn-primary" >
    		</form>
    
</article><!-- FECHA CONTAINER PRINCIPAL -->
  
<?php

}else{
include "deslogar.php";
}
 
?>
<?php include_once("footer.php"); ?>