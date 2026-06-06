<?php

session_start();

if(!isset($_SESSION['user']))
{
    header("Location:login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Dashboard</title>
</head>
<body>

<h1>Welcome <?php echo $_SESSION['user']; ?></h1>

<h2>Blog Dashboard</h2>

<hr>

<a href="add.php">➕ Add Post</a>

<br><br>

<a href="view.php">📖 View Posts</a>

<br><br>

<a href="logout.php">🚪 Logout</a>

<hr>

<p>CRUD Blog Application</p>

</body>
</html>