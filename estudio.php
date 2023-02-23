<?php



include_once 'funciones.php';


if ($_POST['misma']) {
    $id_cartilla = $_POST['id_cartilla'];
    $estudio = $_POST['estudio'];
    $accion = $_POST['act'];
    $usuario = $_POST['usuario'];
    $estado_estudio = $_POST['estado_estudio'];
    $ac_u = $_POST['ac_u'];
    $id = $_POST['id'];

    // echo"<br>----------POST-----------<br>";
    // print_r($_POST);
    //  echo"<br>----------FILES-----------<br>";
    // print_r($_FILES);
    //  echo"<br>---------------------<br>";




    //cuando alumno completa la carga, envia a revisor y el estado cambia a "Completo" para ser percibido por este (limitar solo para alumno)
    if ($_POST['boton'] == 'Enviar') {
        $res = mysql_consulta("UPDATE `$estudio` SET esp4_estado_estudio = 'Completo' WHERE id_cartilla=$id_cartilla ");

        $_POST['boton'] = 'Guardar';
    }

    //si la carga fue rechazada(estado= "Rechazado"), se permite el reenvío de datos modificados, cambiando nuevamente el estado a completo
    if ($_POST['boton'] == 'Reenviar') {
        $res = mysql_consulta("UPDATE `$estudio` SET esp4_estado_estudio = 'Completo' WHERE id_cartilla=$id_cartilla ");

        $_POST['boton'] = 'Guardar';
    }

    //guardado de datos parciales
    if ($_POST['boton'] == 'Guardar') {
        $variablesinsert = "";
        $valoresinsert = "";




        //ARMADO DE VARIABLES PARA CONSULTA

        if ($_POST) {

            foreach ($_POST as $variable => $valor) {



                if (substr($variable, 0, 2) == "c_") {

                    if ($variablesinsert != '') {
                        $variablesinsert .= ",";
                        $valoresinsert .= ",";
                    }

                    $variablesinsert .= "`" . substr($variable, 2) . "`";
                    $valoresinsert .= "'" . $valor . "'";
                }
            }

            //  echo"<br>----------variables----------<br>";
            //  print_r($variablesinsert);
            //  echo"<br>----------valores-----------<br>";
            // print_r($valoresinsert);
            //  echo"<br>---------------------<br>";

        }
        //consulta según accion
        

        if ($accion == 1) {                                       //AGREGA NUEVO ESTUDIO

            $consulta = "INSERT INTO `$estudio` ($variablesinsert) 
            VALUES ($valoresinsert);";
            $accion = 2;
        } else if ($accion == 2) {                                   //ACTUALIZA TABLA DE ESTUDIO

            $consulta = "UPDATE `$estudio` SET ";

            foreach ($_POST as $variable => $valor) {

                if (substr($variable, 0, 2) == "c_") {

                    $consulta .= "`" . substr($variable, 2) . "`='$valor',";
                }
            }

            $consulta  = substr($consulta, 0, -1);
            $consulta = $consulta . " WHERE id_cartilla=$id_cartilla;";
        }
    }
    // echo"<br> sql= $consulta <br>  "; 
    $res_consulta = mysql_consulta($consulta);
} else {

    foreach ($_POST as $variable => $valor) {
        $$variable = $valor;
    }
}



if (!$estudio) $estudio = estudio($_POST);



$usuario = $_SESSION['tipo_usuario'];
$estado_estudio = estado_estudio($estudio, $id_cartilla);



$result = mysql_consulta("SELECT id FROM `$estudio` WHERE id_cartilla=$id_cartilla");
$id = mysqli_fetch_assoc($result);


if ($usuario == 'Alumno' and ($estado_estudio == 'Completo' or  $estado_estudio == 'Aprobado')) { //si el estudio esta completo o aprobado solo puede visualizar
    $accion = 0;
} elseif (empty($id) and $usuario == 'Alumno') { //si no existe el estudio creo uno nuevo
    $accion = 1;
} else {
    $accion = 2;  //puede editar estudio
}



/////permisos segun usuario y estado del estudio para acceder a campos especiales
if (!$_POST['ac_u']) $ac_u = '';

if ($usuario == 'Alumno') {
    switch ($estado_estudio) {
        case 'Incompleto':
            $ac_u = 0;
            break;

        case 'Completo':
            $ac_u = 1;
            break;

        case 'Rechazado':
            $ac_u = 2;
            break;

        case 'Aprobado':
            $ac_u = 3;
            break;
    }

    $volver = 'cartilla1.php'; //enlace de boton volver
}
if ($usuario == 'Profesional') {
    switch ($estado_estudio) {
        case 'Incompleto':
            $ac_u = 4;
            break;

        case 'Completo':
            $ac_u = 5;
            break;

        case 'Rechazado':
            $ac_u = 6;
            break;

        case 'Aprobado':
            $ac_u = 7;
            break;
    }
    $volver = 'profesional/menu_estudios.php';
}




