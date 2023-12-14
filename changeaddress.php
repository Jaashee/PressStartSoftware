<?php include './includes/header.php'; ?>
<?php
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $employee_id = 0;
    $address = "";
    $message = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee = $_SESSION['employee_id'];
    $address = trim($_POST['address']);


    //error checking
    $valid = true;


    if (!isset($address) || trim($address) == "") {
        $message = "Address is required";
        $address = "";
        $valid = false;

    }


    $sql = "UPDATE employee ";
    $sql .= "SET address = ('$address')";
    $sql .= "WHERE employee_id = $employee";


    if ($valid) {
        if (pg_query($conn, $sql)) {

            $message = "Address successfully updated!";

        }
    }

}
?>
    <div class="main-content">
        <div class="form-container">
            <div>
                <h1><b>Update Address</b></h1>
            </div>
            <h2 id="errors"> <?php echo $message; ?></h2>
            <div>
                <form class="update-name-form" method="post" enctype="multipart/form-data"
                      action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label for="password">Address:</label>
                        <input class="form-control" name="address" placeholder="Enter Address" type="text">
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>
            <a href="index.php">
                <i class="fa-solid fa-arrow-left"></i>
                <span class="nav-item">Back to Employee Page</span>
            </a>
        </div>
    </div>

<?php include './includes/footer.php';


?>