<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

$error = "";

if (isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin
            WHERE username = '$username'
            AND password = '$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        header("Location: dashboard.php");
        exit();
    }
    else
    {
        $error = "Invalid Username or Password!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Hospital Management System - Login</title>

<style>

body
{
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.login-box
{
    width: 500px;
    margin: 200px auto;
    background: white;
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 0 10px gray;
    text-align: center;
}

h2
{
    color: blue;
}

input[type=text],
input[type=password]
{
    width: 90%;
    padding: 15px;
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

.error
{
    color: red;
    margin-bottom: 15px;
}

</style>

</head>
<body>

<div class="login-box">

<h2>Hospital Management System</h2>

<?php
if ($error != "")
{
    echo "<p class='error'>$error</p>";
}
?>

<form method="POST">

<input type="text"
       name="username"
       placeholder="Enter Username"
       required>

<input type="password"
       name="password"
       placeholder="Enter Password"
       required>

<br>

<button type="submit" name="login">
    Login
</button>

</form>

</div>

</body>
</html>