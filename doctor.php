
<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}


// Insert Doctor Details

if (isset($_POST['save']))
{
    $doctor_name    = $_POST['doctor_name'];
    $specialization = $_POST['specialization'];
    $department_id  = $_POST['department_id'];
    $phone          = $_POST['phone'];

    $sql = "INSERT INTO doctor
            (doctor_name, specialization, department_id, phone)
            VALUES
            ('$doctor_name',
             '$specialization',
             '$department_id',
             '$phone')";

    if (mysqli_query($conn, $sql))
    {
        echo "<script>alert('Doctor Added Successfully');</script>";
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

<title>Doctor Management</title>

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
    width: 50%;
    margin: 30px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px gray;
}

h2
{
    text-align: center;
    color: blue;
}

input, select
{
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
}

button
{
    background-color: blue;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

button:hover
{
    background-color: darkblue;
}

table
{
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td
{
    border: 1px solid black;
}

th
{
    background-color: blue;
    color: white;
}

th, td
{
    padding: 10px;
    text-align: center;
}

</style>

</head>

<body>

<div class="logout">

<a href="dashboard.php">
    <button><-BACK</button>
</a>

</div>


<div class="container">

<h2>Doctor Details</h2>

<form method="POST">

<label>Doctor Name</label>

<input type="text"
       name="doctor_name"
       placeholder="Enter Doctor Name"
       required>


<label>Specialization</label>

<input type="text"
       name="specialization"
       placeholder="Enter Specialization"
       required>


<label>Department</label>

<select name="department_id" required>

<option value="">Select Department</option>

<?php

$department = mysqli_query($conn,
               "SELECT * FROM department");

while ($row = mysqli_fetch_assoc($department))
{
?>

<option value="<?php echo $row['id']; ?>">
    <?php echo $row['department_name']; ?>
</option>

<?php
}

?>

</select>


<label>Phone Number</label>

<input type="text"
       name="phone"
       placeholder="Enter Phone Number"
       required>


<button type="submit" name="save">
    Save
</button>

</form>


<hr>

<h2>Doctor List</h2>

<table>

<tr>
    <th>ID</th>
    <th>Doctor Name</th>
    <th>Specialization</th>
    <th>Department</th>
    <th>Phone</th>
    <th>Update</th>
    <th>Remove</th>
</tr>


<?php

$sql = "SELECT doctor.*,
               department.department_name
        FROM doctor
        LEFT JOIN department
        ON doctor.department_id = department.id";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['doctor_name']; ?></td>

<td><?php echo $row['specialization']; ?></td>

<td><?php echo $row['department_name']; ?></td>

<td><?php echo $row['phone']; ?></td>


<td>
<a href="edit_doctor.php?id=<?php echo $row['id']; ?>">
    <button>Edit</button>
</a>
</td>


<td>
<a href="delete_doctor.php?id=<?php echo $row['id']; ?>">
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

