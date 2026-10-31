<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}


// Insert Appointment Details

if (isset($_POST['save']))
{
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO appointment
            (patient_id, doctor_id, appointment_date, status)
            VALUES
            ('$patient_id',
             '$doctor_id',
             '$appointment_date',
             '$status')";

    if (mysqli_query($conn, $sql))
    {
        echo "<script>alert('Appointment Added Successfully');</script>";
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

<title>Appointment Management</title>

<style>

body
{
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}
.logout
{
    text-align: right;
    padding: 20px;
}

.logout button
{
    background-color: red;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.logout button:hover
{
    background-color: darkred;
}

.container
{
    width:50%;
    margin:30px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px gray;
}

h2
{
    text-align:center;
    color:blue;
}

input, select
{
    width:100%;
    padding:10px;
    margin-bottom:15px;
}

button
{
    background-color:blue;
    color:white;
    border:none;
    padding:10px 20px;
    cursor:pointer;
}

button:hover
{
    background-color:darkblue;
}

table
{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

table, th, td
{
    border:1px solid black;
}

th
{
    background-color:blue;
    color:white;
}

th, td
{
    padding:10px;
    text-align:center;
}

</style>

</head>

<body>
    <body>
    <div class="logout">

<a href="dashboard.php">
    <button><-BACK</button>
</a>

</div>

<div class="container">

<h2>Appointment Details</h2>

<form method="POST">


<label>Patient Name</label>

<select name="patient_id" required>

<option value="">Select Patient</option>

<?php

$patients = mysqli_query($conn, "SELECT * FROM patient");

while ($row = mysqli_fetch_assoc($patients))
{
?>

<option value="<?php echo $row['id']; ?>">
    <?php echo $row['patient_name']; ?>
</option>

<?php
}
?>

</select>


<label>Doctor Name</label>

<select name="doctor_id" required>

<option value="">Select Doctor</option>

<?php

$doctors = mysqli_query($conn, "SELECT * FROM doctor");

while ($row = mysqli_fetch_assoc($doctors))
{
?>

<option value="<?php echo $row['id']; ?>">
    <?php echo $row['doctor_name']; ?>
</option>

<?php
}
?>

</select>


<label>Appointment Date</label>

<input type="date"
       name="appointment_date"
       required>


<label>Status</label>

<select name="status" required>

<option value="">Select Status</option>
<option value="Scheduled">Scheduled</option>
<option value="Completed">Completed</option>
<option value="Cancelled">Cancelled</option>

</select>


<button type="submit" name="save">
Save
</button>

</form>


<hr>

<h2>Appointment List</h2>

<table>

<tr>
    <th>ID</th>
    <th>Patient Name</th>
    <th>Doctor Name</th>
    <th>Appointment Date</th>
    <th>Status</th>
    <th>Update</th>
    <th>Remove</th>
</tr>

<?php

$sql = "SELECT appointment.*,
        patient.patient_name,
        doctor.doctor_name
        FROM appointment
        LEFT JOIN patient
        ON appointment.patient_id = patient.id
        LEFT JOIN doctor
        ON appointment.doctor_id = doctor.id";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['patient_name']; ?></td>
<td><?php echo $row['doctor_name']; ?></td>
<td><?php echo $row['appointment_date']; ?></td>
<td><?php echo $row['status']; ?></td>
<td>
<a href="edit_appointment.php?id=<?php echo $row['id']; ?>">
<button>Edit</button>
</a>
</td>

<td>
<a href="delete_appointment.php?id=<?php echo $row['id']; ?>">
<button>Delete</button>
</a>
</td>

</tr>

<?php
}
?>

</table>

</div>

</body>
</html>