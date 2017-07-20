<div class="container banner-middle">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- bottom_saldao -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6123794574040714"
     data-ad-slot="5965709383"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
	<!-- <a href="http://saldaodeservicos.com/anuncio/hinode--perfumaria-e-cosmeticos-84"><img src="<?php echo URL::getBase() ?>img/others/banner_top.jpg" height="62" width="438"></a> -->
</div>

<div class="modal hide fade remember-pass" id="compartilhar">
	<div class="modal-header">
   		<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
   		<h3 id="myModalLabel">COMPARTILHE SEU ANÚNCIO</h3>
 	</div>
	
	<img src="<?php echo URL::getBase() ?>img/others/compartilhe.jpg">

	<form  method="post" enctype="multipart/form-data">
		<div class="modal-footer">
			<div class="fb-share-button" data-href="http://saldaodeservicos.com/anuncio/hinode--a-oportunidade-que-voce-sempre-esperou-194" data-layout="button" style="margin:0; padding:10px;"></div>
	    	<input type="submit" value="FECHAR" class="btn btn-primary" name="fecharcompartilhar" />        
	</form>
		</div>
</div>

<footer>
	<div class="container">
		<div class="span12 footer">
			<ul>
				<li><a href="#">Fale conosco </a></li>
				<li><a href="#">Termos de privacidade </a></li>
			</ul>
			<small>Todos os direitos reservados © Saldão de Serviços </small>
		</div>
		<div class="span4 footer follow">
			<h4>Siga-nos no:</h4>
			<a href="https://facebook.com/saldaodeservicos" target="_blank"><img src="<?php echo URL::getBase() ?>img/icon/fbfollow.png" height="32" width="85" alt="Seguir saldão de serviços no facebook"></a>
		</div>
	</div>
</footer>

<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.4&appId=397319460472022";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script src="<?php echo URL::getBase() ?>js/jquery.min.js"></script>
<script src="<?php echo URL::getBase() ?>js/bootstrap-modal.js"></script>
<script src="<?php echo URL::getBase() ?>js/bootstrap-transition.js"></script>

</body>
</html>

<?php 

$statusMensagem = 'patrocinado';
$resultado_selectPatrocinioVencidos= sds_selectPatrocinioVencidos($statusMensagem);

foreach($resultado_selectPatrocinioVencidos as $res_selectPatrocinioVencidos){
	$idClienteVencido  	= $res_selectPatrocinioVencidos['clienteId'];	
	$statusCliente  	= $res_selectPatrocinioVencidos['status'];
	
	$atualiza_patrocinioVencido = sds_updatePatrocinioVencido($idClienteVencido);	
}

?>