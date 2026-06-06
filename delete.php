<?php

session_start();

require_once __DIR__ . "/db.php";

/** @var mysqli $conn */

if(!isset($_SESSION['user']))
{
    header("Location:login.php");
    exit();
}

if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];

    $sql = "DELETE FROM posts WHERE id=$id";

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
else
{
    echo "Invalid Request";
}

?>