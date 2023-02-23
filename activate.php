<?php
	require_once("db_controller.php");
	if(!empty($_GET["id"])) {
	 $sql="SELECT fecha_act from usuario  WHERE id='" . $_GET["id"]. "'";
	 $result = mysql_consulta($sql);
	 $fech=mysqli_fetch_row($result);

	 if(date("Y-m-d", strtotime("0000-00-00"))==date("Y-m-d", strtotime($fech[0]))){
		@$diaact=date("j");
        @$mesact=date("m");
        @$anoact=date("Y");
        $fechaact= $anoact."-".$mesact."-".$diaact;

	$query = "UPDATE usuario set estado= 'activado', fecha_act='$fechaact' WHERE id='" . $_GET["id"]. "'";
	$result = mysql_consulta($query);
		if(!empty($result)) {
			$message = "Tu cuenta está activa.";
			$type = "success";
			echo"
			<a href='http://localhost/Proyecto/ingresar_alumno.php' ' class='boton'> Iniciar Sesión</a>";
		} else {
		    $message = "Problema en la activación de la cuenta.";
		    $type = "error";
		}
	} else{
		$message = "El link de activación ha caducado. Registrese nuevamente";
        $type = "error";
	}

}
?>
<html>
<head>
<title>PHP User Activation</title>
<link href="style.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php if(isset($message)) { ?>
<div class="message <?php echo $type; ?>"><?php echo $message; ?></div>
<?php } ?>
</body></html>
		