<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}


/* Check Doctor ID */

if (isset($_GET['id']))
{
    $id = $_GET['id'];


    /* Delete Doctor */

    $sql = "DELETE FROM doctor WHERE id='$id'";


    if (mysqli_query($conn, $sql))
    {
        echo "<script>
                alert('Doctor Deleted Successfully');
                window.location='doctor.php';
              </script>";
    }
    else
    {
        echo "Error : " . mysqli_error($conn);
    }
}

else
{
    header("Location: doctor.php");
    exit();
}

?>