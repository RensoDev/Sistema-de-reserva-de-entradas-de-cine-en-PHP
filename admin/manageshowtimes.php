<?php
include "config.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
}

// Cerrar sesión
if (isset($_POST['but_logout'])) {
    session_destroy();
    header('Location: index.php');
}

// Añadir función
if (isset($_POST['add_showtime'])) {
    $movieID = $_POST['movieID'];
    $showtimeDate = $_POST['showtimeDate'];
    $showtimeTime = $_POST['showtimeTime'];
    $hall = $_POST['hall'];
    $price = $_POST['price'];

    $insert_query = "INSERT INTO showtimes (movieID, showtimeDate, showtimeTime, hall, price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($insert_query);
    $stmt->bind_param("isssd", $movieID, $showtimeDate, $showtimeTime, $hall, $price);
    if ($stmt->execute()) {
        echo "<script>alert('Función añadida exitosamente'); window.location.href='manageshowtimes.php';</script>";
    } else {
        echo "<script>alert('Error al añadir la función');</script>";
    }
}

// Eliminar función
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM showtimes WHERE showtimeID = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Función eliminada exitosamente'); window.location.href='manageshowtimes.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar la función');</script>";
    }
}

// Fetch movies for dropdown
$movie_query = "SELECT movieID, movieTitle FROM movieTable";
$movie_result = mysqli_query($con, $movie_query);

// Fetch all showtimes
$showtime_query = "SELECT s.*, m.movieTitle FROM showtimes s JOIN movieTable m ON s.movieID = m.movieID ORDER BY s.showtimeDate, s.showtimeTime";
$showtime_result = mysqli_query($con, $showtime_query);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Funciones</title>
    <link rel="icon" type="image/png" href="../img/logo.png">
    <link rel="stylesheet" href="../style/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <?php include('header.php'); ?>

    <div class="admin-container">
        <?php include('sidebar.php'); ?>
        <div class="admin-section admin-section2">
            <div class="admin-section-column">
                <div class="admin-section-panel admin-section-panel2">
                    <div class="admin-panel-section-header">
                        <h2>Añadir Nueva Función</h2>
                        <i class="fas fa-clock" style="background-color: #4547cf"></i>
                    </div>
                    <form action="" method="POST">
                        <select name="movieID" required>
                            <option value="" disabled selected>Seleccionar Película</option>
                            <?php while ($movie_row = mysqli_fetch_assoc($movie_result)) { ?>
                                <option value="<?php echo $movie_row['movieID']; ?>"><?php echo $movie_row['movieTitle']; ?></option>
                            <?php } ?>
                        </select>
                        <input type="date" name="showtimeDate" required>
                        <input type="time" name="showtimeTime" required>
                        <select name="hall" required>
                            <option value="" disabled selected>Seleccionar Sala</option>
                            <option value="Sala Principal">Sala Principal</option>
                            <option value="Sala VIP">Sala VIP</option>
                            <option value="Sala Privada">Sala Privada</option>
                        </select>
                        <input type="number" step="0.01" name="price" placeholder="Precio" required>
                        <button type="submit" name="add_showtime" class="form-btn">Añadir Función</button>
                    </form>
                </div>

                <div class="admin-section-panel admin-section-panel2">
                    <div class="admin-panel-section-header">
                        <h2>Funciones Programadas</h2>
                        <i class="fas fa-film" style="background-color: #4547cf"></i>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Película</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Sala</th>
                                <th>Precio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($showtime_row = mysqli_fetch_assoc($showtime_result)) { ?>
                                <tr>
                                    <td><?php echo $showtime_row['movieTitle']; ?></td>
                                    <td><?php echo $showtime_row['showtimeDate']; ?></td>
                                    <td><?php echo $showtime_row['showtimeTime']; ?></td>
                                    <td><?php echo $showtime_row['hall']; ?></td>
                                    <td><?php echo $showtime_row['price']; ?></td>
                                    <td>
                                        <a href="manageshowtimes.php?delete_id=<?php echo $showtime_row['showtimeID']; ?>" onclick="return confirm('¿Estás seguro?')" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../scripts/jquery-3.3.1.min.js "></script>
    <script src="../scripts/script.js "></script>
</body>

</html>
