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
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Validation
    if(empty($title))
    {
        die("Title Required");
    }

    if(empty($content))
    {
        die("Content Required");
    }

    // Prepared Statement
    $stmt = $conn->prepare(
        "INSERT INTO posts(title, content) VALUES(?, ?)"
    );

    $stmt->bind_param("ss", $title, $content);

    if($stmt->execute())
    {
        echo "Post Added Successfully";
    }
    else
    {
        echo "Error: " . $conn->error;
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