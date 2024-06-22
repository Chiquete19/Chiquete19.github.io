<?php

include('conexion.php');

$folio = $conexion -> real_escape_string($_POST['folio']);

$sql = "SELECT * FROM viajes_lanzados WHERE folio = $folio";
$resultado = $conexion->query($sql);

if ($resultado) {
    $datos = $resultado->fetch_assoc();
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(['error' => 'No se pudo ejecutar la consulta.']);
}