<?php 

require_once "../nav/func/funcoes.php";
require '../phpmailer/class.phpmailer.php';
require '../phpmailer/PHPMailerAutoload.php';
require_once('func/functions.php');
require_once('func/functions_notif.php');
require_once('func/imagem_upload.php');

//NOVAS FUNCOES
require_once('funcoes/sds_deleteMensagens.php');
require_once('funcoes/sds_deleteGerenciadorAdmin.php');
require_once('funcoes/sds_insertAnuncios.php');
require_once('funcoes/sds_selectAnuncios.php');
require_once('funcoes/sds_selectMensagens.php');
require_once('funcoes/sds_selectMensagensAdmin.php');
require_once('funcoes/sds_selectGerenciadorAdmin.php');
require_once('funcoes/sds_updateGerenciadorAdmin.php');
require_once('funcoes/sds_updateAnuncios.php');
require_once('funcoes/sds_updateMensagens.php');

?>

<?php 
    $fbid   = $_SESSION['FBID'];
    $nomef  = $_SESSION['FULLNAME'];
?>

<html> 
<head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Encontre empresas e prestadores de serviços de todo o Brasil. Anuncie grátis seus serviços ou de sua empresa e aumente seus lucros." />

	<link rel="stylesheet" type="text/css" href="<?php echo URL::getBase() ?>css/bootstrap.min.css" media="all"/>
 	<link rel="stylesheet" type="text/css" href="<?php echo URL::getBase() ?>css/style.css"/>
 	<link rel="stylesheet" type="text/css" href="<?php echo URL::getBase() ?>css/stylez.css"/>
	<!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
    <![endif]-->

 	<link rel="shortcut icon" href="img/icon/icon.png">  
    <title>Saldão de serviços - Anuncie grátis</title>
</head>

<body>
<header class="container-fluid header">
	<div class="container">
		<a href="<?php echo URL::getBase() ?>painel"><img src="<?php echo URL::getBase() ?>img/others/logo.png" alt="Logo do saldão de serviços" class="logo hidden-phone"></a>
		<a href="<?php echo URL::getBase() ?>painel"><img src="<?php echo URL::getBase() ?>img/others/logo_mobile.png" alt="Logo do saldão de serviços" class="logo logomobile visible-phone"></a>
		
		<div class="header-info">
			<div class="navbar">
              
                        <ul class="nav">
							<a href="<?php echo URL::getBase() ?>painel/deslogar"><li>Sair</li></a>
                        </ul>
               
       		</div>

			<div class="banner-top hidden-phone">
				<a href="http://saldaodeservicos.com/anuncio/hinode--perfumaria-e-cosmeticos-84"><img src="<?php echo URL::getBase() ?>img/others/banner_top.jpg"></a>
			</div>
		</div>		
	</div>

<nav class="container-fluid menu">

<?php 
if(!empty($_SESSION['FBID']))
    $nivelAcesso = 'cliente';
