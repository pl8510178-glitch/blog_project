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

/* Fetch Post Using Prepared Statement */
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0)
{
    die("Post Not Found");
}

$row = $result->fetch_assoc();

/* Update Post */
if(isset($_POST['update']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Server-side Validation
    if(empty($title))
    {
        die("Title Required");
    }

    if(empty($content))
    {
        die("Content Required");
    }

    $stmt = $conn->prepare(
        "UPDATE posts
         SET title = ?, content = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "ssi",
        $title,
        $content,
        $id
    );

    if($stmt->execute())
    {
        header("Location:view.php");
        exit();
    }
    else
    {
        echo "Error Updating Post";
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
        value="<?php echo htmlspecialchars($row['title']); ?>"
        required>

    <br><br>

    Content:
    <br>

    <textarea
        name="content"
        rows="5"
        cols="40"
        required><?php echo htmlspecialchars($row['content']); ?></textarea>

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