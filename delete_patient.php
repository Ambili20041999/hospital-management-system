<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!isset($_GET['id']))
{
    die("Invalid Request");
}

$id = $_GET['id'];

$sql = "DELETE FROM patient WHERE id='$id'";

if (mysqli_query($conn, $sql))
{
    header("Location: patient.php");
    exit();
}
else
{
    echo "Error : " . mysqli_error($conn);
}

?>