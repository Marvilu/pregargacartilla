<?php




function Fecha($fecha)
{
    if (!$fecha) return NULL;
    $anio = substr($fecha, 0, 4);
    $mes = substr($fecha, 5, 2);
    $dia = substr($fecha, 8, 2);
    $fecha = $dia . "-" . $mes . "-" . $anio;
    return $fecha;
}


function Fecha_Ver($fecha)
{
    if (!$fecha) return NULL;
    $anio = substr($fecha, 0, 4);
    $mes = substr($fecha, 5, 2);
    $dia = substr($fecha, 8, 2);
    $hora = substr($fecha, 11, 2);
    $minutos = substr($fecha, 14, 2);
    $fecha = $dia . "-" . $mes . "-" . $anio . " " . $hora . ":" . $minutos;
    return $fecha;
}

function Fecha_Grabar($fecha)
{

    if (!$fecha) return NULL;

    $variable = strchr($fecha, " ");
    if ($variable) {
        $partetime = explode(" ", $fecha);
        $fecha = $partetime[0];
        $hora = $partetime[1];
    }
    $variable1 = strchr($fecha, "/");
    if ($variable1) {
        $partefecha = explode("/", $fecha);
        $dia = $partefecha[0];
        $mes = $partefecha[1];
        $ano = $partefecha[2];
    } else {
        $partefecha = explode("-", $fecha);
        $dia = $partefecha[0];
        $mes = $partefecha[1];
        $ano = $partefecha[2];
    }

    $fechavalida = checkdate($mes, $dia, $ano);

    $variable2 = strchr($hora, ":");
    if ($variable2) {
        $partehora = explode(":", $hora);
        $hora = $partehora[0];
        $minutos = $partehora[1];
        $segundos = $partehora[2];
    }
    if ($hora >= 0 and $hora <= 23 and $hora != NULL) {
        $time = $hora;
        if ($minutos >= 0 and $minutos <= 59 and $minutos != NULL) {
            $time .= ":$minutos";
        }
        if ($segundos >= 0 and $segundos <= 59 and $segundos != NULL) {
            $time .= ":$segundos";
        }
    }

    if ($fechavalida) {

        $fecha = "$ano-$mes-$dia $time";
        return $fecha;
    } else {
        return -1;
    }
}


function mensaje($mens)
{
    return "<table align='center' border='0' cellpadding='1' width='50%' >
                 <tr>
                    <td align='center' rowspan='2' colspan='2'><font color='#FF0000' size='3'>
                    <strong>$mens</strong></font>
                    </td>
                 </tr>
            </table>";
}

///*********funcion consulta********///
/********recibe solo la consulta****/
/*******  retorna result ********/


function mysql_consulta($consulta)
{

    static $conexion = 0;

    //ECHO mensaje($conexion);

    //     le saque un ! antes del primer $conexion

    global $usuario_mysql, $clave_mysql;
    $conexion = mysqli_connect('localhost', 'root', 'mbpp2312', 'precartilla');
    if (!$conexion) {
        echo "Problemas con la conexion a la base de datos";
        echo "<a href= princalumno.php'> Volver1 </a> ";
        exit;
    }


    if (!($result = @mysqli_query($conexion, $consulta))) {
        echo "Problemas con el comando SQL: <br> Consulta: <br> $consulta <br> Error:" . mysqli_error($conexion);
        echo "<a href='princalumno.php'> Volver2 </a>";
        exit;
    }
    return $result;
}

///FUNCIONES DE FORMULARIOS
//Funcion checkbox

function CheckBox($nvariable, $ntabla, $ncampo, $valor = '', $disabled)
{

    $listado = ExtraerValores($ntabla, $ncampo);

    foreach ($listado as $nombre) {
        $valor = ' ' . $valor;
        echo $nombre . '<input type="checkbox" ' . $disabled . ' value="' . $nombre . '" name="' . $nvariable . '_' . $nombre . '" ';
        if (strpos($valor, $nombre))
            echo " checked ";

        echo '> ';
    }

    return;
}



//funcion ListaDesplegable


//funcion ExtraerValores de la tabla de los campos Enum Set

