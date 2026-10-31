```php
<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}


/* =========================================
   CHECK ID
========================================= */

if (!isset($_GET['id']))
{
    die("Invalid Request");
}


$id = $_GET['id'];


/* =========================================
   GET BILLING DETAILS
========================================= */

$result = mysqli_query(
    $conn,
    "SELECT * FROM billing WHERE id='$id'"
);


if (!$result)
{
    die("Billing Error : " . mysqli_error($conn));
}


$row = mysqli_fetch_assoc($result);


if (!$row)
{
    die("Billing Record Not Found");
}


/* =========================================
   UPDATE BILL
========================================= */

if (isset($_POST['update']))
{
    $patient_id   = $_POST['patient_id'];
    $total_amount = $_POST['total_amount'];
    $bill_date    = $_POST['bill_date'];


    $sql = "UPDATE billing
            SET
            patient_id='$patient_id',
            total_amount='$total_amount',
            bill_date='$bill_date'
            WHERE id='$id'";


    if (mysqli_query($conn, $sql))
    {
        echo "<script>
                alert('Bill Updated Successfully');
                window.location='billing.php';
              </script>";

        exit();
    }
    else
    {
        die(
            "Update Error : "
            . mysqli_error($conn)
        );
    }
}

?>



<!DOCTYPE html>

<html>

<head>

<title>Edit Billing</title>


<style>

/* =================================
   BODY
================================= */

body
{
    font-family: Arial, sans-serif;

    background-color: #f2f2f2;

    margin: 0;

    padding: 0;
}


/* =================================
   BACK SECTION
================================= */

.back-section
{
    text-align: right;

    padding: 20px 40px;
}


/* =================================
   BACK BUTTON
================================= */

.back-btn
{
    background-color: red;

    color: white;

    padding: 10px 20px;

    border: none;

    cursor: pointer;

    border-radius: 5px;

    text-decoration: none;

    display: inline-block;
}


.back-btn:hover
{
    background-color: darkred;
}


/* =================================
   CONTAINER
================================= */

.container
{
    width: 50%;

    margin: 20px auto 40px auto;

    background: white;

    padding: 30px;

    border-radius: 10px;

    box-shadow: 0 0 10px gray;
}


/* =================================
   HEADING
================================= */

h2
{
    text-align: center;

    color: #1f5f96;

    margin-bottom: 30px;
}


/* =================================
   LABEL
================================= */

label
{
    display: block;

    margin-top: 15px;

    margin-bottom: 7px;

    font-size: 16px;

    font-weight: bold;

    color: #333;
}


/* =================================
   INPUT & SELECT
================================= */

input,
select
{
    width: 100%;

    padding: 11px;

    margin-bottom: 10px;

    box-sizing: border-box;

    border: 1px solid #aaa;

    border-radius: 4px;

    font-size: 15px;
}


input:focus,
select:focus
{
    border-color: #2875aa;

    outline: none;

    box-shadow: 0 0 4px rgba(40,117,170,0.3);
}


/* =================================
   BILL ID
================================= */

.bill-id
{
    background-color: #f4f4f4;

    color: #555;

    cursor: not-allowed;
}


/* =================================
   UPDATE BUTTON
================================= */

.update-btn
{
    width: 100%;

    background-color: #2875aa;

    color: white;

    border: none;

    padding: 12px;

    margin-top: 20px;

    font-size: 16px;

    cursor: pointer;

    border-radius: 5px;
}


.update-btn:hover
{
    background-color: #1b5680;
}


/* =================================
   CANCEL BUTTON
================================= */

.cancel-btn
{
    display: block;

    width: 100%;

    box-sizing: border-box;

    text-align: center;

    background-color: #6c757d;

    color: white;

    padding: 12px;

    margin-top: 10px;

    text-decoration: none;

    border-radius: 5px;
}


.cancel-btn:hover
{
    background-color: #545b62;
}


/* =================================
   RESPONSIVE
================================= */

@media(max-width:700px)
{
    .container
    {
        width: 80%;
    }

    .back-section
    {
        padding: 20px;
    }
}

</style>

</head>



<body>


<!-- =================================
     BACK BUTTON
================================= -->

<div class="back-section">

<a href="billing.php" class="back-btn">

&lt;- BACK

</a>

</div>



<!-- =================================
     MAIN CONTAINER
================================= -->

<div class="container">


<h2>Edit Billing</h2>



<form method="POST">






<!-- =================================
     PATIENT
================================= -->

<label>Patient Name</label>


<select
name="patient_id"
required>


<option value="">

Select Patient

</option>


<?php


$patients = mysqli_query(
    $conn,
    "SELECT * FROM patient
     ORDER BY patient_name ASC"
);


if (!$patients)
{
    die(
        "Patient Error : "
        . mysqli_error($conn)
    );
}


while (
    $patient =
    mysqli_fetch_assoc($patients)
)
{

?>


<option
value="<?php echo $patient['id']; ?>"

<?php

if (
    $patient['id']
    ==
    $row['patient_id']
)
{
    echo "selected";
}

?>
>

<?php

echo htmlspecialchars(
    $patient['patient_name']
);

?>

</option>


<?php

}

?>

</select>



<!-- =================================
     TOTAL AMOUNT
================================= -->

<label>Total Amount</label>


<input
type="number"
step="0.01"
name="total_amount"
value="<?php echo $row['total_amount']; ?>"
required>



<!-- =================================
     BILL DATE
================================= -->

<label>Bill Date</label>


<input
type="date"
name="bill_date"
value="<?php echo $row['bill_date']; ?>"
required>



<!-- =================================
     UPDATE BUTTON
================================= -->

<button
type="submit"
name="update"
class="update-btn">

Update Bill

</button>



<!-- =================================
     CANCEL BUTTON
================================= -->

<a
href="billing.php"
class="cancel-btn">

Cancel

</a>


</form>


</div>


</body>

</html>
```
