<?php include './includes/header.php'; ?>
<?php
if ($_SESSION['typeemployee'] != 'M') {
    redirect("index.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $employee_id = 0;
    $status = "";
    $message = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee = trim($_POST['employee_id']);
    $status = trim($_POST['status']);


    //error checking
    $valid = true;


    if (!isset($status) || trim($status) == "") {
        $message = "Phone Number is required";

        $valid = false;

    }

    if (!isset($employee) || trim($employee) == "") {
        $message = "Employee ID is required";

        $valid = false;

    }
    if (!is_numeric($employee)) {
        $message = "Product ID must be a number";
        $prodid = "";
        $valid = false;

    } else {
        $query = pg_query($conn, "SELECT * FROM  employee WHERE employee_id= '$employee'");
        if (!pg_num_rows($query) > 0) {
            $message = "Employee ID does not exist";
            $valid = false;
        }

        $querystatus = pg_query($conn, "SELECT * FROM  employee WHERE employee_id = '$employee' AND type= '$status'");
        if (pg_num_rows($querystatus) > 0) {
            $message = "You are trying to update a employee who already has that status";
            $valid = false;
        }
    }

    if (!($message == 'M' || $message == 'E')) {
        $message = "Status of employee can only be 'M' or 'E'";
        $valid = false;
    }


    $sql = "UPDATE employee ";
    $sql .= "SET type = ('$status')";
    $sql .= "WHERE employee_id = $employee";


    if ($valid) {
        if (pg_query($conn, $sql)) {

            $message = "Status successfully updated!";

        }
    }

}
?>
    <div class="main-content">
        <div class="form-container">
            <div>
                <h1><b>Update Employee Status</b></h1>
            </div>
            <h2 id="errors"> <?php echo $message; ?></h2>
            <div>
                <form class="update-name-form" method="post" enctype="multipart/form-data"
                      action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label for="employee_id">Client ID:</label>
                        <input class="form-control" name="employee_id" placeholder="Enter Client ID" type="number">
                    </div>
                    <div class="form-group">
                        <label for="phonenumber">Status:</label>
                        <input class="form-control" name="status" placeholder="'M' or 'E'" type="text">
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

<?php
include './includes/footer.php';


?>