<?php
$nombre = $_GET['nombre'];
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=$nombre.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $_POST['datos_a_enviar'];
?>
