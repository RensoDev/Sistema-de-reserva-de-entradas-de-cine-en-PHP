<?php
include "connection.php";

$date = $_GET['date'] ?? null;

if (!$date) {
    // Si no se proporciona fecha, obtener la primera fecha disponible
    $first_date_query = "SELECT MIN(showtimeDate) as first_date FROM showtimes";
    $date_result = mysqli_query($con, $first_date_query);
    $date_row = mysqli_fetch_assoc($date_result);
    $date = $date_row['first_date'];
}

$schedule_query = "
    SELECT 
        m.movieID,
        m.movieTitle,
        m.movieImg,
        m.movieDuration,
        m.movieActors,
        m.movieDirector,
        GROUP_CONCAT(CONCAT(s.showtimeTime, '|', s.hall, '|', s.price, '|', s.showtimeID) SEPARATOR ';') as showtimes
    FROM showtimes s
    JOIN movieTable m ON s.movieID = m.movieID
    WHERE s.showtimeDate = ?
    GROUP BY m.movieID
    ORDER BY m.movieTitle
";

$stmt = $con->prepare($schedule_query);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$movies = [];
while ($row = $result->fetch_assoc()) {
    $movies[] = $row;
}

echo json_encode($movies);
?>
