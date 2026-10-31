<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}


/* Check ID */

if (!isset($_GET['id']))
{
    header("Location: doctor.php");
    exit();
}

$id = $_GET['id'];


/* Update Doctor */

if (isset($_POST['update']))
{
    $doctor_name = $_POST['doctor_name'];
    $specialization = $_POST['specialization'];
    $department = $_POST['department_id'];
    $phone = $_POST['phone'];


    $sql = "UPDATE doctor SET

            doctor_name='$doctor_name',
            specialization='$specialization',
            department_id='$department',
            phone='$phone'

            WHERE id='$id'";


    if (mysqli_query($conn, $sql))
    {
        echo "<script>
                alert('Doctor Updated Successfully');
                window.location='doctor.php';
              </script>";
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}


/* Get Doctor Details */

$result = mysqli_query(
    $conn,
    "SELECT * FROM doctor WHERE id='$id'"
);

$row = mysqli_fetch_assoc($result);

?>


<!DOCTYPE html>
<html>

<head>

<title>Edit Doctor</title>

<style>

body
{
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}


.container
{
    width: 50%;
    margin: 50px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px gray;
}


h2
{
    text-align: center;
    color: #1f5f96;
}


label
{
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
}


input,select
{
    width: 100%;
    padding: 12px;
    box-sizing: border-box;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    font: size 16px;
}
select{
    width:100%;
    height:50px;
}


button
{
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 4px;
}


.update-btn
{
    background-color: #2875aa;
}


.cancel-btn
{
    background-color: #dc3545;
    margin-left: 10px;
}


</style>

</head>


<body>


<div class="container">

<h2>Edit Doctor Details</h2>


<form method="POST">


<label>Doctor Name</label>

<input
type="text"
name="doctor_name"
value="<?php echo $row['doctor_name']; ?>"
required>


<label>Specialization</label>

<input
type="text"
name="specialization"
value="<?php echo $row['specialization']; ?>"
required>


<label>Department</label>

<select name="department_id" required>

<option value="">Select Department</option>

<?php

$departments = mysqli_query(
    $conn,
    "SELECT * FROM department"
);

while ($dept = mysqli_fetch_assoc($departments))
{
?>

<option value="<?php echo $dept['id']; ?>"

<?php
if ($dept['id'] == $row['department_id'])
{
    echo "selected";
}
?>

>
<?php echo $dept['department_name']; ?>
</option>

<?php
}
?>

</select>


<label>Phone Number</label>

<input
type="text"
name="phone"
value="<?php echo $row['phone']; ?>"
required>


<button
type="submit"
name="update"
class="update-btn">

Update Doctor

</button>


<a href="doctor.php">

<button
type="button"
class="cancel-btn">

Cancel

</button>

</a>


</form>


</div>


</body>

</html>