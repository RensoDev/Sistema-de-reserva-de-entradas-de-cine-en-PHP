<?php
include "connection.php";
session_start();

// variables
$fname = $_POST['fName'];
$lname = $_POST['lName'];
$email = $_POST['email'];
$mobile = $_POST['pNumber'];
$theatre = $_POST['theatre'];
$type = $_POST['type'];
$date = $_POST['date'];
$time = $_POST['hour'];
$movieid = $_POST['movie_id'];
$seats = $_POST['selected_seats'];
$order = "ARVR" . rand(10000, 99999999);
$cust  = "CUST" . rand(1000, 999999);

// Determine amount based on theatre
if ($theatre == "main-hall") {
    $ta = 200;
} elseif ($theatre == "vip-hall") {
    $ta = 500;
} elseif ($theatre == "private-hall") {
    $ta = 900;
} else {
    $ta = 0; // Default or error case
}

// Fetch movie title for the receipt
$movieQuery = "SELECT movieTitle FROM movieTable WHERE movieID = $movieid";
$movieResult = mysqli_query($con, $movieQuery);
$movieRow = mysqli_fetch_array($movieResult);
$movieTitle = $movieRow['movieTitle'];

//conditions
if ((!$_POST['submit'])) {
    echo "<script>alert('You are Not Suppose to come Here Directly');window.location.href='index.php';</script>";
    exit; // Ensure script stops here
}

if (isset($_POST['submit'])) {
    // Insert booking with 'Paid' status and actual amount
    $qry = "INSERT INTO bookingtable(`movieID`, `bookingTheatre`, `bookingType`, `bookingDate`, `bookingTime`, `bookingFName`, `bookingLName`, `bookingPNumber`, `bookingEmail`, `bookingSeat`, `amount`, `ORDERID`)
            VALUES ('$movieid','$theatre','$type','$date','$time','$fname','$lname','$mobile','$email', '$seats', '$ta', '$order')";

    if (mysqli_query($con, $qry)) {
        // Redirect to a success page with booking details
        $redirect_url = "payment_success.php?" . http_build_query([
            'order_id' => $order,
            'movie_title' => urlencode($movieTitle),
            'seats' => $seats,
            'amount' => $ta,
            'name' => urlencode($fname . " " . $lname),
            'email' => $email,
            'mobile' => $mobile,
            'theatre' => $theatre,
            'type' => $type,
            'date' => $date,
            'time' => $time
        ]);
        header("Location: " . $redirect_url);
        exit; // Ensure script stops after redirect
    } else {
        // Handle insertion error
        echo "<script>alert('Error saving booking: " . mysqli_error($con) . "');window.location.href='booking.php?id=" . $movieid . "';</script>";
        exit;
    }
}
?>
