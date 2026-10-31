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
"SELECT * FROM medicine WHERE id='$id'");

$row = mysqli_fetch_assoc($result);


if (isset($_POST['update']))
{
    $medicine_name = $_POST['medicine_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "UPDATE medicine
            SET medicine_name='$medicine_name',
                quantity='$quantity',
                price='$price'
            WHERE id='$id'";

    if (mysqli_query($conn, $sql))
    {
        header("Location: medicine.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Medicine</title>

<style>

body
{
    font-family: Arial, sans-serif;
    background-color: #eef3f8;
    margin: 0;
    padding: 0;
}


.container
{
    width: 65%;
    margin: 80px auto;
    background: white;
    padding: 40px;
    border-radius: 15px;

    box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
}


h2
{
    text-align: center;
    color: #1f5f99;
    margin-bottom: 35px;
}


label
{
    display: block;
    font-size: 18px;
    margin-bottom: 8px;
    font-weight: 500;
}


input
{
    width: 100%;
    padding: 14px;
    font-size: 16px;

    border: 1px solid #ccc;
    border-radius: 5px;

    box-sizing: border-box;

    margin-bottom: 25px;
}


input:focus
{
    outline: none;
    border-color: #1f77b4;

    box-shadow: 0px 0px 5px
    rgba(31,119,180,0.4);
}


.button-group
{
    display: flex;
    gap: 20px;
    margin-top: 10px;
}


.update-btn
{
    background-color: #2d7db3;
    color: white;

    border: none;

    padding: 13px 30px;

    font-size: 16px;

    border-radius: 5px;

    cursor: pointer;
}


.update-btn:hover
{
    background-color: #1f5f99;
}


.cancel-btn
{
    background-color: #c23b64;

    color: white;

    text-decoration: none;

    padding: 13px 30px;

    font-size: 16px;

    border-radius: 5px;

    display: inline-block;
}


.cancel-btn:hover
{
    background-color: #9e2f50;
}

</style>

</head>


<body>


<div class="container">

<h2>Edit Medicine Details</h2>


<form method="POST">


<label>Medicine Name</label>

<input type="text"
       name="medicine_name"
       value="<?php echo $row['medicine_name']; ?>"
       required>


<label>Quantity</label>

<input type="number"
       name="quantity"
       value="<?php echo $row['quantity']; ?>"
       required>


<label>Price</label>

<input type="number"
       step="0.01"
       name="price"
       value="<?php echo $row['price']; ?>"
       required>


<div class="button-group">


<button type="submit"
        name="update"
        class="update-btn">

Update Medicine

</button>


<a href="medicine.php"
   class="cancel-btn">

Cancel

</a>


</div>


</form>

</div>


</body>

</html>