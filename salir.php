<html>
	<head>
		<title>Finalizar Sesión</title>
			<?php
				session_destroy();
				die("<META http-equiv= 'refresh' content = '0;URL=ingresar_alumno.php'>");
			?>
	</head>
	<body>
	</body>
</html>