<?php



if(count($_POST)>0) {
	/* Form Required Field Validation */
	foreach($_POST as $key=>$value) {
	if(empty($_POST[$key])) {
	$message = ucwords($key) . " este campo es requerido";
	$type = "error";
	break;
	}
	}
	/* Password Matching Validation */
	if($_POST['password'] != $_POST['confirm_password']){ 
	$message = 'Las contraseñas deben ser iguales<br>'; 
	$type = "error";
	}

	/* Email Validation */
	if(!isset($message)) {
	if (!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
	$message = "Mail no válido";
	$type = "error";
	}
    }
}


	
	if(!isset($message) and ($_POST['boton']=='Registrarse')) {
		require_once("db_controller.php");
		$query = "SELECT * FROM usuario where correo = '" . $_POST["userEmail"] . "'";
		$result=mysql_consulta($query);
		$count =mysqli_num_rows($result);
		
		if($count==0) {
			$query = "INSERT INTO usuario (nombre, apellido, password, correo, dni, fecha_nacimiento, sexo, domicilio, telefono) VALUES
			( '" . $_POST["firstName"] . "', '" . $_POST["lastName"] . "', '" . md5($_POST["password"]) . "', '" . $_POST["userEmail"] . "','" . $_POST["dni"] . "','" . $_POST["fecha_nacimiento"] . "','" . $_POST["sexo"] . "','" . $_POST["domicilio"] . "','" . $_POST["telefono"] . "')";
			$current_id = insertQuery($query);
			if(!empty($current_id)) {
				$actual_link = "http://$_SERVER[HTTP_HOST]/Proyecto/"."activate.php?id=" . $current_id;
				$toEmail = $_POST["userEmail"];
				$from = "informedica520@gmail.com";
				$subject = "Mail de activación de usuario";
				$content = "Click en este link para activar la cuenta. ".$actual_link."";
				$mailHeaders = "From:". $from;
				if(mail($toEmail, $subject, $content, $mailHeaders)) {
					$message = "Te has registrado con éxito, ya se envió un mail para activar tu cuenta. Haz click en el link enviado para activar tu cuenta.";	
					$type = "success";
				}
				unset($_POST);
			} else {
				$message = "Problema en el registro. Intente nuevamente!";	
			}
		} else {
			$message = "El mail ya está en uso.";	
			$type = "error";
		}
	}
	

?>
<html>
<head>
<title>Formulario de registro</title>
<link rel='stylesheet' href='css/estilos.css'>
</head>
<body>
<br></br>
<br></br>
<form name="frmRegistration" method="post" action="">
<table colspan=2>
<?php if(isset($message)) { ?>
<div class="message <?php echo $type; ?>"><?php echo $message; ?></div>
<?php } ?>
<tr>
<td>Usuario (ingrese su correo electrónico en este campo)</td>
<td><input type="text" class="demoInputBox"  name="userEmail" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>"></td>
</tr>
<tr>
<td>Nombre</td>
<td><input type="text" class="demoInputBox" name="firstName" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>"></td>
</tr>
<tr>
<td>Apellido</td>
<td><input type="text" class="demoInputBox" name="lastName" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>"></td>
</tr>
<tr>
<td>Contraseña</td>
<td><input type="password" class="demoInputBox" name="password" value=""></td>
</tr>
<tr>
<td>Confirmacion de contraseña</td>
<td><input type="password" class="demoInputBox" name="confirm_password" value=""></td>
</tr>
<tr>
<td>DNI</td>
<td><input type='int' name='dni'  class='demoInputBox' value="<?php if(isset($_POST['dni'])) echo $_POST['dni']; ?>"></td>
</tr>
<tr>
<td>Domicilio</td>
<td id='result'><input type='text' name='domicilio' class='demoInputBox' value="<?php if(isset($_POST['domicilio'])) echo $_POST['domicilio']; ?>"></td>
</tr>
<tr>
<td>Sexo</td>
<td><select  name='sexo'  class='demoInputBox'>
                <option $bf>Femenino</option>
                <option $bm>Masculino</option>
                <option $bo>Otros</option>
                </select></td>
</tr>
<tr>
<td>Fecha de Nacimiento</td>
<td><input type='date' name='fecha_nacimiento' class='demoInputBox' value="<?php if(isset($_POST['fecha_nacimiento'])) echo $_POST['fecha_nacimiento']; ?>"></td>
</tr>
<tr>
<td>Teléfono</td>
<td><input type='int' name='telefono' class='demoInputBox' value="<?php if(isset($_POST['telefono'])) echo $_POST['telefono']; ?>"></td>
</tr>


</table>
<div>
</form>
<table>
<td>	
<input type="submit" name="boton" value="Registrarse" class="btnRegistrarse">
</td>
</table>
<input name="act" type="hidden" value="$act">
<input name="current_id" type="hidden" value="$current_id">
</div>
</form>
</body></html>