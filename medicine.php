<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}


// Insert Medicine Details

if (isset($_POST['save']))
{
    $medicine_name = $_POST['medicine_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "INSERT INTO medicine
            (medicine_name, quantity, price)
            VALUES
            ('$medicine_name',
             '$quantity',
             '$price')";

    if (mysqli_query($conn, $sql))
    {
        echo "<script>alert('Medicine Added Successfully');</script>";
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

<title>Medicine Management</title>

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

input
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
    <div class="logout">

<a href="dashboard.php">
    <button><-BACK</button>
</a>

</div>

<div class="container">

<h2>Medicine Details</h2>

<form method="POST">

<label>Medicine Name</label>

<input type="text"
       name="medicine_name"
       placeholder="Enter Medicine Name"
       required>


<label>Quantity</label>

<input type="number"
       name="quantity"
       placeholder="Enter Quantity"
       required>


<label>Price</label>

<input type="number"
       step="0.01"
       name="price"
       placeholder="Enter Price"
       required>


<button type="submit" name="save">
    Save
</button>

</form>


<hr>

<h2>Medicine List</h2>

<table>

<tr>
    <th>ID</th>
    <th>Medicine Name</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Update</th>
    <th>Remove</th>
</tr>

<?php

$result = mysqli_query($conn, "SELECT * FROM medicine");

while ($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['medicine_name']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td><?php echo $row['price']; ?></td>
<td>
<a href="edit_medicine.php?id=<?php echo $row['id']; ?>">
<button>Edit</button>
</a>
</td>

<td>
<a href="delete_medicine.php?id=<?php echo $row['id']; ?>">
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