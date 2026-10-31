<?php

$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}


/* =========================================
   SAVE BILL
========================================= */

if (isset($_POST['save']))
{
    $patient_id = $_POST['patient_id'];
    $bill_date = $_POST['bill_date'];
    $total_amount = $_POST['total_amount'];

    $medicine_ids = $_POST['medicine_id'];
    $quantities = $_POST['quantity'];
    $prices = $_POST['price'];
    $subtotals = $_POST['subtotal'];

    /* Insert into billing table */

    $sql = "INSERT INTO billing
            (patient_id, total_amount, bill_date)
            VALUES
            ('$patient_id', '$total_amount', '$bill_date')";

    if (!mysqli_query($conn, $sql))
    {
        die("Billing Insert Error: " . mysqli_error($conn));
    }

    $billing_id = mysqli_insert_id($conn);


    /* Insert selected medicines */

    foreach ($medicine_ids as $key => $medicine_id)
    {
        if (!empty($medicine_id))
        {
            $quantity = $quantities[$key];
            $price = $prices[$key];
            $subtotal = $subtotals[$key];

            $item_sql = "INSERT INTO billing_medicine
                        (billing_id, medicine_id, quantity, price, subtotal)
                        VALUES
                        ('$billing_id',
                         '$medicine_id',
                         '$quantity',
                         '$price',
                         '$subtotal')";

            if (!mysqli_query($conn, $item_sql))
            {
                die("Billing Medicine Insert Error: " . mysqli_error($conn));
            }
        }
    }

    echo "<script>
            alert('Bill Added Successfully');
            window.location='billing.php';
          </script>";
}
    

    else
    {
        echo "Error : " . mysqli_error($conn);
    }



/* =========================================
   GET MEDICINES
========================================= */

$medicine_result = mysqli_query(
    $conn,
    "SELECT * FROM medicine ORDER BY medicine_name ASC"
);


$medicine_data = array();

while ($medicine = mysqli_fetch_assoc($medicine_result))
{
    $medicine_data[] = $medicine;
}

?>


<!DOCTYPE html>

<html>

<head>

<title>Billing Management</title>


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
   BACK BUTTON
================================= */

