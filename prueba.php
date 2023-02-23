<?php
require_once('db_controller.php');
$estudio = estudio($_POST);
$id_cartilla = $_POST['id_cartilla'];
$act=$_POST['act'];

echo" estudio :$estudio <br></br> id_cartilla :$id_cartilla<br></br> act:$act<br></br>";

?>
