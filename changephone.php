<?php include './includes/header.php'; ?>
<?php
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $employee_id = 0;
    $phonenumber = "";
    $message = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee = $_SESSION['employee_id'];
    $phonenumber = trim($_POST['phonenumber']);


    //error checking
    $valid = true;


    if (!isset($phonenumber) || trim($phonenumber) == "") {
        $message = "Phone Number is required";
        $phonenumber = "";
        $valid = false;

    }
    if (strlen($phonenumber) < 12) {
        $message = "Phone number not formatted properly";
        $phonenumber = "";
        $valid = false;

    }
    $query = pg_query($conn, "SELECT * FROM  employee WHERE phone_number= '$phonenumber'");
    if (pg_num_rows($query) > 0) {
        $message = "A employee already has that phone number";
        $valid = false;
    }


    $sql = "UPDATE employee ";
    $sql .= "SET phone_number = ('$phonenumber')";
    $sql .= "WHERE employee_id = $employee";


    if ($valid) {
        if (pg_query($conn, $sql)) {

            $message = "Phone Number successfully updated!";

        }
    }

}
?>
    <div class="main-content">
        <div class="container">
            <div>
                <h1><b>Update Phone Number</b></h1>
                <a href="index.php">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="nav-item">Back to Employee Page</span>


                </a>
            </div>

            <h2 id="errors"> <?php echo $message; ?></h2>

            <div>

                <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">


                    <div class="form-group">
                        <label for="phonenumber">Update Phone Number:</label>
                        <input class="form-control" name="phonenumber" placeholder="Enter Phone Number" type="text">

                    </div>


                    <button class="btn btn-primary" type="submit">Update</button>
                </form>

            </div>
        </div>
    </div>

<?php include './includes/footer.php';


?>