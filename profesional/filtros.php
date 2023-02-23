<?php
    require_once('../db_controller.php');

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
        switch($estcart)
                {
                    case 'Completo': $cecomp="checked";
                                    break;
                    case 'Aprobado': $ceapr="checked";
                                    break;
                    case 'Rechazado': $cerec="checked";
                                    break;
                    case 'Todos': $cetod="checked";
                                    break;
                    case 'Caducado': $cecad="checked";
                                    break;

                }
        echo" 
        <div class='boton-sec'>
            <a href='../salir.php?' class='boton'>Cerrar sesión</a>
        </div>
        <br></br><br></br><br></br>
        <div class='form-title'>
            <span class='title'>Busqueda Personalizada</span><br></br>
            <a href='princrevisor.php' class='boton'>Volver</a>
        </div";
        echo "<div class='form'>";
        echo "<table class='form' >
        <tr>
            <th colspan='2' id_cartilla='result'><span>Filtros de busqueda</span></th>
        </tr>
        <tr>
            <th id_cartilla='result'>Estados Pre-cartilla</th>
            <th id_cartilla='result'>Datos Personales</th>
        </tr>
        <tr>
            <form action='filtros.php' method='POST'>
            <td id_cartilla='result'><label class='filtro'><input type='radio' id='cbox1' value='Completo' name='estcart' $cecomp>Completo</label></td>
            <td id_cartilla='result'><label class='filtro'>Apellido:</label></td>
        </tr>
        <tr>
            <td id_cartilla='result'><label class='filtro'><input type='radio' id='cobx2' value='Aprobado' name='estcart' $ceapr>Aprobado</label></td>
            <td id_cartilla='result'><input type='text'  value='$fapellido' name='fapellido'></td>
        </tr>
        <tr>
            <td id_cartilla='result'><label class='filtro'><input type='radio' id='cobx3' value='Rechazado' name='estcart' $cerec>Rechazado</label></td>
            <td id_cartilla='result'><label class='filtro'>DNI:</label></td>
        </tr>
        <tr>
            <td id_cartilla='result'><label class='filtro'><input type='radio' id='cobx5' value='Caducado' name='estcart' $cecad>Caducado</label></td>
            <td id_cartilla='result'><input type='number' value='$fdni' name='fdni'></td>
        </tr>
        <tr>
            <td id_cartilla='result' colspan='2'><label class='filtro'><input type='radio' id='cobx6' value='%' name='estcart' $cetod>Todos</label></td>
        </tr>
        <tr>
            <td id_cartilla='result' colspan='2'><input type='submit' value='Filtrar' name='boton'></td>
        </tr>
        </div>
        </table>
        ";
        if($estcart)
        {
            $condpart=" AND estado.estado LIKE '$estcart'";
        }
        if($fapellido)
        {
            $condpart.=" AND usuario.apellido LIKE '%$fapellido%'";
        }
        if($fdni){
            $condpart.="AND usuario.dni='$fdni'";
        }
        echo "<div class='form'>";
        echo "<table class='form'>
        <tr>
            <th colspan='6' id_cartilla='result'><span>Resultados de Busqueda</span></th>
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
        WHERE (cartillas.id_alumno=usuario.id AND cartillas.id=estado.id_cartilla)  $condpart 
        ORDER BY FIELD (estado.estado,'Completo','Aprobado','Rechazado','Caducado'), estado.fecha 
        ASC, usuario.apellido, usuario.nombre, usuario.dni;";
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