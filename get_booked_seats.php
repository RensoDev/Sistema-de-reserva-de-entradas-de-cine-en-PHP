<?php
include "connection.php";

if (isset($_GET['movieId']) && isset($_GET['date']) && isset($_GET['time'])) {
    $movieId = $_GET['movieId'];
    $date = $_GET['date'];
    $time = $_GET['time'];

    $query = "SELECT bookingSeat FROM bookingtable WHERE movieID = ? AND bookingDate = ? AND bookingTime = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iss", $movieId, $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookedSeats = [];
    while ($row = $result->fetch_assoc()) {
        $seats = explode(",", $row['bookingSeat']);
        $bookedSeats = array_merge($bookedSeats, $seats);
    }

    echo json_encode($bookedSeats);
}
?>
