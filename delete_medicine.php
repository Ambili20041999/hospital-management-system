<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}

if (!isset($_GET['id']))
{
    die("Invalid Request");
}

$id = $_GET['id'];

$sql = "DELETE FROM medicine WHERE id='$id'";

if (mysqli_query($conn, $sql))
{
    header("Location: medicine.php");
    exit();
}
else
{
    echo "Error : " . mysqli_error($conn);
}

?>