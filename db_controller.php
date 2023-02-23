<?php

function validar ($categoria, $usuario, $clave)
{
	$sql="SELECT usuario.* FROM usuario WHERE ( usuario.correo='$usuario' AND usuario.password='$clave' ) AND usuario.estado LIKE 'activado';";
	$resultado=mysql_consulta($sql);
	if(mysqli_num_rows($resultado))
	{
		$res=mysqli_fetch_array($resultado);
		$cat_usuario=$res['tipo_usuario'];
		if("Profesional"==$categoria)
		{
			if($cat_usuario==$categoria)
			{
				return $cat_usuario;
			}else{
				die("Operación no autorizada usted no tiene permiso como revisor");
				return 0;
			}
		}
		else if("Alumno"==$categoria)
		{
			if($cat_usuario==$categoria)
			{
				return $cat_usuario;
			}else{
				die("Operación no autorizada usted no tiene permiso como alumno");
				return 0;
			}
		}
	} else {
		die ("Operación no autorizada no se encontro alguien con la cuenta activada para estos datos");
		return 0;
	}
}


function mysql_consulta($consulta)
{
	static $conexion=0;
	if (!$conexion && !($conexion=@mysqli_connect ("localhost", "root","mbpp2312","precartilla"))) 
	{
    		die ("Problemas con la conexión a la base de datos");
    	}
	if (!($result= mysqli_query($conexion,$consulta))) 
	{
    		die ("Problemas con el comando SQL: <br> Consulta: $consulta <br> Error:".mysqli_error($conexion));
    	}
	return $result;
}

function insertQuery($query) {
	$conexion=@mysqli_connect ("localhost", "root","mbpp2312","precartilla");
	$result = mysqli_query($conexion, $query);
	if (!$result) {
		die('Invalid query: ' . mysqli_error($conexion));
	} else {
		return mysqli_insert_id($conexion);
	}
}

function estado_estudio ($estudio, $id_cartilla)
{   
	$sql ="SELECT cartillas.id, $estudio.esp4_estado_estudio, cartillas.id_alumno, usuario.id FROM usuario, cartillas, $estudio WHERE (cartillas.id='$id_cartilla' AND cartillas.id_alumno=usuario.id AND $estudio.id_cartilla='$id_cartilla');";
	$result=mysql_consulta($sql);
	$fila=mysqli_fetch_assoc($result);
	return $fila['esp4_estado_estudio'];
}

function estudio ($post)
{
	if(isset($post['audiometria']))
	{
		$estudio="est1_audiometria";
	}
	else if (isset($post['laboratorio']))
	{
		$estudio="est2_laboratorio";
	}
	else if (isset($post['oftalmologico']))
	{
		$estudio="est3_oftalmologico";
	}
	else if (isset($post['otorrinolaringologico']))
	{
		$estudio="est4_otorrinolaringologico";
	}	else if (isset($post['carnet']))
	{
		$estudio="est5_carnet_de_vacunacion";
	}	else if (isset($post['antecedentes']))
	{
		$estudio="est6_antecedentes_patologicos";
	}
	return $estudio;
}
?>