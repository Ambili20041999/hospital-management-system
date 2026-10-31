<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

$id = $_GET['id'];

// Get the selected department details
$result = mysqli_query($conn, "SELECT * FROM department WHERE id='$id'");
$row = mysqli_fetch_assoc($result);


// Update department details
if (isset($_POST['update']))
{
    $department_name = $_POST['department_name'];
    $specialization = $_POST['specialization'];

    $sql = "UPDATE department
            SET department_name='$department_name',
                specialization='$specialization'
            WHERE id='$id'";

    if (mysqli_query($conn, $sql))
    {
        header("Location: department.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Department</title>

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
    color: blue;
    text-align: center;
}

input[type=text]
{
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
}

button
{
    background-color: green;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

button:hover
{
    background-color: darkgreen;
}

</style>

</head>

<body>

<div class="container">

<h2>Edit Department</h2>

<form method="POST">

<label>Department Name</label>

<input type="text"
       name="department_name"
       value="<?php echo $row['department_name']; ?>"
       required>


<label>Specialization</label>

<input type="text"
       name="specialization"
       value="<?php echo $row['specialization']; ?>"
       required>


<button type="submit" name="update">
    Update
</button>

</form>

</div>

</body>
</html>