function ExtraerValores($ntabla, $ncampo)
{


    $sql = 'SHOW COLUMNS FROM ' . $ntabla . " LIKE '" . $ncampo . "'";

    $campo = mysql_consulta($sql);
    $fila = mysqli_fetch_array($campo);

    // foreach($fila as $celda) {
    //  echo $celda;
    // }

    $cadena = $fila[1];
    $cadena = substr(strrchr($cadena, "("), 1);

    do {
        $valor = $lista[] = substr($cadena, 1, strpos($cadena, ',') - 2);
        $cadena = substr($cadena, strlen($valor) + 3);
    } while ($cadena);

    return $lista;
}
function accion($mensaje)
{

    echo "<p align='left'><font face='Verdana, Arial, Helvetica, sans-serif' color='#000000' size='3'><strong>$mensaje</strong></font></p>";
}
function accion1($mensaje1)
{

    echo "<p align='left'><font face='Verdana, Arial, Helvetica, sans-serif' color='#FF0000' size='2'><strong>$mensaje1</strong></font></p>";
}

function accion2($mensaje2)
{

    echo "<p align='left'><font face='Verdana, Arial, Helvetica, sans-serif' color='#000000' size='2'><strong>$mensaje2</strong></font></p>";
}


/*
Esta funci�n crea un formulario autom�ticamente a partir del n�mero de prestaci�n, del
tipo de prestaci�n y de la acci�n.

acciones posibles: 0-Ver 1-Nuevo 2-Modificar.
*/




function armar_formulario($tabla, $condicion, $accion, $id_cartilla, $ac_u)
{



    $consulta = "SELECT * FROM $tabla WHERE $condicion;";
    $estructura = "DESC $tabla;";


    $res_consulta = mysql_consulta($consulta);
    $res_estructura = mysql_consulta($estructura);



    $registro = mysqli_fetch_array($res_consulta);


    // echo $estructura;
    // die();


    echo "<table align='' cellPadding='2' cellSpacing='0' width='100%'>";

    if ($accion == 0) {
        echo "<tr><td><font color='grey' size='3'><strong>ESTUDIO EN ESPERA DE REVISIÓN<br></strong></font></td></tr>";
    }

    while ($campo = mysqli_fetch_array($res_estructura)) {
        $ccampo = "c_" . $campo['Field'];
        global $$ccampo;

        if ($$ccampo and $accion != 0 and substr($campo['Type'], 0, 3) != 'set')
            $valor = $$ccampo;
        else {
            if ($registro)
                $valor = $registro[$campo['Field']];
            else
                $valor = $campo['Default'];
            if (substr($campo['Type'], 0, 3) == 'dat' and $valor) {
                $valor = Fecha_Ver($valor);
            }
        }


        //armar_campo($campo['Field'],$campo['Type'],$valor,$accion,$$id_cartilla,$tabla);
        $var1 = $campo['Field'];
        $auxiliar = explode('_SSS_', $var1);
        $var2 = $campo['Type'];

        if ($accion != 0 or $auxiliar[1] or $var2 == 'char(0)') {
            armar_campo($campo['Field'], $campo['Type'], $valor, $accion, $id_cartilla, $tabla, $ac_u);
        } 
        if ($accion == 0) {
            armar_campo($campo['Field'], $campo['Type'], $valor, $accion, $id_cartilla, $tabla, $ac_u);  
        }
    }
    echo "</table>";

    if ($registro) return 0;
    else return 1;
}



