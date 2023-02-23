<?
function meta(){
    echo"<html>
            <head>
                <meta http-equiv=refresh content='0;URL=princalumno.php'>
            </head>
            <body></body>
            </html>";
    }
?>
    <html>
    <head>
       <title> Cartilla </title>
       <link rel='stylesheet' href='css/estilos.css'>

    </head>
<?
$act=$_GET['act'];
$id_cartilla=$_GET['id_cartilla'];
$estado_cartilla=$_GET['estado_cartilla'];
if($_POST)
    {
        foreach($_POST as $key => $val)
            {
                $$key=$val;
            }
    }


    @$diaact=date("j");
    @$mesact=date("m");
    @$anoact=date("Y");
    $fechaact= $anoact."-".$mesact."-".$diaact;

require_once("db_controller.php");
$_SESSION['tipo_usuario']=validar("Alumno",$_SESSION['usuario'],  $_SESSION['clave']);



$sql="select * from usuario where id='$_SESSION[id_usuario]'";
$rp=mysql_consulta($sql);
             while($fila=mysqli_fetch_assoc($rp)){
                $nombre=$fila['nombre'];
                $apellido=$fila['apellido'];
             }  
            
             
echo"
<body>
 <form action='estudio.php' method='POST'>
             <a href='salir.php?' class='boton' aling='center'>Cerrar sesión</a>
             <div class='form-title'>
             <span class='title'>
             <br></br>
             Bienvenido/a ".$apellido.", ".$nombre."! </span><br></br><br></br>


  <div class='form'>
      <table class='result'>
      <thead>
         <tr>
             <th>Estudios</th><th></th>
         </tr>
      </thead>   
         <tr>
             <td class='result_t'>Estudios</td>
             <td class='result_t'>Estado</td> 
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
        <input name=id_cartilla type=hidden value=$id_cartilla>
        </form>
 ";

         if($boton=="Enviar"){
           if((estado_estudio('est1_audiometria', $id_cartilla)=='Completo' || estado_estudio('est1_audiometria', $id_cartilla)=='Aprobado') && (estado_estudio('est2_laboratorio', $id_cartilla)=='Completo' || estado_estudio('est2_laboratorio', $id_cartilla)=='Aprobado') && (estado_estudio('est3_oftalmologico', $id_cartilla)=='Completo' || estado_estudio('est3_oftalmologico', $id_cartilla)=='Aprobado') && (estado_estudio('est4_otorrinolaringologico', $id_cartilla)=='Completo' || estado_estudio('est4_otorrinolaringologico', $id_cartilla)=='Aprobado') && (estado_estudio('est5_carnet_de_vacunacion', $id_cartilla)=='Completo' || estado_estudio('est5_carnet_de_vacunacion', $id_cartilla)=='Aprobado') && (estado_estudio('est6_antecedentes_patologicos', $id_cartilla)=='Completo' || estado_estudio('est6_antecedentes_patologicos', $id_cartilla)=='Aprobado')) {
            @$sql="UPDATE estado SET usuario_resp='Alumno', fecha='$fechaact', estado='Completo' WHERE id_cartilla='$id_cartilla';";
               mysql_consulta($sql);
               meta();
               die();
           } else{
            echo "
               <table>
               <center><p> <strong><font align: 'center' family: 'Times New Roman' color='red' size='3.5'>
               Error al enviar la cartilla! Revise que todos los estudios estén completos.
               </font></strong></p></center> 
               </table>";     
           }
          }

   
     @$sql="SELECT * FROM estado WHERE id_cartilla='$id_cartilla'";
     $rp=mysql_consulta($sql);
     while($fila=mysqli_fetch_assoc($rp)){
      $estado=$fila['estado'];
     }
     echo"<form action='cartilla1.php' method='POST'>";

    if($estado!="Aprobado" && $estado!="Caducado" && $estado!="Completo"){
      echo "
      <table>
      <center><p> <strong><font align: 'center' family: 'Times New Roman' color='grey' size='3.5'>
      Carga de cartilla completa:<br> Al enviar, el formulario quedará deshabilitado para posteriores modificaciones
     </font></strong></p></center> 
     <td>     
        <input type='submit' name='boton' class='form_boton' value='Enviar'>
      </td>
      </table>
     ";
    }       
   echo"
    <br></br>
    <a href='princalumno.php?' ' class='boton'>Volver a la página principal</a>
    ";  
  

echo "
<input name=act type=hidden value=$act>   
<input name=id_cartilla type=hidden value=$id_cartilla>
<input name=estado type=hidden value=$estado>
</form>
</div>
</body>
</html>
";
