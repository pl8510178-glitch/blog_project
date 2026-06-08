<?php

session_start();

require_once __DIR__ . "/db.php";

if(!isset($_SESSION['user']))
{
    header("Location:login.php");
    exit();
}

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = "";

if(isset($_GET['search']))
{
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT * FROM posts
            WHERE title LIKE '%$search%'
            OR content LIKE '%$search%'
            ORDER BY id DESC
            LIMIT $start,$limit";

    $count_sql = "SELECT COUNT(*) as total FROM posts
                  WHERE title LIKE '%$search%'
                  OR content LIKE '%$search%'";
}
else
{
    $sql = "SELECT * FROM posts
            ORDER BY id DESC
            LIMIT $start,$limit";

    $count_sql = "SELECT COUNT(*) as total FROM posts";
}

$result = mysqli_query($conn, $sql);

$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);

$total_posts = $count_row['total'];
$total_pages = ceil($total_posts / $limit);

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Posts</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">All Blog Posts</h2>

    <form method="GET" class="mb-3">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search by title or content"
            value="<?php echo $search; ?>">
    </form>

    <table class="table table-bordered table-striped">

        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['content']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>

                <a href="edit.php?id=<?php echo $row['id']; ?>"
                   class="btn btn-warning btn-sm">
                   Edit
                </a>

                <a href="delete.php?id=<?php echo $row['id']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Are you sure you want to delete this post?');">
                   Delete
                </a>

            </td>
        </tr>

        <?php } ?>

    </table>

    <nav>
        <ul class="pagination">

            <?php
            for($i = 1; $i <= $total_pages; $i++)
            {
            ?>

            <li class="page-item <?php if($i == $page) echo 'active'; ?>">
                <a class="page-link"
                   href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>">
                   <?php echo $i; ?>
                </a>
            </li>

            <?php
            }
            ?>

        </ul>
    </nav>

    <a href="index.php" class="btn btn-primary">
        Back to Dashboard
    </a>

</div>

</body>
</html>