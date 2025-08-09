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

$movieID = $_GET['id'] ?? null;
$movie = null;

if ($movieID) {
    $query = "SELECT * FROM movieTable WHERE movieID = " . mysqli_real_escape_string($con, $movieID);
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $movie = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Película no encontrada.');window.location.href='addmovie.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID de película no proporcionado.');window.location.href='addmovie.php';</script>";
    exit;
}

if (isset($_POST['submit'])) {
    $movieTitle = mysqli_real_escape_string($con, $_POST['movieTitle']);
    $movieGenre = mysqli_real_escape_string($con, $_POST['movieGenre']);
    $movieDuration = mysqli_real_escape_string($con, $_POST['movieDuration']);
    $movieRelDate = mysqli_real_escape_string($con, $_POST['movieRelDate']);
    $movieDirector = mysqli_real_escape_string($con, $_POST['movieDirector']);
    $movieActors = mysqli_real_escape_string($con, $_POST['movieActors']);
    $mainhall = mysqli_real_escape_string($con, $_POST['mainhall']);
    $viphall = mysqli_real_escape_string($con, $_POST['viphall']);
    $privatehall = mysqli_real_escape_string($con, $_POST['privatehall']);

    $update_image_query = "";
    if (isset($_FILES['movieImg']['name']) && $_FILES['movieImg']['name'] != '') {
        $target_dir = "../img/";
        if (!file_exists($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                die('No se pudo crear el directorio...');
            }
        }
        $nombre_archivo = basename($_FILES["movieImg"]["name"]);
        $archivo_destino = $target_dir . $nombre_archivo;
        
        if (move_uploaded_file($_FILES["movieImg"]["tmp_name"], $archivo_destino)) {
            $update_image_query = ", movieImg = 'img/" . $nombre_archivo . "'";
        } else {
            echo "<script>alert('Hubo un error al subir tu archivo.');window.location.href='editmovie.php?id=" . $movieID . "';</script>";
            exit;
        }
    }

    $update_query = "UPDATE movieTable SET 
                        movieTitle = '$movieTitle',
                        movieGenre = '$movieGenre',
                        movieDuration = '$movieDuration',
                        movieRelDate = '$movieRelDate',
                        movieDirector = '$movieDirector',
                        movieActors = '$movieActors',
                        mainhall = '$mainhall',
                        viphall = '$viphall',
                        privatehall = '$privatehall'
                        $update_image_query
                    WHERE movieID = " . mysqli_real_escape_string($con, $movieID);

    $rs = mysqli_query($con, $update_query);
    if ($rs) {
        echo "<script>alert('Película actualizada exitosamente');window.location.href='addmovie.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la película: " . mysqli_error($con) . "');window.location.href='editmovie.php?id=" . $movieID . "';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Película</title>
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
                        <h2>Editar Película</h2>
                        <i class="fas fa-film" style="background-color: #4547cf"></i>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input placeholder="Título" type="text" name="movieTitle" value="<?php echo htmlspecialchars($movie['movieTitle'] ?? ''); ?>" required>
                        <input placeholder="Género" type="text" name="movieGenre" value="<?php echo htmlspecialchars($movie['movieGenre'] ?? ''); ?>" required>
                        <input placeholder="Duración" type="number" name="movieDuration" value="<?php echo htmlspecialchars($movie['movieDuration'] ?? ''); ?>" required>
                        <input placeholder="Fecha de Estreno" type="date" name="movieRelDate" value="<?php echo htmlspecialchars($movie['movieRelDate'] ?? ''); ?>" required>
                        <input placeholder="Director" type="text" name="movieDirector" value="<?php echo htmlspecialchars($movie['movieDirector'] ?? ''); ?>" required>
                        <input placeholder="Actores" type="text" name="movieActors" value="<?php echo htmlspecialchars($movie['movieActors'] ?? ''); ?>" required>
                        <label>Precio</label>
                        <input placeholder="Sala Principal" type="text" name="mainhall" value="<?php echo htmlspecialchars($movie['mainhall'] ?? ''); ?>" required><br />
                        <input placeholder="Sala VIP" type="text" name="viphall" value="<?php echo htmlspecialchars($movie['viphall'] ?? ''); ?>" required><br />
                        <input placeholder="Sala Privada" type="text" name="privatehall" value="<?php echo htmlspecialchars($movie['privatehall'] ?? ''); ?>" required><br />
                        <br>
                        <label>Póster Actual:</label>
                        <?php if (!empty($movie['movieImg'])): ?>
                            <img src="../<?php echo htmlspecialchars($movie['movieImg']); ?>" alt="Póster de la película" style="max-width: 150px; margin-bottom: 10px;"><br>
                        <?php endif; ?>
                        <label>Cambiar Póster (opcional)</label>
                        <input type="file" name="movieImg" accept="image/*">
                        <button type="submit" value="submit" name="submit" class="form-btn">Actualizar Película</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../scripts/jquery-3.3.1.min.js "></script>
    <script src="../scripts/owl.carousel.min.js "></script>
    <script src="../scripts/script.js "></script>
</body>

</html>
