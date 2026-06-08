<?php

session_start();

require_once __DIR__ . "/db.php";

/** @var mysqli $conn */

// Check Login
if(!isset($_SESSION['user']))
{
    header("Location:login.php");
    exit();
}

// Check Admin Role
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    die("Access Denied! Only Admin can delete posts.");
}

if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];

    // Prepared Statement
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute())
    {
        header("Location:view.php");
        exit();
    }
    else
    {
        echo "Error deleting post.";
    }
}
else
{
    echo "Invalid Request";
}

?>