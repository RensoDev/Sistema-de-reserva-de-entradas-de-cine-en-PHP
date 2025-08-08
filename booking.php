<!DOCTYPE html>
<html lang="en">
<?php
$id = $_GET['id'];
//conditions
if ((!$_GET['id'])) {
    echo "<script>alert('You are Not Suppose to come Here Directly');window.location.href='index.php';</script>";
}
include "connection.php";
$movieQuery = "SELECT * FROM movieTable WHERE movieID = $id";
$movieImageById = mysqli_query($con, $movieQuery);
$row = mysqli_fetch_array($movieImageById);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>Book <?php echo $row['movieTitle']; ?> Now</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <script src="_.js "></script>
</head>

<body style="background-color:#6e5a11;">
    <div class="booking-panel">
        <div class="booking-panel-section booking-panel-section1">
            <h1>RESERVE YOUR TICKET</h1>
        </div>
        <div class="booking-panel-section booking-panel-section2" onclick="window.history.go(-1); return false;">
            <i class="fas fa-2x fa-times"></i>
        </div>
        <div class="booking-panel-section booking-panel-section3">
            <div class="movie-box">
                <?php
                echo '<img src="' . $row['movieImg'] . '" alt="">';
                ?>
            </div>
        </div>
        <div class="booking-panel-section booking-panel-section4">
            <div class="title"><?php echo $row['movieTitle']; ?></div>
            <div class="movie-information">
                <table>
                    <tr>
                        <td>GENGRE</td>
                        <td><?php echo $row['movieGenre']; ?></td>
                    </tr>
                    <tr>
                        <td>DURATION</td>
                        <td><?php echo $row['movieDuration']; ?></td>
                    </tr>
                    <tr>
                        <td>RELEASE DATE</td>
                        <td><?php echo $row['movieRelDate']; ?></td>
                    </tr>
                    <tr>
                        <td>DIRECTOR</td>
                        <td><?php echo $row['movieDirector']; ?></td>
                    </tr>
                    <tr>
                        <td>ACTORS</td>
                        <td><?php echo $row['movieActors']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="booking-form-container">
                <div id="seat-map-container">
                    <h3>Selecciona tus asientos</h3>
                    <div id="seat-map"></div>
                    <div class="seat-legend">
                        <div><span class="seat-example available"></span> Disponible</div>
                        <div><span class="seat-example occupied"></span> Ocupado</div>
                        <div><span class="seat-example selected"></span> Seleccionado</div>
                    </div>
                </div>
                <form action="verify.php" method="POST">
                    <input type="hidden" name="selected_seats" id="selected-seats" value="">
                    <select name="theatre" required>
                        <option value="" disabled selected>THEATRE</option>
                        <option value="main-hall">Main Hall</option>
                        <option value="vip-hall">VIP Hall</option>
                        <option value="private-hall">Private Hall</option>
                    </select>

                    <select name="type" required>
                        <option value="" disabled selected>TYPE</option>
                        <option value="3d">3D</option>
                        <option value="2d">2D</option>
                        <option value="imax">IMAX</option>
                        <option value="7d">7D</option>
                    </select>

                    <select name="date" required>
                        <option value="" disabled selected>DATE</option>
                        <option value="12-3">March 12,2019</option>
                        <option value="13-3">March 13,2019</option>
                        <option value="14-3">March 14,2019</option>
                        <option value="15-3">March 15,2019</option>
                        <option value="16-3">March 16,2019</option>
                    </select>

                    <select name="hour" required>
                        <option value="" disabled selected>TIME</option>
                        <option value="09-00">09:00 AM</option>
                        <option value="12-00">12:00 AM</option>
                        <option value="15-00">03:00 PM</option>
                        <option value="18-00">06:00 PM</option>
                        <option value="21-00">09:00 PM</option>
                        <option value="24-00">12:00 PM</option>
                    </select>

                    <input placeholder="First Name" type="text" name="fName" required>

                    <input placeholder="Last Name" type="text" name="lName">

                    <input placeholder="Phone Number" type="text" name="pNumber" required>
                    <input placeholder="email" type="email" name="email" required>
                    <input type="hidden" name="movie_id" value="<?php echo $id; ?>">



                    <button type="submit" value="save" name="submit" class="form-btn">Book a seat</button>

                </form>
            </div>
        </div>
    </div>

    <script src="scripts/jquery-3.3.1.min.js "></script>
    <script src="scripts/script.js "></script>
    <script>
        $(document).ready(function() {
            const seatMap = document.getElementById('seat-map');
            const selectedSeatsInput = document.getElementById('selected-seats');
            let selectedSeats = [];

            function generateSeatMap() {
                let seats = '';
                for (let i = 0; i < 5; i++) {
                    for (let j = 0; j < 10; j++) {
                        const seatId = String.fromCharCode(65 + i) + (j + 1);
                        seats += `<div class="seat" data-seat-id="${seatId}">${seatId}</div>`;
                    }
                }
                seatMap.innerHTML = seats;
            }

            function updateSelectedSeats() {
                selectedSeatsInput.value = selectedSeats.join(',');
                $('.seat.selected').removeClass('selected');
                selectedSeats.forEach(seatId => {
                    $(`[data-seat-id=${seatId}]`).addClass('selected');
                });
            }

            function fetchBookedSeats() {
                const movieId = <?php echo $id; ?>;
                const date = $('select[name="date"]').val();
                const time = $('select[name="hour"]').val();

                if (movieId && date && time) {
                    $.ajax({
                        url: 'get_booked_seats.php',
                        type: 'GET',
                        data: { movieId, date, time },
                        success: function(response) {
                            const bookedSeats = JSON.parse(response);
                            $('.seat').each(function() {
                                const seatId = $(this).data('seat-id');
                                if (bookedSeats.includes(seatId)) {
                                    $(this).addClass('occupied').off('click');
                                }
                            });
                        }
                    });
                }
            }

            generateSeatMap();
            fetchBookedSeats();

            $('select[name="date"], select[name="hour"]').change(function() {
                $('.seat').removeClass('occupied').off('click').on('click', function() {
                    const seatId = $(this).data('seat-id');
                    if (selectedSeats.includes(seatId)) {
                        selectedSeats = selectedSeats.filter(s => s !== seatId);
                    } else {
                        selectedSeats.push(seatId);
                    }
                    updateSelectedSeats();
                });
                fetchBookedSeats();
            });

            $(document).on('click', '.seat:not(.occupied)', function() {
                const seatId = $(this).data('seat-id');
                if (selectedSeats.includes(seatId)) {
                    selectedSeats = selectedSeats.filter(s => s !== seatId);
                } else {
                    selectedSeats.push(seatId);
                }
                updateSelectedSeats();
            });
        });
    </script>
</body>

</html>
