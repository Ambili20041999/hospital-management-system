<!DOCTYPE html>
<html>

<head>
<title>Dashboard</title>

<link rel="stylesheet" href="style.css">

<style>

.logout
{
    text-align: right;
    padding: 15px;
}

.logout button
{
    background-color: red;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
}

.logout button:hover
{
    background-color: darkred;
}

</style>

</head>

<body>

<div class="logout">

<a href="login.php">
<button>Logout</button>
</a>

</div>


<div class="header">
<h1>Hospital Management System</h1>
</div>


<div class="container">

<div class="card">
<h2>Department</h2>
<a href="department.php">
<button>Open</button>
</a>
</div>


<div class="card">
<h2>Doctor</h2>
<a href="doctor.php">
<button>Open</button>
</a>
</div>


<div class="card">
<h2>Patient</h2>
<a href="patient.php">
<button>Open</button>
</a>
</div>


<div class="card">
<h2>Appointment</h2>
<a href="appointment.php">
<button>Open</button>
</a>
</div>


<div class="card">
<h2>Medicine</h2>
<a href="medicine.php">
<button>Open</button>
</a>
</div>


<div class="card">
<h2>Billing</h2>
<a href="billing.php">
<button>Open</button>
</a>
</div>

</div>

</body>
</html>