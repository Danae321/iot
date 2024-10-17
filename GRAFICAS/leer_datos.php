<?php
function datos()
{
    $servidor = "127.0.0.1";
    $usuario = "root";
    $clave = "";
    $basedatos = "inf640_2024";
    $tabla = "datos";

    $conexion = mysqli_connect($servidor, $usuario, $clave);
    mysqli_select_db($conexion, $basedatos);
    mysqli_query($conexion, "SET NAMES 'utf8'");

    $resultado = mysqli_query($conexion, "SELECT UNIX_TIMESTAMP(fecha), humedad FROM " . $tabla);

    while ($row = mysqli_fetch_array($resultado)) {
        echo "[";
        echo ($row[0] * 1000);
        echo ",";
        echo $row[1];
        echo "],";
    }
}
