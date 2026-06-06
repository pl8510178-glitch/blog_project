<<?php

session_start();

require_once __DIR__ . "/db.php";

/** @var mysqli $conn */

if(!isset($_SESSION['user']))
{
    header("Location:login.php");
    exit();
}

$sql = "SELECT * FROM posts ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Posts</title>
</head>
<body>

<h2>All Blog Posts</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Content</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($result))
{
?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['content']; ?></td>
    <td><?php echo $row['created_at']; ?></td>
    <td>

        <a href="edit.php?id=<?php echo $row['id']; ?>">
            Edit
        </a>

        |

        <a href="delete.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Are you sure you want to delete this post?');">
            Delete
        </a>

    </td>
</tr>

<?php
}
?>

</table>

<br><br>

<a href="index.php">Back to Dashboard</a>

</body>
</html>