<?php
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "Hashed Password: " . $hash;
}
?>
<!DOCTYPE html>
<html>
<body>

<h2>Create a secure password</h2>

<form method="post">
  Password: <input type="text" name="password" required>
  <input type="submit" value="Hash Password">
</form>

</body>
</html>
