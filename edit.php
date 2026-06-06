<?php

session_start();

require_once __DIR__ . "/db.php";

/** @var mysqli $conn */

if(!isset($_SESSION['user']))
{
    header("Location:login.php");
    exit();
}

if(!isset($_GET['id']))
{
    die("Invalid Request");
}

$id = (int)$_GET['id'];

$sql = "SELECT * FROM posts WHERE id=$id";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0)
{
    die("Post Not Found");
}

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts
            SET title='$title',
                content='$content'
            WHERE id=$id";

    if(mysqli_query($conn, $sql))
    {
        header("Location:view.php");
        exit();
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
    <title>Edit Post</title>
</head>
<body>

<h2>Edit Post</h2>

<form method="POST">

    Title:
    <br>
    <input
        type="text"
        name="title"
        value="<?php echo $row['title']; ?>"
        required>

    <br><br>

    Content:
    <br>
    <textarea
        name="content"
        rows="5"
        cols="40"
        required><?php echo $row['content']; ?></textarea>

    <br><br>

    <input
        type="submit"
        name="update"
        value="Update Post">

</form>

<br>

<a href="view.php">Back to Posts</a>

</body>
</html>