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
    <title>Reserva <?php echo $row['movieTitle']; ?> Ahora</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <script src="_.js "></script>
</head>

<body style="background-color:#6e5a11;">
    <div class="booking-panel">
        <div class="booking-panel-section booking-panel-section1">
            <h1>RESERVA TU ENTRADA</h1>
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
                        <td>GÉNERO</td>
                        <td><?php echo $row['movieGenre']; ?></td>
                    </tr>
                    <tr>
                        <td>DURACIÓN</td>
                        <td><?php echo $row['movieDuration']; ?></td>
                    </tr>
                    <tr>
                        <td>FECHA DE ESTRENO</td>
                        <td><?php echo $row['movieRelDate']; ?></td>
                    </tr>
                    <tr>
                        <td>DIRECTOR</td>
                        <td><?php echo $row['movieDirector']; ?></td>
                    </tr>
                    <tr>
                        <td>ACTORES</td>
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
                        <option value="" disabled selected>SALA</option>
                        <option value="main-hall">Sala Principal</option>
                        <option value="vip-hall">Sala VIP</option>
                        <option value="private-hall">Sala Privada</option>
                    </select>

                    <select name="type" required>
                        <option value="" disabled selected>TIPO</option>
                        <option value="3d">3D</option>
                        <option value="2d">2D</option>
                        <option value="imax">IMAX</option>
                        <option value="7d">7D</option>
                    </select>

                    <select name="date" required>
                        <option value="" disabled selected>FECHA</option>
                        <option value="12-3">Marzo 12,2019</option>
                        <option value="13-3">Marzo 13,2019</option>
                        <option value="14-3">Marzo 14,2019</option>
                        <option value="15-3">Marzo 15,2019</option>
                        <option value="16-3">Marzo 16,2019</option>
                    </select>

                    <select name="hour" required>
                        <option value="" disabled selected>HORA</option>
                        <option value="09-00">09:00 AM</option>
                        <option value="12-00">12:00 AM</option>
                        <option value="15-00">03:00 PM</option>
                        <option value="18-00">06:00 PM</option>
                        <option value="21-00">09:00 PM</option>
                        <option value="24-00">12:00 PM</option>
                    </select>

                    <input placeholder="Nombre" type="text" name="fName" required>

                    <input placeholder="Apellido" type="text" name="lName">

                    <input placeholder="Número de Teléfono" type="text" name="pNumber" required>
                    <input placeholder="Correo Electrónico" type="email" name="email" required>
                    <input type="hidden" name="movie_id" value="<?php echo $id; ?>">



                    <button type="submit" value="save" name="submit" class="form-btn" id="book-seat-btn">Reservar un asiento</button>

                </form>
            </div>
        </div>
    </div>

    <!-- Payment Simulation Modal -->
    <div id="payment-modal" class="modal" style="display:none;">
        <div class="modal-content">
            <div id="payment-selection">
                <h2>Selecciona un método de pago</h2>
                <div class="payment-options">
                    <button class="payment-option-btn" data-payment="yape">
                        <img src="img/yape-logo.png" alt="Yape">
                        Pagar con Yape
                    </button>
                    <button class="payment-option-btn" data-payment="plin">
                        <img src="img/plin-logo.png" alt="Plin">
                        Pagar con Plin
                    </button>
                    <button class="payment-option-btn" data-payment="card">
                        <i class="fas fa-credit-card"></i>
                        Pagar con Tarjeta
                    </button>
                </div>
            </div>
            <div id="payment-processing" style="display:none;">
                <h2 id="payment-method-title"></h2>
                <div id="yape-plin-qr" style="display:none;">
                    <p>Escanea el código QR para pagar.</p>
                    <img src="img/qr-code-placeholder.png" alt="QR Code" style="max-width: 200px;">
                    <p>Una vez completado el pago, serás redirigido.</p>
                </div>
                <div id="card-form" style="display:none;">
                    <input type="text" placeholder="Número de Tarjeta" style="width: 100%; margin-bottom: 10px;">
                    <input type="text" placeholder="MM/AA" style="width: 48%; margin-right: 4%;">
                    <input type="text" placeholder="CVC" style="width: 48%;">
                    <button id="pay-now-btn" class="form-btn" style="margin-top: 20px;">Pagar Ahora</button>
                </div>
                <div class="progress-bar-container" style="display:none;">
                    <div class="progress-bar"></div>
                </div>
                <p id="payment-status-text"></p>
            </div>
            <div id="payment-success" style="display:none;">
                <img src="img/screenshot/15.png" alt="Pago Exitoso" style="max-width: 150px;">
                <h2>¡Pago Exitoso!</h2>
                <p>Tu reserva ha sido confirmada.</p>
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

            function showPaymentSuccessAndSubmit() {
                $('#payment-processing').hide();
                $('#payment-success').show();
                setTimeout(() => {
                    $('#payment-modal').hide();
                    $('form')[0].submit();
                }, 2000); // Wait 2 seconds on success screen
            }

            $('#book-seat-btn').on('click', function(e) {
                e.preventDefault();
                if (selectedSeats.length === 0) {
                    alert('Por favor, selecciona al menos un asiento.');
                    return;
                }
                // Reset modal to initial state
                $('#payment-selection').show();
                $('#payment-processing, #payment-success, #yape-plin-qr, #card-form, .progress-bar-container').hide();
                $('#payment-modal').css('display', 'flex');
            });

            $('.payment-option-btn').on('click', function() {
                const paymentMethod = $(this).data('payment');
                $('#payment-selection').hide();
                $('#payment-processing').show();

                if (paymentMethod === 'yape' || paymentMethod === 'plin') {
                    $('#payment-method-title').text('Pagando con ' + (paymentMethod === 'yape' ? 'Yape' : 'Plin'));
                    $('#yape-plin-qr').show();
                    // Simulate payment confirmation after showing QR for a few seconds
                    setTimeout(showPaymentSuccessAndSubmit, 4000);
                } else if (paymentMethod === 'card') {
                    $('#payment-method-title').text('Pagando con Tarjeta');
                    $('#card-form').show();
                }
            });

            $('#pay-now-btn').on('click', function() {
                $('#card-form').hide();
                $('.progress-bar-container').show();
                $('#payment-status-text').text('Procesando...');

                let progress = 0;
                const progressBar = $('.progress-bar');
                const interval = setInterval(() => {
                    progress += 10;
                    if (progress > 100) {
                        progress = 100;
                        clearInterval(interval);
                        $('#payment-status-text').text('¡Pago verificado!');
                        setTimeout(showPaymentSuccessAndSubmit, 1000);
                    }
                    progressBar.css('width', progress + '%');
                    progressBar.text(progress + '%');
                }, 200);
            });
        });
    </script>
</body>

</html>
