<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}


$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM patient WHERE id='$id'");

$row = mysqli_fetch_assoc($result);


if (isset($_POST['update']))
{
    $patient_name = $_POST['patient_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE patient SET

            patient_name='$patient_name',
            age='$age',
            gender='$gender',
            phone='$phone',
            address='$address'

            WHERE id='$id'";

    if (mysqli_query($conn, $sql))
    {
        echo "<script>
                alert('Patient Updated Successfully');
                window.location='patient.php';
              </script>";
    }
    else
    {
        echo "Error : " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Patient</title>

<style>

body
{
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}


/* Main Container */

.container
{
    width: 40%;
    margin: 35px auto;
    background: white;
    padding: 40px;
    border-radius: 12px;

    box-shadow: 0px 4px 15px rgba(0,0,0,0.25);
}


/* Heading */

h2
{
    text-align: center;
    color: #2c5d8a;
    margin-bottom: 35px;
    font-size: 28px;
}


/* Labels */

label
{
    display: block;
    font-size: 18px;
    font-weight: bold;
    margin-top: 22px;
    margin-bottom: 8px;
}


/* Inputs */

input,
select,
textarea
{
    width: 100%;
    padding: 13px;

    font-size: 16px;

    border: 1px solid #ccc;

    border-radius: 4px;

    box-sizing: border-box;

    margin-bottom: 12px;
}


/* Focus */

input:focus,
select:focus,
textarea:focus
{
    outline: none;
    border-color: #3498db;
}


/* Update Button */

.update-btn
{
    background-color: #2e86c1;

    color: white;

    border: none;

    padding: 13px 30px;

    font-size: 16px;

    border-radius: 5px;

    cursor: pointer;

    margin-top: 25px;
}


.update-btn:hover
{
    background-color: #21618c;
}


/* Cancel Button */

.cancel-btn
{
    background-color: #a93260;

    color: white;

    border: none;

    padding: 13px 30px;

    font-size: 16px;

    border-radius: 5px;

    cursor: pointer;

    margin-left: 15px;

    text-decoration: none;
}


.cancel-btn:hover
{
    background-color: #7b1f45;
}




</style>

</head>


<body>


<div class="container">


<h2>Edit Patient Details</h2>


<form method="POST">


<label>Patient Name</label>

<input type="text"
       name="patient_name"
       value="<?php echo $row['patient_name']; ?>"
       required>



<label>Age</label>

<input type="number"
       name="age"
       value="<?php echo $row['age']; ?>"
       required>



<label>Gender</label>

<select name="gender" required>

<option value="">Select Gender</option>

<option value="Male"

<?php
if ($row['gender'] == "Male")
{
    echo "selected";
}
?>

>Male</option>


<option value="Female"

<?php
if ($row['gender'] == "Female")
{
    echo "selected";
}
?>

>Female</option>


<option value="Other"

<?php
if ($row['gender'] == "Other")
{
    echo "selected";
}
?>

>Other</option>

</select>



<label>Phone Number</label>

<input type="text"
       name="phone"
       value="<?php echo $row['phone']; ?>"
       required>



<label>Address</label>

<textarea name="address"
          rows="3"
          required><?php echo $row['address']; ?></textarea>



<div class="button-area">


<button type="submit"
        name="update"
        class="update-btn">

Update Patient

</button>



<a href="patient.php"
   class="cancel-btn">

Cancel

</a>


</div>


</form>


</div>


</body>

</html>