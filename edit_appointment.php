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
 
$result = mysqli_query($conn, 
"SELECT * FROM appointment WHERE id='$id'"); 
 
$row = mysqli_fetch_assoc($result); 
 
 
if (isset($_POST['update'])) 
{ 
    $patient_id = $_POST['patient_id']; 
    $doctor_id = $_POST['doctor_id']; 
    $appointment_date = $_POST['appointment_date']; 
    $status = $_POST['status']; 
 
    $sql = "UPDATE appointment 
            SET patient_id='$patient_id', 
                doctor_id='$doctor_id', 
                appointment_date='$appointment_date', 
                status='$status' 
            WHERE id='$id'"; 
 
    if (mysqli_query($conn, $sql)) 
    { 
        echo "<script>
                alert('Appointment Updated Successfully');
                window.location='appointment.php';
              </script>";
        exit();
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

<title>Edit Appointment</title> 


<style>

/* Page Background */

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
    width: 70%;
    margin: 60px auto;
    background: white;
    padding: 45px;
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
    margin-top: 22px;
    margin-bottom: 8px;
}


/* Input Fields */

input,
select
{
    width: 100%;
    padding: 13px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}


/* Focus */

input:focus,
select:focus
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
    display: inline-block;
    background-color: #a93260;
    color: white;
    padding: 13px 30px;
    font-size: 16px;
    border-radius: 5px;
    text-decoration: none;
    margin-left: 15px;
}


.cancel-btn:hover
{
    background-color: #7b1f45;
}

</style>

</head> 


<body> 


<div class="container">


<h2>Edit Appointment Details</h2> 


<form method="POST"> 


<!-- Patient Name -->

<label>Patient Name</label>

<select name="patient_id" required> 


<?php 

$patients = mysqli_query($conn,"SELECT * FROM patient"); 

while($patient = mysqli_fetch_assoc($patients)) 
{ 
?> 


<option value="<?php echo $patient['id']; ?>" 

<?php 

if($patient['id'] == $row['patient_id']) 
{ 
    echo "selected"; 
} 

?> 
> 

<?php echo $patient['patient_name']; ?> 

</option> 


<?php 
} 
?> 

</select> 



<!-- Doctor Name -->

<label>Doctor Name</label>

<select name="doctor_id" required> 


<?php 

$doctors = mysqli_query($conn,"SELECT * FROM doctor"); 

while($doctor = mysqli_fetch_assoc($doctors)) 
{ 
?> 


<option value="<?php echo $doctor['id']; ?>" 

<?php 

if($doctor['id'] == $row['doctor_id']) 
{ 
    echo "selected"; 
} 

?> 
> 

<?php echo $doctor['doctor_name']; ?> 

</option> 


<?php 
} 
?> 

</select> 



<!-- Appointment Date -->

<label>Appointment Date</label>

<input type="date" 
name="appointment_date" 
value="<?php echo $row['appointment_date']; ?>"
required> 



<!-- Status -->

<label>Status</label>

<select name="status" required>

    <option value="Pending"
    <?php if($row['status'] == "Pending") echo "selected"; ?>>
    Pending
    </option>

    <option value="Confirmed"
    <?php if($row['status'] == "Confirmed") echo "selected"; ?>>
    Confirmed
    </option>

    <option value="Completed"
    <?php if($row['status'] == "Completed") echo "selected"; ?>>
    Completed
    </option>

    <option value="Cancelled"
    <?php if($row['status'] == "Cancelled") echo "selected"; ?>>
    Cancelled
    </option>

</select>



<!-- Buttons -->

<button type="submit" 
name="update" 
class="update-btn">

Update Appointment

</button>


<a href="appointment.php" 
class="cancel-btn">

Cancel

</a>


</form>


</div>


</body> 

</html>