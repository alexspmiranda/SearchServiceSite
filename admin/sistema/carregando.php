<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
  $(function(){
	  $("#executar").click(function(){
		  
		 beforeSend:$("#carregando").fadeIn("slow"); 		  
	});
  })
</script>


<div id="carregando_barra" style="display:none;">
	<img src="images/load.gif" alt="Carregando, aguarde..." />Carregando, aguarde...
</div> <!--FECHA CARREGANDO BARRA -->