function armar_campo($nombre, $tipo, $valordefecto, $accion, $id_cartilla, $tabla, $ac_u)
{

    $auxiliar = explode('_s_', $nombre);
    $parte = explode("__", $nombre); //este es el que me va a separar el string de la unidad del campo
    if (!$parte[0] and !$parte[1])
        return;
    elseif (!$parte[0]) {
        $sololectura = true;
        $parte[0] = $parte[1];
        $parte[1] = $parte[2];
    }
    if ($auxiliar[1]) {
        $parte[0] = $auxiliar[0];
        $tipo = "boton";
    }
    if ($accion == 0) {          //or $accion==2
        $readonly = "DISABLED";
        $disabled = "DISABLED";
    }

    $parte[0] = ucfirst($parte[0]);
    $parte[0] = str_replace("_", " ", $parte[0]);



    $cadena = substr(strrchr($tipo, "("), 1, -1);
    $ntipo = substr($tipo, 0, 3);

    $cadena = str_replace("'", "", $cadena);
    //       echo $cadena;
    $listado = explode(',', $cadena);




    switch ($tipo) {
        case 'time':
            if ($valordefecto == '-838:59:59') $valordefecto = date("H:i");
            $formato = 'hh:mm';
            break;
        case 'datetime':
            if ($valordefecto == '01-01-1000 00:00') $valordefecto = Fecha_Ver(date("Y-m-d H:i"));
            $formato = 'DD/MM/AAAA hh:mm';
            break;
        case 'date':
            if ($valordefecto == '01-01-1000') $valordefecto = Fecha_Ver(date("Y-m-d"));
            $formato = 'DD/MM/AAAA';
            break;
    }


    //Escribe titulos

    ///////campos especiales////
    $cap_hid = explode("_", $nombre);

    if ($cap_hid[1] == 'id' or $cap_hid[0] == 'id' or $nombre == 'id') {

        $ntipo = "hidden";
        //die();
    }

    $nfantasia = '';

    switch ($cap_hid[0]) {
        case 'esp1':
            $ntipo = "esp1";
            $nfantasia = $cap_hid[1] . ' ' . $cap_hid[2];

            break;
        case 'esp2':
            $ntipo = "esp2";
            $nfantasia = $cap_hid[1] . ' ' . $cap_hid[2];
            break;
        case 'esp3':
            $ntipo = "esp3";
            $nfantasia = $cap_hid[1] . ' ' . $cap_hid[2];
            break;
        case 'esp4':
            $ntipo = "esp4";
            $nfantasia = $cap_hid[1] . ' ' . $cap_hid[2];
            break;
    }
    $nfantasia = ucfirst($nfantasia);




    ////////////////////     



    if ($ntipo == 'cha' and $cadena == 0) {
        echo "<tr><td><font color='#000080' size='3'><strong>$nombre<br></strong></font></td></tr>";
    }
    //Particularidad del campo mediumtext
    elseif ($ntipo == 'med') {

        echo "<tr><td><font color='#FF0000' size='3'><strong>$nombre<br></strong></font></td></tr>";
    }
    //Particularidad del campo set
    elseif ($ntipo == 'set') {
        echo "<tr><td align=''><font color='#000000' size='3'><strong>$nombre<br></strong></font></td></tr>";
    }
    //particularidad campos especiales  
    elseif ($ntipo == 'esp2' or $ntipo == 'esp3' or $ntipo == 'esp4') {
        if ($ac_u == 0 and $ntipo == 'esp3') {
        } else {
            echo "<tr><td align=''><font color='#000000' size='3'><strong>$nfantasia<br></strong></font></td></tr>";
        }
    } elseif ($ntipo == 'esp1') {
        echo "<tr><td align=''><strong>$nfantasia</strong></td></tr><br>";
    } elseif ($ntipo == "hidden") {
    }



    //Escribir nombre de campos.
    else {
        echo "<tr><td align='right'><strong>$parte[0]:</strong></td><td align='left'>";
    }




    //Colocar campo como solo lectura.
    if ($sololectura)
        echo "$valordefecto <input $readonly type=hidden name=c_$nombre value='$valordefecto'>";
    else switch ($ntipo) {
        case 'var':
        case 'cha':
            if ($cadena > 0) {
                if ($cadena > 50) $cadena = 50;
                echo "<input $readonly type=text size=$cadena  name=c_$nombre  value='$valordefecto'>";
            }
            break;
        case 'med':
            echo "<tr><td colspan = 2><textarea $readonly rows=7 cols=60 wrap = virtual name=c_$nombre>$valordefecto</textarea></td></tr>";
            break;

        case 'enu':

            echo "<select size='1' name='c_$nombre' $disabled >";
            foreach ($listado as $valor) {
                echo '<option ';
                if ($valordefecto == $valor) {
                    echo 'selected ';
                }
                echo 'value="' . $valor . '">' . $valor . '</option>';
            }
            echo "</select>";
            break;
        case 'int':
        case 'tin':
        case 'sma':
        case 'flo':
        case 'dec':
            echo "<input $readonly type=text size=" . ($cadena + 4) . "  name=c_$nombre  value=$valordefecto>";
            break;
        case 'dat':
        case 'tim':
            echo "<input $readonly type=text size=15  name=c_$nombre  value=$valordefecto>";
            echo "<font size='2'>$formato</font>";
            break;

        case 'set':
            echo "<tr><td colspan = 2>";
            foreach ($listado as $nombre_sel) {
                $valordefecto = ' ' . $valordefecto;
                echo $nombre_sel . '<input type="checkbox" ' . $disabled . ' value="' . $nombre_sel . '" name="c_' . $nombre . '_' . $nombre_sel . '" ';
                if (strpos($valordefecto, $nombre_sel))
                    echo " checked ";
                echo '> ';
            }
            echo "<input type=hidden name=c_$nombre value=1>";
            echo "</td></tr>";
            break;

            //******casos especiales********

        case 'hidden':  //campos que contienen "id"
            if ($nombre == 'id_cartilla') echo "<input type=hidden name=c_$nombre  value='$id_cartilla'>";
            else echo "<input type=hidden name=$nombre  value='$valordefecto'>";

            break;

        case 'esp1':
            if ($ac_u == 1 or $ac_u == 3 or $ac_u == 4 or $ac_u == 5 or $ac_u == 6 or $ac_u == 7) {

                // VISUALIZAR EL ESTUDIO POR REVISOR
                echo "<tr><td colspan = 2>
                    <i>Imagen o PDF del estudio correspondiente:<br />";

                $result = mysql_consulta("SELECT esp1_archivo FROM `$tabla` WHERE id_cartilla=$id_cartilla");
                $fila = mysqli_fetch_assoc($result);
                $nombreArch = $fila['esp1_archivo'];


                if (!empty($nombreArch)) {
                    $link = strstr($nombreArch, 'archivos');
                    echo "<a href=$link target='_blank'>Ver Archivo</a>";


                    // echo"<br>----------nombreArch-----------<br>";
                    // print_r($nombreArch);
                    // echo"<br>----------link-----------<br>";
                    // print_r($link);
                    // echo"<br>---------------------<br>";


                } else {
                    echo "Archivo Vacío";
                }
            } else {
                //CARGA DEL ARCHIVO O MODIFICACION POR ALUMNO

                $result = mysql_consulta("SELECT esp1_archivo FROM `$tabla` WHERE id_cartilla=$id_cartilla");
                $fila = mysqli_fetch_assoc($result);
                $nombreArch = $fila['esp1_archivo'];

                echo "<tr><td colspan = 2> ";

                if (!file_exists($nombreArch)) {

                    echo "<i>Imagen o PDF del estudio correspondiente:<br />
                        <input name='archivo' type='file' accept='application/pdf,image/*' /> ";

                    // echo"<br>----------nombreArch-----------<br>";
                    // print_r($nombreArch);
                    // echo"<br>----------link-----------<br>";



                } else {

                    $link = strstr($nombreArch, 'archivos');
                    echo "<a href=$link target='_blank'>Ver Archivo</a><br />";
                    echo "<i>Modificar archivo cargado <br />
                            <input name='archivo' type='file' accept='application/pdf,image/*' /> ";
                }

                echo "</form>
                        </td></tr>";
            }

            break;

        case 'esp2':
            if ($ac_u == 1 or $ac_u == 3 or $ac_u == 4 or $ac_u == 5 or $ac_u == 6 or $ac_u == 7) { //SOLO VER CAMPO OBSERVACION ESTUDIANTE
                echo "<tr><td colspan = 2><textarea disabled rows=7 cols=60 wrap = virtual name=c_$nombre>$valordefecto</textarea></td></tr>";
            } else {
                echo "<tr><td colspan = 2><textarea  rows=7 cols=60 wrap = virtual name=c_$nombre>$valordefecto</textarea></td></tr>";
            }

            break;

        case 'esp3':
            if ($ac_u == 2 or $ac_u == 3 or $ac_u == 7 or $ac_u == 1) { //SOLO VER CAMPO OBSERVACION REVISOR 
                echo "<tr><td colspan = 2><textarea disabled rows=7 cols=60 wrap = virtual name=c_$nombre>$valordefecto</textarea></td></tr>";
            } else if ($ac_u == 0) { //CAMPO OBS REVISOR OCULTO
                echo "<tr><td colspan = 2><textarea hidden rows=7 cols=60 wrap = virtual name=c_$nombre>$valordefecto</textarea></td></tr>";
            } else {
                echo "<tr><td colspan = 2><textarea  rows=7 cols=60 wrap = virtual name=c_$nombre>$valordefecto</textarea></td></tr>";
            }

            break;
        case 'esp4':
            if ($ac_u == 0 or $ac_u == 1 or $ac_u == 2 or $ac_u == 3 or $ac_u == 7) { //CAMPO ESTADO ESTUDIO DESHABILITADO alumno
                echo "<tr><td colspan = 2><select disabled size='1' name='c_$nombre' $disabled >";
                foreach ($listado as $valor) {
                    echo '<option ';
                    if ($valordefecto == $valor) {
                        echo 'selected ';
                    }
                    echo 'value="' . $valor . '">' . $valor . '</option>';
                }
                echo "</select>";
            } else {                                      //CAMPO ESTADO ESTUDIO HABILITADO PARA EL REVISOR
                echo "<tr><td colspan = 2><select size='1' name='c_$nombre' $disabled >";
                foreach ($listado as $valor) {
                    echo '<option ';
                    if ($valordefecto == $valor) {
                        echo 'selected ';
                    }
                    echo 'value="' . $valor . '">' . $valor . '</option>';
                }
                echo "</select>";
            }
            break;
    }
    echo "<strong>$parte[1]</strong>";
    
}

