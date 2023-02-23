<?php
session_start();
?>
<html>
    <head>
        <title>Inicio de sesión</title>
        <link rel="stylesheet" href="../css/estilos.css">
    </head>
	<div class="form-log">
        <span class="title">Inicio de sesión</span>
	<form action="princrevisor.php" method="POST" target="_top">
		<h5>Usuario:</h5><input type="text" name="usuario1" class="init">
		<h5>Contrase&ntilde;a:</h5><input type="password" name="clave1" class="init">
		<input type ="submit" value ="Ingresar" class="botton"><br></br>
		<a href="../registro.php" class="a-boton">¿No tienen sesión? Registrate</a>
	</form>
	</div>
</html>