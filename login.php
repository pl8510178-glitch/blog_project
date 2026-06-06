<?php

require_once __DIR__ . "/db.php";

/** @var mysqli $conn */

session_start();

if(isset($_POST['login']))
{
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);

        // Supports both plain-text and hashed passwords
        if(
            $password === $row['password'] ||
            password_verify($password, $row['password'])
        )
        {
            $_SESSION['user'] = $username;

            header("Location: index.php");
            exit();
        }
        else
        {
            $error = "Wrong Password";
        }
    }
    else
    {
        $error = "User Not Found";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php
if(isset($error))
{
    echo "<p>$error</p>";
}
?>

<form method="POST">

    Username:
    <input type="text" name="username" required>

    <br><br>

    Password:
    <input type="password" name="password" required>

    <br><br>

    <input type="submit" name="login" value="Login">

</form>

<br>

<a href="register.php">Create New Account</a>

</body>
</html>