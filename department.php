<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}


// Insert Department Details
if (isset($_POST['save']))
{
    $department_name = $_POST['department_name'];
    $specialization = $_POST['specialization'];

    $sql = "INSERT INTO department (department_name, specialization)
            VALUES ('$department_name', '$specialization')";

    if (mysqli_query($conn, $sql))
    {
        echo "<script>alert('Department Added Successfully');</script>";
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}





?>

<!DOCTYPE html>
<html>
<head>

<title>Department Management</title>

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
    width: 70%;
    margin: 30px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px gray;
}

h2
{
    color: blue;
    text-align: center;
}

label
{
    font-weight: bold;
}

input[type=text]
{
    width: 100%;
    padding: 10px;
    margin-top: 5px;
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

<h2>Department Details</h2>

<form method="POST">

<label>Department Name</label>

<input type="text"
       name="department_name"
       placeholder="Enter Department Name"
       required>


<label>Specialization</label>

<input type="text"
       name="specialization"
       placeholder="Enter Specialization"
       required>


<button type="submit" name="save">
    Save
</button>

</form>

<hr>

<h2>Department List</h2>

<table>

<tr>
    <th>ID</th>
    <th>Department Name</th>
    <th>Specialization</th>
    <th>Update</th>
    <th>Remove</th>
</tr>

<?php

$result = mysqli_query($conn, "SELECT * FROM department");

while ($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['department_name']; ?></td>

<td><?php echo $row['specialization']; ?></td>

<td>
<a href="edit_department.php?id=<?php echo $row['id']; ?>">
    <button>Edit</button>
</a>
</td>

<td>
<a href="delete_department.php?id=<?php echo $row['id']; ?>">
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