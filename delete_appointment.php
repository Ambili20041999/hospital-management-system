<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!isset($_GET['id']))
{
    die("Invalid Request");
}

$id = $_GET['id'];

$sql = "DELETE FROM appointment WHERE id='$id'";

if (mysqli_query($conn, $sql))
{
    header("Location: appointment.php");
    exit();
}
else
{
    echo mysqli_error($conn);
}

?>