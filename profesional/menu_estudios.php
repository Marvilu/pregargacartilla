<?php
    require_once('../db_controller.php');

    $id_cartilla=$_GET['id_cartilla'];
    if($_POST)
    {
        foreach($_POST as $key => $val)
        {
            $$key=$val;
        }
    }
    function meta()
    {
        echo "
            <html>
                <head>
                    <meta http-equiv=refresh content='0;URL=princrevisor.php'>
                </head>
                <body></body>
            </html>
        ";
    }
    function meta1()
    {
        echo "
            <html>
                <head>
                    <meta http-equiv=refresh content='0;URL=menu_estudios.php'>
                </head>
                <body></body>
            </html>
        ";
    }
    /*
    switch($boton)
    {
        case 'Audiometría':
            $estudio="est1_audiometria";
            meta1();
            die();
        break;
        
    }*/
    $sql="SELECT usuario.apellido, usuario.nombre, usuario.dni, cartillas.id, estado.estado FROM usuario, cartillas, estado
    WHERE (cartillas.id='$id_cartilla' AND cartillas.id_alumno=usuario.id AND cartillas.id=estado.id_cartilla);";
    $result = mysql_consulta($sql);
    $fila=mysqli_fetch_assoc($result);
    echo"
    <html>
        <head>
            <title>Estudios</title>
            <link rel='stylesheet' href='../css/estilos.css'>
        </head>
        <body>
            <form action='../estudio.php' method='POST'>
            <div class='boton-sec'>
                <a href='../salir.php?' class='boton'>Cerrar sesión</a>
            </div>
        <div class='form'>   
        <br></br><br></br>    
        <table colspan ='2'>
        <tr>
            <th colspan='2' id_cartilla='result'>Estudios del alumno ".$fila['apellido'].", ".$fila['nombre']." con DNI: ".$fila['dni']." </th>
        </tr>
        <tr>
            <th>Tipo de Estudio</th>
            <th>Estado del Estudio</th>
        </tr>
        <tr>
            <td><input type='submit' name='audiometria' class='form-estudio' value='Audiometría'></td>
            <td id_cartilla='result'>".estado_estudio ('est1_audiometria', $id_cartilla)."</td>
        </tr>
        <tr>
            <td><input type='submit' name='laboratorio' class='form-estudio' value='Laboratorio'></td>
            <td id_cartilla='result'>".estado_estudio ('est2_laboratorio', $id_cartilla)."</td>
        </tr>
        <tr>
            <td><input type='submit' name='oftalmologico' class='form-estudio' value='Oftalmológico'></td>
            <td id_cartilla='result'>".estado_estudio ('est3_oftalmologico', $id_cartilla)."</td>
        </tr>
        <tr>
            <td><input type='submit' name='otorrinolaringologico' class='form-estudio' value='Otorrinolaringológico'></td>
            <td id_cartilla='result'>".estado_estudio ('est4_otorrinolaringologico', $id_cartilla)."</td>
        </tr>
        <tr>
            <td><input type='submit' name='carnet' class='form-estudio' value='Carnet de vacunación'></td>
            <td id_cartilla='result'>".estado_estudio ('est5_carnet_de_vacunacion', $id_cartilla)."</td>
        </tr>
        <tr>
            <td><input type='submit' name='antecedentes' class='form-estudio' value='Antecedentes patológicos'></td>
            <td id_cartilla='result'>".estado_estudio ('est6_antecedentes_patologicos', $id_cartilla)."</td>
        </tr>
        </table>
        <input type='hidden' name='id_cartilla' value='$id_cartilla'>
        </form>
    ";

    if($fila['estado']=='Completo')
    {
        switch($estado)
        {
            case 'Aprobado': $ba='selected';
                                break;
            case 'Rechazado': $br='selected';
                                break;
        }
        @$diaact=date("j");
        @$mesact=date("m");
        @$anoact=date("Y");
        $fechaact= $anoact."-".$mesact."-".$diaact;
        if($boton=="Grabar")
        {
            @$sql="UPDATE estado SET usuario_resp='Profesional', fecha='$fechaact', estado='$estado' WHERE id_cartilla='$id_cartilla';";
            mysql_consulta($sql);
            meta();
            die();
        }
        echo "
            
            <div class='form'>
            <form action='menu_estudios.php' method='POST'>
                    <table colspan='2'>
                        <tr>
                            <th colspan='2'>Actualización del Estado General de la Precartilla</th>
                        </tr>
                        <tr>
                            <td>Seleccionar el estado que va a tener</td>
                            <td><select name='estado' class='form-input'>
                            <option value='Aprobado' $ba>Aprobado</option>
                            <option value='Rechazado' $br>Rechazado</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td colspan='2'><input type='submit' name='boton' class='form-submit' value='Grabar'></td>
                        </tr>
                    </table>
            </div>
        ";
    }
    echo"
        <br></br>
        <div class='form-title'>
            <a href='princrevisor.php' class='boton'> Volver</a>
        </div>
    ";
echo"
    <input type='hidden' name='act' value='$act'>
    <input type='hidden' name='id_cartilla' value='$id_cartilla'>
    </div>
    </form>
";
echo"
    </body>
    </html>
";

?>