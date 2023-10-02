<?php
// Datos de conexión a la base de datos
$host = "127.0.0.1";
$usuario = "root";
$contraseña = "";
$base_de_datos = "clientes";

// Establecer conexión a la base de datos
$conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $documento = $_POST["documento"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];

    // Preparar una consulta para insertar los datos en la tabla
    $consulta = "INSERT INTO usuario (documento, nombre, correo) VALUES (?, ?, ?)";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    // Vincular parámetros
    if ($stmt->bind_param("sss", $documento, $nombre, $correo) === false) {
        die("Error al vincular parámetros: " . $stmt->error);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Hola $nombre, tu correo $correo ha sido registrado en la base de datos.";
    } else {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }

    // Cerrar la conexión y la declaración
    $stmt->close();
    $conexion->close();
} else {
    echo "Acceso denegado.";
}
?>


