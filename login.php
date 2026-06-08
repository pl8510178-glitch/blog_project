<?php

require_once __DIR__ . "/db.php";

/** @var mysqli $conn */

session_start();

if(isset($_POST['login']))
{
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepared Statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        if(
            $password === $row['password'] ||
            password_verify($password, $row['password'])
        )
        {
            $_SESSION['user'] = $row['username'];

            // Store Role
            $_SESSION['role'] = $row['role'];

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