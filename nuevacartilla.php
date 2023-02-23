<?
function meta($boton,$act,$id_cartilla)
{
    if($boton=="Cancelar")
    {
        echo"
        <html>
            <head>
                <meta http-equiv=refresh content='0;URL=princalumno.php'>
            </head>
            <body></body>
        </html>
        ";
    }
    elseif($boton=="Grabar")
    {
        echo "
            <html>
                <head>
                    <meta http-equiv=refresh content='0;URL=cartilla1.php?act=".$act."&id_cartilla=".$id_cartilla."'>
                </head>
                <body></body>
            </html>
        ";
    }
}

    
$act=$_GET['act'];
$nv=$_GET['nv'];
$fechaact=$_GET['fechaact'];
if($_POST)
    {
        foreach($_POST as $key => $val)
            {
                $$key=$val;
            }
    }


require_once("db_controller.php");
$_SESSION['tipo_usuario']=validar("Alumno",$_SESSION['usuario'],  $_SESSION['clave']);


$sql="select * from usuario where id=$_SESSION[id_usuario]";
$rp=mysql_consulta($sql);
             while($fila=mysqli_fetch_assoc($rp)){
                $nombre=$fila['nombre'];
                $apellido=$fila['apellido'];
                $id_usuario=$fila['id'];
             }  


    if($boton=='Grabar'){  
    $sql="UPDATE cartillas SET unidad_academica='$unidad_academica' where id='$id_cartilla'";
    mysql_consulta($sql);
    $nv=1;
    $sql="INSERT into estado set id_cartilla='$id_cartilla', usuario_resp='Alumno', fecha='$fechaact', estado='Incompleto'";
    mysql_consulta($sql);
    //meta1($id_cartilla);
    meta($boton,$act,$id_cartilla);
    die();
    }
   if($boton=='Cancelar'){
       $sql="DELETE FROM cartillas WHERE id='$id_cartilla'";
       $re=mysql_consulta($sql);
       $nv=0;
       meta($boton,$act,$id_cartilla);
       die();
   }

   echo"
   <html>
        <head>
             <title>Nueva Cartilla</title>
             <link rel='stylesheet' href='css/estilos.css'>
        </head>
        <body>
            <form action='nuevacartilla.php' method='POST'>
            <div class='form'>

           <a href='salir.php?' class='boton' aling='center'>Cerrar sesión</a>
           <div class='form-title'>
           <span class='title'>
           <br></br>
           Bienvenido/a ".$apellido.", ".$nombre."! </span><br></br><br></br>
            <table>
              <thead>
                 <tr><th>Nueva Cartilla</th><th></th></tr>
              </thead>   ";

                 if($nv==1){
                    $sql="insert into cartillas set id_alumno='$id_usuario'";
                    $re=mysql_consulta($sql);
                    $sql="select * from cartillas where id_alumno=$_SESSION[id_usuario]";
                    $result=mysql_consulta($sql);
                    while($fila=mysqli_fetch_array($result)){
                       $id_cartilla=$fila['id'];
                     }

                  $sql="select * from cartillas where id=$id_cartilla";
                  $result=mysql_consulta($sql);
                 while($fila=mysqli_fetch_array($result)){
                    $unidad_academica=$fila['unidad_academica'];
                }
                
                switch($unidad_academica){
                    case 'Facultad de Ingenieria': $bfi='selected';
                                     break;
                    case 'Facultad de Ciencias Exactas, Fisicas y Naturales': $bfe='selected';
                                     break;
                    case 'Facultad de Filosofia, Humanidades y Arte': $bff='selected';
                                  break;   
                    case 'Facultad de Ciencias Sociales': $bfs='selected';
                                  break;
                    case 'Facultad de Arquitectura, Urbanismo y Diseño': $bfa='selected';
                                  break;
                    case 'Colegio Central': $bcc='selected';
                               break;            
                    case 'Escuela Industrial': $bei='selected';
                               break;
                    case 'Escuela de Comercio': $bec='selected';
                               break;                          
                 }

                 }
                echo" 
                <tr><td id='result'>Seleccione su Unidad Académica</td>
                <td id='result'><select  name='unidad_academica'  class='form-input'>
                     <option $bfi>Facultad de Ingenieria</option>
                     <option $bfe>Facultad de Ciencias Exactas, Fisicas y Naturales</option>
                     <option $bff>Facultad de Filosofia, Humanidades y Arte</option>
                     <option $bfs>Facultad de Ciencias Sociales</option>
                     <option $bfa>Facultad de Arquitectura, Urbanismo y Diseño</option>
                     <option $bcc>Colegio Central</option>
                     <option $bei>Escuela Industrial</option>
                     <option $bec>Escuela de Comercio</option>
                    </select></td></tr>
                  ";

                  
                 echo"

                  <tr><td colspan=2 id='result'>
                  <input type=submit name=boton class='form-submit' value='Grabar'>
                  </td>
                  </tr>
                  <tr><td colspan=2 id='result'>
                  <input type=submit name=boton class='form-submit' value='Cancelar'>
                  </td>
                  </tr>
                  ";
      echo"</table>
     <input name=act type=hidden value=$act>    
     <input name=nv type=hidden value=$nv>
     <input name=id_cartilla type=hidden value=$id_cartilla>
     <input name=fechaact type=hidden value=$fechaact>
     </form>
     </div>
     </body>
     </html>
      ";

?>