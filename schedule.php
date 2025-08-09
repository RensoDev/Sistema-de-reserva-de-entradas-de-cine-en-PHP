<?php
include "connection.php";
// Fetch unique dates for the schedule buttons
$dates_query = "SELECT DISTINCT showtimeDate FROM showtimes ORDER BY showtimeDate";
$dates_result = mysqli_query($con, $dates_query);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario de Películas</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div class="schedule-section">
        <h1>Horario</h1>
        <div class="schedule-dates">
            <?php
            $first_date = true;
            while ($date_row = mysqli_fetch_assoc($dates_result)) {
                $date = $date_row['showtimeDate'];
                $formatted_date = date("d M, Y", strtotime($date));
                $is_selected = $first_date ? 'schedule-item-selected' : '';
                echo "<div class='schedule-item " . $is_selected . "' data-date='" . $date . "'>" . $formatted_date . "</div>";
                $first_date = false;
            }
            ?>
        </div>
        <div class="schedule-table">
            <table>
                <thead>
                    <tr>
                        <th>FUNCIÓN</th>
                        <th>HORARIO EN CINE</th>
                    </tr>
                </thead>
                <tbody id="schedule-table-body">
                    <!-- El contenido se cargará aquí con AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>

    <script src="scripts/jquery-3.3.1.min.js"></script>
    <script src="scripts/script.js"></script>
    <script>
        $(document).ready(function() {
            function loadSchedule(date) {
                $.ajax({
                    url: 'get_schedule.php',
                    type: 'GET',
                    data: { date: date },
                    dataType: 'json',
                    success: function(movies) {
                        const scheduleBody = $('#schedule-table-body');
                        scheduleBody.empty();
                        if (movies.length === 0) {
                            scheduleBody.html('<tr><td colspan="2" style="text-align:center;">No hay funciones para esta fecha.</td></tr>');
                            return;
                        }

                        movies.forEach(function(movie) {
                            let hallsHtml = '';
                            const halls = {};
                            
                            if (movie.showtimes) {
                                const showtimes = movie.showtimes.split(';');
                                showtimes.forEach(function(showtime) {
                                    const parts = showtime.split('|');
                                    const time = parts[0];
                                    const hall = parts[1];
                                    const price = parts[2];
                                    const showtimeID = parts[3];

                                    if (!halls[hall]) {
                                        halls[hall] = '';
                                    }
                                    halls[hall] += `<a href="booking.php?id=${movie.movieID}&showtime=${showtimeID}" class="schedule-item">${formatTime(time)}</a>`;
                                });
                            }

                            for (const hall in halls) {
                                hallsHtml += `
                                    <div class="hall-type">
                                        <h3>${hall}</h3>
                                        <div>${halls[hall]}</div>
                                    </div>
                                `;
                            }

                            const row = `
                                <tr class="fade-scroll">
                                    <td>
                                        <h2>${movie.movieTitle}</h2>
                                        <i class="far fa-clock"></i> ${movie.movieDuration} min
                                        <p><b>Director:</b> ${movie.movieDirector}</p>
                                        <p><b>Actores:</b> ${movie.movieActors}</p>
                                        <a href="booking.php?id=${movie.movieID}" class="schedule-item">RESERVAR</a>
                                    </td>
                                    <td>${hallsHtml}</td>
                                </tr>
                            `;
                            scheduleBody.append(row);
                        });
                    },
                    error: function() {
                        $('#schedule-table-body').html('<tr><td colspan="2" style="text-align:center;">Error al cargar el horario.</td></tr>');
                    }
                });
            }

            function formatTime(timeString) {
                const [hour, minute] = timeString.split(':');
                const hourInt = parseInt(hour, 10);
                const ampm = hourInt >= 12 ? 'PM' : 'AM';
                const formattedHour = hourInt % 12 === 0 ? 12 : hourInt % 12;
                return `${formattedHour}:${minute} ${ampm}`;
            }

            $('.schedule-item').on('click', function() {
                $('.schedule-item').removeClass('schedule-item-selected');
                $(this).addClass('schedule-item-selected');
                const selectedDate = $(this).data('date');
                loadSchedule(selectedDate);
            });

            // Cargar el horario para la primera fecha por defecto
            const defaultDate = $('.schedule-item.schedule-item-selected').data('date');
            if (defaultDate) {
                loadSchedule(defaultDate);
            } else {
                 $('#schedule-table-body').html('<tr><td colspan="2" style="text-align:center;">No hay funciones programadas.</td></tr>');
            }
        });
    </script>
</body>
</html>
