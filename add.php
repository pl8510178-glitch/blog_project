<?php

session_start();

require_once __DIR__ . "/db.php";

/** @var mysqli $conn */

if(!isset($_SESSION['user']))
{
    header("Location:login.php");
    exit();
}

if(isset($_POST['publish']))
{
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts(title, content)
            VALUES('$title', '$content')";

    if(mysqli_query($conn, $sql))
    {
        echo "Post Added Successfully";
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
</head>
<body>

<h2>Add New Blog Post</h2>

<form method="POST">

    Title:
    <br>
    <input type="text" name="title" required>

    <br><br>

    Content:
    <br>
    <textarea name="content" rows="5" cols="40" required></textarea>

    <br><br>

    <input type="submit" name="publish" value="Publish Post">

</form>

<br>

<a href="index.php">Back to Dashboard</a>

</body>
</html>