//---------------------CARGA DE ARCHIVO EN CARPETA-----------------
if ($usuario == 'Alumno') {

    if ($_FILES['archivo']['error'] > 0) {

        // echo "No se cargó archivo";
    } else {
        
        $ruta = __DIR__.DIRECTORY_SEPARATOR.'archivos'.DIRECTORY_SEPARATOR.$id_cartilla.DIRECTORY_SEPARATOR;
                
        if (!file_exists($ruta)) {  //si no existe carpeta para ese id_cartilla, la creo.
         mkdir($ruta);
         }
                
        $archivo = $ruta.$estudio.str_replace(' ', '',basename($_FILES['archivo']['name']));
        //obtengo enlace desde la bd
        $result = mysql_consulta("SELECT esp1_archivo FROM `$estudio` WHERE id_cartilla=$id_cartilla");
        $campoArchivo = mysqli_fetch_assoc($result);

        if (!file_exists($campoArchivo)) { //si no existe archivo, lo guardo
            $resultado = @move_uploaded_file($_FILES['archivo']['tmp_name'], $archivo); //mueve el archivo desde ruta de formulario a la ruta especificada
            if ($resultado) {
                $archivo = addslashes($archivo); //agrego barras para que se guarde en bd, caso contrario se guarda direccion sin barras

                if ($accion == 1) {
                    $res = mysql_consulta("INSERT INTO `$estudio` (esp1_archivo) VALUES ($archivo) ;");
                } else if ($accion == 2) {
                    $res = mysql_consulta("UPDATE `$estudio` SET esp1_archivo='$archivo' WHERE id_cartilla=$id_cartilla;");
                }

                if ($res) {

                    // echo" <strong><font align: 'center' family: 'Times New Roman' color='blue' size='3.5'> Archivo Guardado   </font></strong>";
                } else {
                    echo "Problemas con el comando SQL: <br> Consulta: <br> $res <br> Error:";
                    echo "Error";
                    echo mysqli_error($res);
                }
            } 
        } 
    }
}




//---------------------ARMADO DEL FORMULARIO-----------------//


$estudio2 = explode('_', $estudio);
$estudio2[1] = ucfirst($estudio2[1]);

echo "<html>
 <head><title>$estudio2[1] $estudio2[2] $estudio2[3]</title>
 <link rel='stylesheet' href='css/estilos.css'>

 </head>
 
 ";

echo "<body>
<br></br><br></br><br></br>
    <div class='form-title'>
    <strong><span style='FONT-SIZE: 25pt; FONT-FAMILY: Tahoma;COLOR:grey'> Carga de Estudio: $estudio2[1] $estudio2[2] $estudio2[3]</span>
   </div>";




echo "
        
<form action='estudio.php' method='POST' enctype='multipart/form-data'>
             
";


armar_formulario($estudio, "id_cartilla=$id_cartilla", $accion, $id_cartilla, $ac_u);

if ($estado_estudio == 'Rechazado') {
    $boton3 = 'Reenviar';
} else {
    $boton3 = 'Enviar';
}

switch ($accion) {
    case 0:
        echo "
        <table>
        <tr>
        <td>
            <input type=submit name=boton  value='Volver' formaction='$volver'>
        </td>
        </tr>
     ";
        break;

    case 1:
        echo "
        <table>
        <tr>
        <td colspan=2>
            <input type=submit name=boton value='Guardar'>
        </td>
        </tr>
        <tr>
        <td colspan=2>
           <input type=submit name=boton value='Volver' formaction='$volver'>
           
        </td>
        </tr>
        
        ";
        break;

    case 2:
        echo "
        <table>
        <br><tr>
        <td colspan=2>
            <input type=submit name=boton value='Guardar'>
        </td>
        </tr>
        <tr>
        <td colspan=2>
           <input type=submit name=boton value='Volver' formaction='$volver'>
           
        </td>
        </tr>
       
        ";
        if ($usuario == 'Alumno') {
            echo "  <table>
            <center><p> <strong><font align: 'center' family: 'Times New Roman' color='grey' size='3.5'>
            Carga de estudio completa:<br> Al enviar, el formulario quedará deshabilitado para posteriores modificaciones
            </font></strong></p></center>
            
            <td>
            <input  type=submit name=boton value=$boton3 >          
            </td>
            
            ";
        }
        break;
}
echo "
</table>
<input type=hidden name=misma value=1>
<input type=hidden name=act value=$accion>
<input type=hidden name=estudio value=$estudio>
<input type=hidden name=id_cartilla value=$id_cartilla>
<input type=hidden name=estado_estudio value=$estado_estudio>
<input type=hidden name=usuario value=$usuario>
<input type=hidden name=ac_u value=$ac_u>
<input type=hidden name=archivo value=$campoArchivo
<input type=hidden name=id value=$id>






</form>
</body>
</html>
";