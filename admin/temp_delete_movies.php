<?php
include "config.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
    exit;
}

// Truncar la tabla de películas
$sql = "TRUNCATE TABLE movieTable";
if (mysqli_query($con, $sql)) {
    echo "Todas las películas han sido eliminadas exitosamente.";
    // Redirigir de vuelta a la página de películas después de un momento
    header("refresh:2;url=addmovie.php");
} else {
    echo "Error al eliminar las películas: " . mysqli_error($con);
}

mysqli_close($con);
?>