.logout
{
    text-align: right;
    padding: 20px 40px;
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


/* =================================
   CONTAINER
================================= */

.container
{
    width: 70%;
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
}


/* =================================
   INPUT SELECT
================================= */

input,
select
{
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    box-sizing: border-box;
    border: 1px solid #aaa;
}


/* =================================
   MEDICINE SECTION
================================= */

.medicine-title
{
    margin-top: 25px;
    font-size: 20px;
    font-weight: bold;
    color: #333;
}


/* =================================
   MEDICINE ROW
================================= */

.medicine-row
{
    display: grid;

    grid-template-columns:
    2fr
    1fr
    1fr
    1fr
    100px;

    gap: 10px;

    margin-top: 12px;

    align-items: center;
}


.medicine-row input,
.medicine-row select
{
    margin-bottom: 0;
}


/* =================================
   GENERAL BUTTON
================================= */

button
{
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
}


/* =================================
   ADD BUTTON
================================= */

.add-btn
{
    background-color: #218838;
    margin-top: 15px;
}


.add-btn:hover
{
    background-color: #176c2d;
}


/* =================================
   REMOVE BUTTON
================================= */

.remove-btn
{
    background-color: #dc3545;
}


.remove-btn:hover
{
    background-color: #b52a37;
}


/* =================================
   SAVE BUTTON
================================= */

.save-btn
{
    background-color: #2875aa;
    margin-top: 20px;
    font-size: 16px;
}


.save-btn:hover
{
    background-color: #1b5680;
}


/* =================================
   TOTAL
================================= */

.total-section
{
    margin-top: 20px;
}


#totalAmount
{
    background-color: #f4f4f4;
    font-weight: bold;
}


/* =================================
   TABLE
================================= */

table
{
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}


th
{
    background:
    linear-gradient(to bottom, #2c6fa3, #1d4f75);

    color: white;
    padding: 13px;
}


td
{
    padding: 12px;
    text-align: center;
    border: 1px solid #ccc;
}


tr:nth-child(even)
{
    background-color: #f7f7f7;
}


/* =================================
   EDIT BUTTON
================================= */

.edit-btn
{
    background-color: #218838;
    color: white;
    padding: 8px 13px;
    text-decoration: none;
    border-radius: 3px;
}


/* =================================
   DELETE BUTTON
================================= */

.delete-btn
{
    background-color: #dc3545;
    color: white;
    padding: 8px 13px;
    text-decoration: none;
    border-radius: 3px;
}


/* =================================
   RESPONSIVE
================================= */

@media(max-width:900px)
{
    .container
    {
        width: 85%;
    }


    .medicine-row
    {
        grid-template-columns: 1fr;
    }
}

</style>

</head>


<body>


<!-- BACK BUTTON -->

<div class="logout">

<a href="dashboard.php">

<button type="button">
    &lt;- BACK
</button>

</a>

</div>



<div class="container">


<!-- =================================
     BILLING DETAILS
================================= -->

<h2>Billing Details</h2>


<form method="POST">


<!-- PATIENT -->

<label>Patient Name</label>


<select name="patient_id" required>

<option value="">
    Select Patient
</option>


<?php

$patients = mysqli_query(
    $conn,
    "SELECT * FROM patient ORDER BY patient_name ASC"
);


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



<!-- MEDICINE DETAILS -->

<div class="medicine-title">

Medicine Details

</div>



<div id="medicineContainer">


<!-- FIRST MEDICINE ROW -->

<div class="medicine-row">


<select
name="medicine_id[]"
class="medicine-select"
onchange="setPrice(this)"
required>


<option value="">
Select Medicine
</option>


<?php

foreach ($medicine_data as $medicine)
{
?>

<option
value="<?php echo $medicine['id']; ?>"
data-price="<?php echo $medicine['price']; ?>">

<?php echo $medicine['medicine_name']; ?>

</option>

<?php
}
?>

</select>



<input
type="number"
name="quantity[]"
class="quantity"
placeholder="Quantity"
min="1"
oninput="calculateRow(this)"
required>



<input
type="number"
name="price[]"
class="price"
placeholder="Price"
step="0.01"
readonly>



<input
type="number"
name="subtotal[]"
class="subtotal"
placeholder="Subtotal"
step="0.01"
readonly>



<button
type="button"
class="remove-btn"
onclick="removeMedicine(this)">

Remove

</button>


</div>


</div>



<!-- ADD MEDICINE -->

<button
type="button"
class="add-btn"
onclick="addMedicine()">

+ Add Medicine

</button>



<!-- TOTAL AMOUNT -->

<div class="total-section">


<label>Total Amount</label>


<input
type="number"
name="total_amount"
id="totalAmount"
step="0.01"
value="0.00"
readonly>


</div>



<!-- BILL DATE -->

<label>Bill Date</label>


<input
type="date"
name="bill_date"
value="<?php echo date('Y-m-d'); ?>"
required>



<!-- SAVE -->

<button
type="submit"
name="save"
class="save-btn">

Save Bill

</button>


</form>



<hr style="margin-top:40px;">



<!-- =================================
     BILLING LIST
================================= -->


<h2>Billing List</h2>


<table>


<tr>

<th>ID</th>

<th>Patient Name</th>

<th>Medicines</th>

<th>Total Amount</th>

<th>Bill Date</th>

<th>Update</th>

<th>Remove</th>

</tr>



<?php


$sql = "

SELECT

billing.*,

patient.patient_name

FROM billing

LEFT JOIN patient

ON billing.patient_id = patient.id

ORDER BY billing.id ASC";


$result = mysqli_query($conn, $sql);


while ($row = mysqli_fetch_assoc($result))
{
?>


<tr>


<!-- ID -->

<td>

<?php echo $row['id']; ?>

</td>



<!-- PATIENT -->

<td>

<?php echo $row['patient_name']; ?>

</td>



<!-- MEDICINES -->

<td>


<?php


$bill_id = $row['id'];


$medicine_sql = "

SELECT

medicine.medicine_name,

billing_medicine.quantity

FROM billing_medicine

LEFT JOIN medicine

ON billing_medicine.medicine_id = medicine.id

WHERE billing_medicine.billing_id='$bill_id'";


$medicine_list_result =
mysqli_query($conn, $medicine_sql);


$medicine_list = array();


while ($med = mysqli_fetch_assoc($medicine_list_result))
{
    $medicine_list[] =

    $med['medicine_name']

    . " ("

    . $med['quantity']

    . ")";
}


echo implode(", ", $medicine_list);


?>


</td>



<!-- AMOUNT -->

<td>

₹ <?php echo number_format($row['total_amount'], 2); ?>

</td>



<!-- DATE -->

<td>

<?php

echo date(
    "d-m-Y",
    strtotime($row['bill_date'])
);

?>

</td>



<!-- EDIT -->

<td>

<a
href="edit_billing.php?id=<?php echo $row['id']; ?>"
class="edit-btn">

Edit

</a>

</td>



<!-- DELETE -->

<td>

<a
href="delete_billing.php?id=<?php echo $row['id']; ?>"
class="delete-btn"
onclick="return confirm('Are you sure you want to delete this bill?')">

Delete

</a>

</td>


</tr>


<?php
}
?>


</table>


</div>



<!-- =================================
     JAVASCRIPT
================================= -->


<script>


/* =================================
   ADD MEDICINE
================================= */

function addMedicine()
{

    var container =
    document.getElementById("medicineContainer");


    var rows =
    container.getElementsByClassName("medicine-row");


    /* Maximum 5 medicines */

    if (rows.length >= 5)
    {
        alert("Maximum 5 medicines can be selected.");

        return;
    }


    var newRow =
    document.createElement("div");


    newRow.className =
    "medicine-row";


    newRow.innerHTML = `


<select
name="medicine_id[]"
class="medicine-select"
onchange="setPrice(this)"
required>


<option value="">
Select Medicine
</option>


<?php

foreach ($medicine_data as $medicine)
{
?>

<option
value="<?php echo $medicine['id']; ?>"
data-price="<?php echo $medicine['price']; ?>">

<?php echo $medicine['medicine_name']; ?>

</option>

<?php
}
?>

</select>



<input
type="number"
name="quantity[]"
class="quantity"
placeholder="Quantity"
min="1"
oninput="calculateRow(this)"
required>



<input
type="number"
name="price[]"
class="price"
placeholder="Price"
step="0.01"
readonly>



<input
type="number"
name="subtotal[]"
class="subtotal"
placeholder="Subtotal"
step="0.01"
readonly>



<button
type="button"
class="remove-btn"
onclick="removeMedicine(this)">

Remove

</button>

`;


    container.appendChild(newRow);

}



/* =================================
   REMOVE MEDICINE
================================= */

function removeMedicine(button)
{

    var row =
    button.parentElement;


    var container =
    document.getElementById("medicineContainer");


    var rows =
    container.getElementsByClassName("medicine-row");


    if (rows.length <= 1)
    {
        alert("At least one medicine is required.");

        return;
    }


    row.remove();


    calculateTotal();

}



/* =================================
   SET MEDICINE PRICE
================================= */

function setPrice(select)
{

    var row =
    select.parentElement;


    var option =
    select.options[select.selectedIndex];


    var price =
    option.getAttribute("data-price");


    row.querySelector(".price").value =
    price ? price : "";


    calculateRow(
        row.querySelector(".quantity")
    );

}



/* =================================
   CALCULATE ROW
================================= */

function calculateRow(input)
{

    var row =
    input.parentElement;


    var quantity =
    parseFloat(
        row.querySelector(".quantity").value
    ) || 0;


    var price =
    parseFloat(
        row.querySelector(".price").value
    ) || 0;


    var subtotal =
    quantity * price;


    row.querySelector(".subtotal").value =
    subtotal.toFixed(2);


    calculateTotal();

}



/* =================================
   CALCULATE TOTAL
================================= */

function calculateTotal()
{

    var subtotals =
    document.querySelectorAll(".subtotal");


    var total = 0;


    subtotals.forEach(function(item)
    {
        total +=
        parseFloat(item.value) || 0;
    });


    document.getElementById("totalAmount").value =
    total.toFixed(2);

}


</script>


</body>

</html>