<?php
	if($_POST['usuario1']){
        $_SESSION['usuario']=$_POST['usuario1'];
    }
	if($_POST['clave1']){
         $_SESSION['clave']=md5($_POST['clave1']);
    }  
    
?>
<html>
    <head>
       <title> Página principal </title>
       <link rel='stylesheet' href='css/estilos.css'>

    </head>
    <body>

<?
    
   

@$diaact=date("j");
@$mesact=date("m");
@$anoact=date("Y");
$fechaact= $anoact."-".$mesact."-".$diaact;
@$fechalim=date("Y-m-d",strtotime($fechaact."- 4 month"));


require_once("db_controller.php");
$_SESSION['tipo_usuario']=validar("Alumno",$_SESSION['usuario'],  $_SESSION['clave']);
$sql="SELECT * FROM usuario WHERE correo='$_SESSION[usuario]' and password='$_SESSION[clave]'";
$result= mysql_consulta($sql);
$fila=mysqli_fetch_assoc($result);
$_SESSION['id_usuario']=$fila['id'];
$apellido=$fila['apellido'];
$nombre=$fila['nombre'];

$sql="select * from cartillas where id_alumno=$_SESSION[id_usuario]";
$result= mysql_consulta($sql);
$numfilas = mysqli_num_rows($result);
while($fila=mysqli_fetch_array($result)){
    $id_cartilla[$i]=$fila['id'];
    $i++;
}


echo "
<div class='form-title'>
<span class='title'>
<br></br>
Bienvenido/a ".$apellido.", ".$nombre."! </span><br></br><br></br>
<a href='salir.php?' class='boton' aling='center'>Cerrar sesión</a>
<a href='actualizacion.php?act=2' class='boton' aling='center'>Cambiar contraseña</a>

<div class='form'>
     <table class='result'>
     <thead>    
         <tr>
         <th colspan=4 alling=center>Cartillas en trámite</th> 
         </tr>
     </thead>    
         <tr>
             <td class='result_t'>Cartilla</td>
             <td class='result_t'>Fecha</td> 
             <td class='result_t'>Estado</td> 
         </tr>
    ";
 

foreach($id_cartilla as $val){
  $sql="select * from estado where id_cartilla=$val ";
  $result=mysql_consulta($sql);
 while($fila=mysqli_fetch_array($result)){
    $estado=$fila['estado'];
    $fecha=$fila['fecha'];
}
 if($fecha > $fechalim){
      
       echo"
        <tr>
            <td class='result_t'>Cartilla de ingreso</td>
            <td class='result_t'>".$fecha."</td>
            <td class='result_t'>".$estado."</td>
       ";  
               
    
    if($estado=="Rechazado" | $estado=="Incompleto") {  
      echo"   
       <td><a href='cartilla1.php?&id_cartilla=$val&estado_cartilla=$estado&act=2' ' class='boton_act'>Ver cartilla</a></td>
      </tr>
      </table>";
    } 
    else if($estado=="Completo" | $estado=="Aprobado") {
        echo"
      <td><a href='cartilla1.php?&id_cartilla=$val&estado_cartilla=$estado&act=0' ' class='boton_act'>Ver cartilla</a></td>
      </tr>
      </table>";
     }
     $cont=0;
    } else{
        $cont=1;
    }
}

    
 if($numfilas==0){
    echo"</table>  
    <br></br>
    <div>
    <a href='nuevacartilla.php?&nv=1&fechaact=$fechaact&act=1' ' class='boton'  aling='center'>Nueva cartilla</a>
    </div>";
 }

if($cont==1){
    echo"</table> 
    <br></br>
    <div>
    <a href='nuevacartilla.php?&nv=1&fechaact=$fechaact&act=1' ' class='boton'  aling='center'>Nueva cartilla</a>
    </div>";
}
     echo"<div class='form'>
     <table class='result'>
     <thead>
         <tr>
         <th colspan=3 alling=center>Turnos</th>
         </tr>
     </thead>    
         <tr>
             <td class='result_t'>Cartilla</td>
             <td class='result_t'>Fecha</td> 
             <td class='result_t'>Hora</td> 
         </tr>
         "; 
     if($numfilas)
      {
       while($fila=mysqli_fetch_array($result)){
        echo"
             <tr>
                 <td class='result'>".$fila['id_cartilla']."</td>
                 <td class='result'>".$fila['fecha']."</td>
                 <td class='result'>".$fila['hora']."</td>
            </tr>
            ";
           }
        }
       
         echo"</table>
         <div>
         <br></br>
        <a href='actualizacion.php?act=1' ' class='boton' align='center'>Modificar Datos Personales</a>
        </div>";

        echo"<div class='form'>
        <table class='result'>
        <thead>
         <tr>
         <th colspan=4 alling=center>Trámites anteriores</th>
         </tr>
         </thead>
         <tr>
             <td class='result_t'>Cartilla</td>
             <td class='result_t'>Fecha</td> 
             <td class='result_t'>Estado</td> 
             <td class='result_t' clospan=3>Acci&oacute;n</td>
         </tr>
         ";

foreach($id_cartilla as $val){
    $sql="select * from estado where id_cartilla=$val ";
    $result=mysql_consulta($sql);
while($fila=mysqli_fetch_array($result)){
    $estado=$fila['estado'];
    $fecha=$fila['fecha'];
}
  if($fecha < $fechalim && $estado!="Aprobado"){  
          
          $sql="UPDATE estado SET estado='Caducado' where id_cartilla=$val" ;
          mysql_consulta($sql,$base_dat);
          $sql="select * from estado where id_cartilla=$val ";
          $result=mysql_consulta($sql,$base_dat);
      while($fila=mysqli_fetch_array($result)){
          $estado=$fila['estado'];
      }  
    }
    if($fecha< $fechalim){
           echo"
           <tr>
             <td class='result'>Cartilla de ingreso</td>
             <td class='result'>".$fecha."</td>
             <td class='result'>".$estado."</td>
             <td class='result'><a href='cartilla1.php?&id_cartilla=$val&act=0' ' class='boton_act'>Ver</a></td>
           </tr>
           ";
  
}
}
 echo"</table>
      </div>
      </body>
      </html>" ;

 ?>
 