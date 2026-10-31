<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

$id = $_GET['id'];

$sql = "DELETE FROM department WHERE id='$id'";

if (mysqli_query($conn, $sql))
{
    header("Location: department.php");
    exit();
}
else
{
    echo "Error: " . mysqli_error($conn);
}

?>