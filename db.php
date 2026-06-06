<?php

/** @var mysqli $conn */

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "blog"
);

if(!$conn)
{
    die("Connection Failed");
}

?>