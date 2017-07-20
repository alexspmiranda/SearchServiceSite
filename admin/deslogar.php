<?php include_once("sistema/restrito_all.php"); ?>
<?php include_once("sistema/validar_user.php"); ?>

<?php
	require_once('funcoes/sds_updateAnuncios.php');	
	sds_updateModifacadoEM($idCliente);

// *** Logout the current user.
$logoutGoTo = "";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
session_destroy();
?>
<meta http-equiv="refresh" name="Refresh" content="0; URL=../index.php">	