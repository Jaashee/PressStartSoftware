<?php

include "./includes/header.php";
?>

<?php
$message = "";
if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $email_address = "";
    $fname = "";
    $lname = "";
    $dob = "";
    $address = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_address = trim($_POST['client_email']);
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $dob = trim($_POST['dobb']);
    $address = trim($_POST['address']);


    // Validate the form data
    $valid = true;
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $valid = false;
        $message = "Client email must be formatted correctly";
    }

    $query = pg_query($conn, "SELECT * FROM  client WHERE client_email= '$email_address'");
    if (pg_num_rows($query) > 0) {
        $message = "Email already use";
        $valid = false;
    }
    if (!isset($fname) || trim($fname) == "") {
        $message = "First name is required";
        $fname = "";
        $valid = false;
    }
    if (!isset($lname) || trim($lname) == "") {
        $message = "Last name is required";
        $lname = "";
        $valid = false;
    }
    if (!isset($dob) || trim($dob) == "") {
        $message = "Date of birth is required";

        $valid = false;
    }
    if (!isset($address) || trim($address) == "") {
        $message = "Address is required";

        $valid = false;
    }
    if (strlen($fname) <= 1) {
        $message = "First name must be greater then 1 character";
        $fname = "";
        $valid = false;

    }
    if (strlen($lname) <= 1) {
        $message = "Last name must be greater then 1 character";
        $lname = "";
        $valid = false;

    }


    // If the form data is valid, insert the new salesperson user into the database
    $sql = "INSERT INTO client (client_email,first_name,last_name,client_address,dob)";
    $sql .= "VALUES ('$email_address','$fname','$lname','$address','$dob')";

    if ($valid) {
        if (pg_query($conn, $sql)) {

            $message = "The client email was successfully registered!";
        } else {

        }
    }

}
?>
<div class="main-content">
    <div class="client-page-container">
        <h1 class="client-page-title">Client Page</h1>
        <form class="client-form">
            <h2 id="errors"> <?php echo $message; ?></h2>

            <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <div class="form-group">
                    <label for="fname">Client Email:</label>
                    <input class="form-control" name="client_email" placeholder="Enter Client Email" type="email">
                </div>
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input class="form-control" name="fname" placeholder="Enter First Name" type="text">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input class="form-control" name="lname" placeholder="Enter Last Name" type="text">
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input class="form-control" name="dobb" placeholder="YYYY-MM-DD" type="text">
                </div>
                <div class="form-group">
                    <label for="adsress">Client Address:</label>
                    <input class="form-control" name="address" placeholder="Enter Address" type="text">
                </div>
                <br>
                <button class="btn btn-primary" type="submit">Register</button>
            </form>
        </form>
    </div>
</div>


<?php
include "./includes/footer.php";
?> 