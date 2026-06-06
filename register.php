<?php

require_once __DIR__ . "/db.php";

/** @var mysqli $conn */

if(isset($_POST['register']))
{
    $username = trim($_POST['username']);

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    // Check if username already exists
    $check = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0)
    {
        $message = "Username already exists";
    }
    else
    {
        $sql = "INSERT INTO users(username,password)
                VALUES('$username','$password')";

        if(mysqli_query($conn, $sql))
        {
            $message = "Registration Successful";
        }
        else
        {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Create Account</h2>

<?php
if(isset($message))
{
    echo "<p>$message</p>";
}
?>

<form method="POST">

    Username:
    <input type="text" name="username" required>

    <br><br>

    Password:
    <input type="password" name="password" required>

    <br><br>

    <input type="submit" name="register" value="Register">

</form>

<br>

<a href="login.php">Already have an account? Login</a>

</body>
</html>