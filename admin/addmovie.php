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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="../img/logo.png">
    <link rel="stylesheet" href="../style/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <?php
    $sql = "SELECT * FROM bookingTable";
    $bookingsNo = mysqli_num_rows(mysqli_query($con, $sql));
    $messagesNo = mysqli_num_rows(mysqli_query($con, "SELECT * FROM feedbackTable"));
    $moviesNo = mysqli_num_rows(mysqli_query($con, "SELECT * FROM movieTable"));
    ?>
    
    <?php include('header.php'); ?>

    <div class="admin-container">

        <?php include('sidebar.php'); ?>
        <div class="admin-section admin-section2">
            <div class="admin-section-column">


                <div class="admin-section-panel admin-section-panel2">
                    <div class="admin-panel-section-header">
                        <h2>Movies</h2>
                        <i class="fas fa-film" style="background-color: #4547cf"></i>
                    </div>
                    <form action="" method="POST">
                        <input placeholder="Title" type="text" name="movieTitle" required>
                        <input placeholder="Genre" type="text" name="movieGenre" required>
                        <input placeholder="Duration" type="number" name="movieDuration" required>
                        <input placeholder="Release Date" type="date" name="movieRelDate" required>
                        <input placeholder="Director" type="text" name="movieDirector" required>
                        <input placeholder="Actors" type="text" name="movieActors" required>
                        <label>Price</label>
                        <input placeholder="Main Hall" type="text" name="mainhall" required><br />
                        <input placeholder="Vip-Hall" type="text" name="viphall" required><br />
                        <input placeholder="Private Hall" type="text" name="privatehall" required><br />
                        <br>
                        <label>Add Poster</label>
                        <input type="file" name="movieImg" accept="image/*">
                        <button type="submit" value="submit" name="submit" class="form-btn">Add Movie</button>
                        <?php
                        if (isset($_POST['submit'])) {
                            $target_dir = "../img/";
                            // Asegurarse de que el directorio exista, crearlo si no
                            if (!file_exists($target_dir)) {
                                if (!mkdir($target_dir, 0777, true)) {
                                    die('No se pudo crear el directorio...'); // Se agregó manejo de errores para mkdir
                                }
                            }
                            
                            $fileName = basename($_FILES["movieImg"]["name"]);
                            $target_file = $target_dir . $fileName;
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                            // Verificar si el archivo de imagen es una imagen real o falsa
                            // Verificación básica: si el archivo no está vacío y tiene una extensión
                            if (!empty($_FILES["movieImg"]["tmp_name"]) && $fileName != '') {
                                // Verificar si $uploadOk es still 1
                                if ($uploadOk == 1) {
                                    // Intentar mover el archivo subido
                                    if (move_uploaded_file($_FILES["movieImg"]["tmp_name"], $target_file)) {
                                        $insert_query = "INSERT INTO 
                                        movieTable (  movieImg,
                                                        movieTitle,
                                                        movieGenre,
                                                        movieDuration,
                                                        movieRelDate,
                                                        movieDirector,
                                                        movieActors,
                                                        mainhall,
                                                        viphall,
                                                        privatehall)
                                        VALUES (        'img/" . $fileName . "',
                                                        '" . $_POST["movieTitle"] . "',
                                                        '" . $_POST["movieGenre"] . "',
                                                        '" . $_POST["movieDuration"] . "',
                                                        '" . $_POST["movieRelDate"] . "',
                                                        '" . $_POST["movieDirector"] . "',
                                                        '" . $_POST["movieActors"] . "',
                                                        '" . $_POST["mainhall"] . "',
                                                        '" . $_POST["viphall"] . "',
                                                        '" . $_POST["privatehall"] . "')";
                                        $rs = mysqli_query($con, $insert_query);
                                        if ($rs) {
                                            echo "<script>alert('Película añadida exitosamente');
                                                  window.location.href='addmovie.php';</script>";
                                        } else {
                                            echo "<script>alert('Error al guardar la película: " . mysqli_error($con) . "');
                                                  window.location.href='addmovie.php';</script>";
                                        }
                                    } else {
                                        echo "<script>alert('Hubo un error al subir tu archivo.');
                                              window.location.href='addmovie.php';</script>";
                                    }
                                } else {
                                    echo "<script>alert('Hubo un error con la validación del archivo.');
                                          window.location.href='addmovie.php';</script>";
                                }
                            } else {
                            // Manejar el caso en que no se subió ningún archivo pero se presionó enviar
                            // Por ahora, simplemente insertaremos sin imagen o mostraremos un error
                            // Un mejor enfoque podría ser hacer que el campo de archivo sea obligatorio o manejarlo de manera diferente
                            echo "<script>alert('Por favor, selecciona una imagen para la película.');
                                  window.location.href='addmovie.php';</script>";
                        }
                        }
                        ?>
                    </form>
                </div>
                <div class="admin-section-panel admin-section-panel2">
                    <div class="admin-panel-section-header">
                        <h2>Recent Movies</h2>
                        <i class="fas fa-film" style="background-color: #4547cf"></i>
                    </div>
                    <a href="temp_delete_movies.php" onclick="return confirm('¿Estás seguro de que quieres eliminar TODAS las películas? Esta acción no se puede deshacer.');" class="btn btn-danger" style="margin-bottom: 10px;">Eliminar Todas las Películas</a>

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th>MovieID</th>
                            <th>MovieTitle</th>
                            <th>Movie_Genre</th>
                            <th>Release_date</th>
                            <th>Director</th>
                            <th>Más</th>
                            <th>Editar</th>
                        </tr>
                        <tbody>
                            <?php
                            $host = "localhost"; /* Host name */
                            $user = "root"; /* User */
                            $password = ""; /* Password */
                            $dbname = "movie_ticket_booking_system"; /* Database name */

                            $con = mysqli_connect($host, $user, $password, $dbname);
                            $select = "SELECT * FROM `movietable`";
                            $run = mysqli_query($con, $select);
                            while ($row = mysqli_fetch_array($run)) {
                                $ID = $row['movieID'];
                                $title = $row['movieTitle'];
                                $genere = $row['movieGenre'];
                                $releasedate = $row['movieRelDate'];
                                $movieactor = $row['movieDirector'];
                            ?>
                                <tr align="center">
                                    <td><?php echo $ID; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $genere; ?></td>
                                    <td><?php echo $releasedate; ?></td>
                                    <td><?php echo $movieactor; ?></td>
                                    <td><button value="Eliminar" type="submit" onclick="" type="button" class="btn btn-danger"><?php echo  "<a href='deletemovie.php?id=" . $row['movieID'] . "'>Eliminar</a>"; ?></button></td>
                                    <td><button value="Editar" type="button" class="btn btn-warning"><?php echo  "<a href='editmovie.php?id=" . $row['movieID'] . "'>Editar</a>"; ?></button></td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="../scripts/jquery-3.3.1.min.js "></script>
    <script src="../scripts/owl.carousel.min.js "></script>
    <script src="../scripts/script.js "></script>
</body>

</html>
