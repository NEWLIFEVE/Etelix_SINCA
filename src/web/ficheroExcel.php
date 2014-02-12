<?php
$nombre = $_GET['nombre'];

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$nombre.xls");
header("Pragma: cache");
header("Expires: 0");

echo $_POST['data'];
?>
