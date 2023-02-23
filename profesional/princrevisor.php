<?php
    require_once('../db_controller.php');
    //obtengo los valores ingresados en la pagina anterior
    if($_POST['usuario1'])$_SESSION['usuario']=$_POST['usuario1'];
	if($_POST['clave1']) $_SESSION['clave']=md5($_POST['clave1']);
    $usuario=$_SESSION['usuario'];
	$clave=$_SESSION['clave'];
    //evaluo si es un profesional el que ingresa
    $_SESSION['tipo_usuario']=validar("Profesional",$usuario, $clave);
    //obtengo información de la base de dato del usuario
    $sql ="SELECT nombre, apellido, id FROM usuario WHERE correo='$usuario'; ";
    $result = mysql_consulta($sql);
    $fila=mysqli_fetch_assoc ($result); 
    $_SESSION['id_usuario']=$fila['id']; 
    echo"
        <html>
        <head>
            <title>Página Principal</title>
            <link rel='stylesheet' href='../css/estilos.css'>
        </head>
        <body>
    ";
    
        foreach($_POST as $key=>$val)
            {
                $$key=$val;
            } 

        echo" 
        <div class='boton-sec'>
            <a href='../salir.php?' class='boton' >Cerrar sesión</a> | <a href='../actualizacion.php?act=1' class='boton'>Actualizar datos personales</a> |
            <a href='../actualizacion.php?act=2' class='boton'>Cambiar contraseña</a>
        </div>
        <br></br><br></br><br></br>
        <div class='form-title'>
            <span class='title'>Bienvenido/a ".$fila['apellido'].", ".$fila['nombre']."! </span><br></br>
            <a href='filtros.php?' class='boton'>Busqueda Personalizada</a>
        </div>";

        echo "<div class='form'>";
        echo "<table class='form'>
        <tr>
            <th colspan=6 id_cartilla='result'><span>Pendientes de Revisar</span></th>
        </tr>
        <tr>
            <th id_cartilla='result'>Apellido</th>
            <th id_cartilla='result'>Nombre</th>
            <th id_cartilla='result'>DNI</th>
            <th id_cartilla='result'>Estado Pre-cartilla</th>
            <th id_cartilla='result'>Fecha de cambio de estado</th>
            <th id_cartilla='result'>Acción</th>
        </tr>
        ";
        $sql = "SELECT usuario.apellido, usuario.nombre, usuario.dni, cartillas.id, estado.estado, estado.fecha FROM usuario, cartillas, estado 
        WHERE (cartillas.id_alumno=usuario.id AND cartillas.id=estado.id_cartilla) AND estado.estado LIKE 'Completo'
        ORDER BY estado.fecha ASC, usuario.apellido, usuario.nombre, usuario.dni;";
        $result = mysql_consulta($sql);
        $numfilas = mysqli_num_rows ($result);
        if ($numfilas)
        {
            while ($fila=mysqli_fetch_array ($result))
            {
                echo"
                    <tr>
                        <td id_cartilla='result'>".$fila['apellido']."</td>
                        <td id_cartilla='result'>".$fila['nombre']."</td>
                        <td id_cartilla='result'>".$fila['dni']."</td>
                        <td id_cartilla='result'>".$fila['estado']."</td>
                        <td id_cartilla='result'>".$fila['fecha']."</td>
                        <td id_cartilla='result'><a href='menu_estudios.php?id_cartilla=".$fila['id']."' class='boton_act'>Ver</a></td>
                    </tr>
                ";
            }
        }
        echo"
            </div>
            </table>
            </body>
            </form>
        ";

?>