<?php
    require_once('db_controller.php');
    function meta($tipo_usuario)
    {
        if($tipo_usuario=="Profesional")
        {
            echo "
                <html>
                    <head>
                        <meta http-equiv=refresh content='0;URL=profesional/princrevisor.php'>
                    </head>
                    <body></body>
                </html>
            ";
        }
        if($tipo_usuario=="Alumno")
        {
            echo "
            <html>
                <head>
                    <meta http-equiv=refresh content='0;URL=princalumno.php'>
                </head>
                <body></body>
            </html>
        ";
        }


    }
    if($_GET['act'])$act=$_GET['act'];
    if($_POST)
    {
        foreach($_POST as $key => $val)
        {
            $$key=$val;
        }
    }
    $id=$_SESSION['id_usuario'];
    switch($boton)
    {
        case 'Cancelar': meta($_SESSION['tipo_usuario']);
                         die();
        case 'Grabar': 
                        if($act==1)
                        {
                            if(!$domicilio) $mens.="Falta Domicilio<br>";
                            if(!$telefono) $mens.="Falta Telefono<br>";
                            if(!$mens)
                            {
                                @$sql="UPDATE usuario SET nombre='$nombre', apellido='$apellido', dni='$dni', fecha_nacimiento='$fecha_nacimiento',
                                sexo='$sexo', domicilio='$domicilio', telefono='$telefono', correo='$correo' WHERE id='$id';";
                                mysql_consulta($sql);
                                meta($_SESSION['tipo_usuario']);
                                die();
                            }
                        }
                        if($act==2)
                        {
                            if(!$_POST['pass_act']) $mens="No ingreso ninguna contraseña<br>";
                            if(md5($_POST['pass_act'])!=$_SESSION['clave']) $mens.="La contraseña actual es erronea";
                            if($_POST['pass_new1']!=$_POST['pass_new2']) $mens.="Las contraseñas nuevas no coinciden";
                            if(!$mens)
                            {
                                $new=md5($_POST['pass_new1']);
                                @$sql="UPDATE usuario SET password='$new' WHERE id='$id';";
                                mysql_consulta($sql);
                                meta($_SESSION['tipo_usuario']);
                                die();
                            }
                        }
    }
    echo"
        <html>
            <head>
                <title>Área personal</title>
                <link rel='stylesheet' href='css/estilos.css'>
            </head>
            <body>
                <form action='actualizacion.php' method='POST'>
                <div>
                <label class='form-error'>".$mens."</label>
    ";
    if($act==1)
    {
        $sql="SELECT * FROM usuario WHERE id='$id';";
        $result=mysql_consulta($sql);
        $numfilas = mysqli_num_rows ($result);
        while($fila=mysqli_fetch_array ($result))
        {
            $nombre=$fila['nombre'];
            $apellido=$fila['apellido'];
            $dni=$fila['dni'];
            $sexo=$fila['sexo'];
            $fecha_nacimiento=$fila['fecha_nacimiento'];
            $domicilio=$fila['domicilio'];
            $telefono=$fila['telefono'];
            $correo=$fila['correo'];
        }
        echo"
        <br></br>
        <table>
            <tr><th colspan=2 id='result'>Actualización de datos personales</td></tr>
            <tr><td id='result_t'>Nombre/s</td><td id='result_t'>".$nombre."</td></tr>
            <tr><td id='result_t'>Apellido/s</td><td id='result_t'>".$apellido."</td></tr>
            <tr><td id='result_t'>DNI</td><td id='result_t'>".$dni."</td></tr>
            <tr><td id='result_t'>Fecha de Nacimiento</td><td id='result_t'>".$fecha_nacimiento."</td></tr>
            <tr><td id='result_t'>Sexo</td><td id='result_t'>".$sexo."</td></tr>
            <tr><td id='result_t'>Domicilio</td><td id='result_t'><input type='text' name='domicilio' value='$domicilio' class='form-input'></td></tr>
            <tr><td id='result_t'>Telefono</td><td id='result_t'><input type='number' name='telefono' value='$telefono' class='form-input'></td></tr>
            <tr><td id='result_t'>Correo Electrónico</td><td id='result_t'>".$correo."</td></tr>
        </table>
    ";

    }
    if($act==2)
    {
?>
        <br></br><br></br>
        <table>
        <tr>
            <th colspan=2>Cambio de contraseña</th>
        </tr>
        <tr>
            <td>Ingrese la contraseña actual</td>
            <td><input type="password" class="demoInputBox" name="pass_act" value=""></td>
        </tr>
        <tr>
            <td>Ingrese la nueva contraseña</td>
            <td><input type="password" class="demoInputBox" name="pass_new1" value=""></td>
        </tr>
        <tr>
            <td>Repita la nueva contraseña</td>
            <td><input type="password" class="demoInputBox" name="pass_new2" value=""></td>
        </tr>
<?php
    }

    echo"
        <table class='form-table'>
            <tr><td id='result_t'>
            <input type='submit' name='boton' class='form-submit' value='Grabar'>
            </td>
            <td id='result_t'>
            <input type='submit' name='boton' class='form-submit' value='Cancelar'>
            </td>
            </tr>
        </table>
    ";
    echo"
        <input type=hidden name=act value=$act>
        </div>
        </body>
        </html>
    ";
?>