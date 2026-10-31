<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}


// Insert Patient Details

if (isset($_POST['save']))
{
    $patient_name = $_POST['patient_name'];
    $age          = $_POST['age'];
    $gender       = $_POST['gender'];
    $phone        = $_POST['phone'];
    $address      = $_POST['address'];

    $sql = "INSERT INTO patient
            (patient_name, age, gender, phone, address)
            VALUES
            ('$patient_name',
             '$age',
             '$gender',
             '$phone',
             '$address')";

    if (mysqli_query($conn, $sql))
    {
        echo "<script>alert('Patient Added Successfully');</script>";
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

<title>Patient Management</title>

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
    width:60%;
    margin:30px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0px 0px 10px gray;
}

h2
{
    text-align:center;
    color:blue;
}

input, select, textarea
{
    width:100%;
    padding:10px;
    margin-bottom:15px;
}

button
{
    background-color:blue;
    color:white;
    padding:10px 20px;
    border:none;
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

<h2>Patient Details</h2>

<form method="POST">

<label>Patient Name</label>

<input type="text"
       name="patient_name"
       placeholder="Enter Patient Name"
       required>


<label>Age</label>

<input type="number"
       name="age"
       placeholder="Enter Age"
       required>


<label>Gender</label>

<select name="gender" required>

<option value="">Select Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option>

</select>


<label>Phone Number</label>

<input type="text"
       name="phone"
       placeholder="Enter Phone Number"
       required>


<label>Address</label>

<textarea name="address"
          placeholder="Enter Address"
          required></textarea>


<button type="submit" name="save">
    Save
</button>

</form>


<hr>

<h2>Patient List</h2>

<table>

<tr>
    <th>ID</th>
    <th>Patient Name</th>
    <th>Age</th>
    <th>Gender</th>
    <th>Phone Number</th>
    <th>Address</th>
    <th>Update</th>
    <th>Remove</th>
</tr>

<?php

$result = mysqli_query($conn, "SELECT * FROM patient");

while ($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['patient_name']; ?></td>
<td><?php echo $row['age']; ?></td>
<td><?php echo $row['gender']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['address']; ?></td>
<td>
<a href="edit_patient.php?id=<?php echo $row['id']; ?>">
<button>Edit</button>
</a>
</td>

<td>
<a href="delete_patient.php?id=<?php echo $row['id']; ?>">
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