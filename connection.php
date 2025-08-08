<?php
$host = "localhost"; /* Host name */
$user = "root"; /* Usuario */
$password = ""; /* Contraseña */
$dbname = "movie_ticket_booking_system"; /* Nombre de la base de datos */

$con = mysqli_connect($host, $user, $password, $dbname);

// Revisar la conexiòn
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