if($nivelAcesso == 'cliente'){

?>
<div class="container">
    <nav class="header-menu">
        <ul class="unstyled"> 
            <a href="<?php echo URL::getBase() ?>painel/"><li> Painel de controle</li></a>
            <a href="<?php echo URL::getBase() ?>painel/conta/"><li> Minha conta</li></a>
            <a href="<?php echo URL::getBase() ?>painel/anuncio/"><li> Meu anúncio</li></a>
            <a href="<?php echo URL::getBase() ?>painel/inbox/"><li> Minhas mensagens</li></a>

            <?php 

                if($email == 'mvvendas@hotmail.com'){
                    echo '<a href="'. URL::getBase() .'painel/patrocinado"><li> Anúncio patrocinado</li></a>';
                    echo '<a href="'. URL::getBase() .'../../ajuda" target="_blank"><li> Ajuda</li></a>';
                }

            ?>
        </ul>
    </nav> <!-- FECHA MENU NAVEGACAO -->
</div>

<!-- <div class="container-fluid">
    <span class="warnings-panel">
        <ul class="unstyled">
            <li>Você recebeu uma nova mensagem</li>
            <li>Faltam 6 dias para seu anúncio expirar</li>
        </ul>
    </span>
</div> -->
</nav>

<?php 
    if(isset($_POST['salvar-cadastra-clientefbid'])){
        sds_cadastrafbid($nomef, $fbid);
        
        $nomef = strip_tags(trim($_POST['nome-completo']));
        $emailf = strip_tags(trim($_POST['email']));
        
        $sql_verifica_email = 'SELECT email FROM sds_clientes WHERE email = :email;';
    
    try{
        $query_verifica_email = $connect->prepare($sql_verifica_email);
        $query_verifica_email->bindValue(':email', $emailf , PDO::PARAM_STR);
        $query_verifica_email->execute();
        
        $res_verifica_email = $query_verifica_email->rowCount(PDO::FETCH_ASSOC);

    }catch(PDOException $erro_verifica_email){
        echo "Erro ao verificar email";
    }
                
    if($res_verifica_email >= 1 ){
        echo '<br><div class="container"><div class="alert alert-danger" role="alert">Email já cadastrado! Tente outro email.</div></div>';
    }else{
            sds_atualizaDadosPessoaisPrimeiroAcesso($fbid, $nomef, $emailf);
    }
    }

    if(empty($email)){?>
        <br>
        <div class="container">
        <h4>Seja bem-vindo, <?php echo $nomef; ?>. </h4><br>
        <div class="alert alert-info" role="alert">Escolha seu nome e email permamente. Boas vendas!</div>
            
            <span  style="float:left; width:220px;">
                 <form method="post" enctype="multipart/form-data">
                    
                    <h5>Nome: </h5>
                    <input type="text" name="nome-completo" value="<?php echo $nomef; ?>" required />

                    <h5>Email: </h5>
                    <input type="text" required name="email" placeholder="seuemail@email.com" value="<?php echo $emailf; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" size="35" />
                     
                    <input type="submit" name="salvar-cadastra-clientefbid" value="Salvar dados" class="btn btn-primary" style="clear:both; float:right;" />  
                </form>
            </span>  
        </div>
    <?php exit; } ?>

<?php

    $resultado_consultaCadastro = sds_selectMeusDados($idCliente);

    foreach ($resultado_consultaCadastro as $res_consultaCadastro) {
        $nome           = $res_consultaCadastro['nome'];
        $cpf            = $res_consultaCadastro['cpfCnpj'];
        $sexo           = $res_consultaCadastro['sexo'];
    }

    $resultado_consultaAnuncio = sds_selectAnuncioPainel($idCliente);

    foreach ($resultado_consultaAnuncio as $res_consultaAnuncio) {
        $idAnuncio           = $res_consultaAnuncio['idAnuncio'];
        $anuncioUrlP         = $res_consultaAnuncio['linkPessoalAnuncio'];
        $anuncioNomeP        = $res_consultaAnuncio['nomeFantasiaAnuncio'];
        $anuncioTituloP      = $res_consultaAnuncio['tituloAnuncio'];
        $anuncioCategoriaP   = $res_consultaAnuncio['categoriaAnuncio'];
        $anuncioEnderecoP    = $res_consultaAnuncio['enderecoAnuncio'];
        $anuncioCepP         = $res_consultaAnuncio['cepAnuncio'];
        $anuncioBairroP      = $res_consultaAnuncio['bairroAnuncio'];
        $anuncioCidadeP      = $res_consultaAnuncio['cidadeAnuncio'];
        $anuncioEstadoP      = $res_consultaAnuncio['estadoAnuncio'];
        $anuncioTelefoneP    = $res_consultaAnuncio['telefoneAnuncio'];
        $anuncioTelefone2P   = $res_consultaAnuncio['telefoneAnuncio2'];
        $anuncioDescricaoP   = $res_consultaAnuncio['descricaoAnuncio'];            
        $estadoNomeP         = $res_consultaAnuncio['uf'];
    }
?>

<div class="modal hide fade" id="pending">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Pendências no cadastro</h3>
    </div>
 
    <div class="modal-body">
        <span class="info-pending">
            <?php 
                $cont=0;
                if(verificar_urlAdmin($idAnuncio, '1')){ $cont += 5; }else{echo "Imagem no anúncio ".' <a href="'. URL::getBase() .'painel/anuncio/fotos"> - ( Inserir foto ) </a><br>';}
                if(verificar_urlAdmin($idAnuncio, 'profile')){$cont += 5; }else{echo "Imagem de perfil".' <a href="'. URL::getBase() .'painel/conta"> - ( Inserir foto ) </a><br>';}
                if(!empty($nome)){ $cont += 7; }
                if(!empty($cpf)){ $cont += 7; }
                if(!empty($sexo)){ $cont += 7; }
                if(!empty($anuncioUrlP)){ $cont += 9; }else{ echo $anuncioUrlP = "Endereço (URL) do anúncio".' <a href="'. URL::getBase() .'painel/anuncio/"> - ( Inserir dados ) </a><br>';}
                if(!empty($anuncioNomeP)){ $cont += 9; }else{ echo $anuncioNomeP = "Nome da empresa/prestador".' <a href="'. URL::getBase() .'painel/anuncio/"> - ( Inserir dados ) </a><br>';}
                if(!empty($anuncioTituloP)){ $cont += 10; }else{echo $anuncioTituloP = "Título do anúncio".' <a href="'. URL::getBase() .'painel/anuncio/"> - ( Inserir dados ) </a><br>';}
                if(!empty($anuncioCategoriaP)){ $cont += 11; }else{ echo $anuncioCategoriaP = "Categoria do anúncio".' <a href="'. URL::getBase() .'painel/anuncio/"> - ( Inserir dados ) </a><br>';}
                if(!empty($anuncioBairroP)){ $cont += 11; }else{echo $anuncioBairroP = "Bairro da empresa/prestador".' <a href="'. URL::getBase() .'painel/anuncio/"> - ( Inserir dados ) </a><br>';}
                if(!empty($anuncioCidadeP)){ $cont += 8; }else{echo $anuncioCidadeP = "Cidade da empresa/prestador".' <a href="'. URL::getBase() .'painel/anuncio/"> - ( Inserir dados ) </a><br>';}
                if(!empty($anuncioEstadoP)){ $cont += 12; }else{echo $anuncioEstadoP = "Estado da empresa/prestador".' <a href="'. URL::getBase() .'painel/anuncio/"> - ( Inserir dados ) </a><br>';}
                if(!empty($anuncioTelefoneP)){ $cont += 8; }else{echo $anuncioTelefoneP = "Telefone para contato".' <a href="'. URL::getBase() .'painel/anuncio/"> - ( Inserir dados ) </a><br>';}
                if(!empty($anuncioDescricaoP)){ $cont += 5; }else{echo $anuncioDescricaoP = "Descrição do anúncio".' <a href="'. URL::getBase() .'painel/anuncio/"> - ( Inserir dados ) </a><br>';}
            ?>
        </span>
    </div>
 
    <div class="modal-footer">
        <form  method="post" enctype="multipart/form-data">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
        </form>
    </div>

</div>
<?php if($cont < 100){?>
<div class="container loadsave">
    <h5>Cadastro em progresso</h5>
    <div class="progress">
        <div class="progress-bar" style="width: <?php echo $cont; ?>%;">
            <?php if($cont < 30){?>
                    <?php echo $cont; ?>% 
            <?php }else{ ?>
                    Cadastro <?php echo $cont; ?>% concluído
            <?php } ?>
        </div>
    </div>
    <h5 style="margin-top:-20px;"><a data-toggle="modal" href="#" data-target="#pending">Ver pendências</a></h5>
</div>
<?php } ?>

<div class="container">
<?php 

$resultado_consultaCadastro =  sds_selectMeusDados($idCliente);

foreach($resultado_consultaCadastro as $res_consultaCadastro){
    $clienteStatus = $res_consultaCadastro['status'];
}
if($clienteStatus != 'aguardando' || $clienteStatus != 'desativado' || $clienteStatus != 'pendente')
{?>
    <!-- <img src="<?php echo URL::getBase() ?>img/others/compartilhe.jpg"> -->
<?php } ?>
</div>


<?php }elseif($nivelAcesso == 'admin'){ ?>
    <div class="container-fluid">
        <nav class="header-menu">
            <ul class="unstyled"> 
                <a href="<?php echo URL::getBase() ?>painel/"><li> Painel de controle</li></a>
                <a href="<?php echo URL::getBase() ?>painel/users/dados"><li> Opções de usuários</li></a>
                <a href="<?php echo URL::getBase() ?>painel/clientes/ativos"><li> Clientes	</li></a>
                <a href="<?php echo URL::getBase() ?>painel/financeiro/pag_processamento"><li> Pagamentos </li></a>
                <li><a href="<?php echo URL::getBase() ?>painel/inbox/"> Mensagens </a></li>
                <li><a href="<?php echo URL::getBase() ?>painel/tickets/tickets"> Suporte ao cliente</a></li>
                <li><a href="<?php echo URL::getBase() ?>painel/ferramentas/"> Ferramentas </a></li>
                <a href="<?php echo URL::getBase() ?>painel/denuncia/denunciados"><li> Denúncias </li></a>
                <a href="<?php echo URL::getBase() ?>deslogar.php"><li>Sair</li></a>
            </ul>
        </nav> <!-- FECHA MENU NAVEGACAO -->
    </div>
</nav>
<?php 
	}else{
		include"deslogar.php"; 
	} 
?>
</header>