//FUNCIONES DEL db_controller

function validar($categoria, $usuario, $clave)
{
    $base_datos = "precartilla";
    $sql = "SELECT usuario.* FROM usuario WHERE ( usuario.correo='$usuario' AND usuario.password='$clave' ) AND usuario.estado LIKE 'activado';";
    $resultado = mysql_consulta($sql, $base_datos);
    if (mysqli_num_rows($resultado)) {
        $res = mysqli_fetch_array($resultado);
        $cat_usuario = $res['tipo_usuario'];
        if ("Profesional" == $categoria) {
            if ($cat_usuario == $categoria) {
                return $cat_usuario;
            } else {
                die("Operación no autorizada usted no tiene permiso como revisor");
                return 0;
            }
        } else if ("Alumno" == $categoria) {
            if ($cat_usuario == $categoria) {
                return $cat_usuario;
            } else {
                die("Operación no autorizada usted no tiene permiso como alumno");
                return 0;
            }
        }
    } else {
        die("Operación no autorizada no se encontro alguien con la cuenta activada para estos datos");
        return 0;
    }
}



function insertQuery($query)
{
    $conexion = @mysqli_connect('localhost', 'root', 'mbpp2312', 'precartilla');
    $result = mysqli_query($conexion, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($conexion));
    } else {
        return mysqli_insert_id($conexion);
    }
}

function estado_estudio($estudio, $id_cartilla)
{
    $sql = "SELECT cartillas.id, $estudio.esp4_estado_estudio, cartillas.id_alumno, usuario.id FROM usuario, cartillas, $estudio WHERE (cartillas.id='$id_cartilla' AND cartillas.id_alumno=usuario.id AND $estudio.id_cartilla='$id_cartilla');";
    $result = mysql_consulta($sql);
    $fila = mysqli_fetch_assoc($result);
    return $fila['esp4_estado_estudio'];
}

function estudio($post)
{
    if (isset($post['audiometria'])) {
        $estudio = "est1_audiometria";
    } else if (isset($post['laboratorio'])) {
        $estudio = "est2_laboratorio";
    } else if (isset($post['oftalmologico'])) {
        $estudio = "est3_oftalmologico";
    } else if (isset($post['otorrinolaringologico'])) {
        $estudio = "est4_otorrinolaringologico";
    } else if (isset($post['carnet'])) {
        $estudio = "est5_carnet_de_vacunacion";
    } else if (isset($post['antecedentes'])) {
        $estudio = "est6_antecedentes_patologicos";
    }
    return $estudio;
}


?>

