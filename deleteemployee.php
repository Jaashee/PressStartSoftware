<?php include './includes/header.php'; ?>
<?php
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
}
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $confirm = "";


} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee = trim($_POST['employee_id']);
    $confirm = trim($_POST['confirm']);


    $valid = true;

    if (!is_numeric($employee)) {
        $message = "Employee ID must be a number";
        $prodid = "";
        $valid = false;

    } else {
        $query = pg_query($conn, "SELECT * FROM  employee WHERE employee_id= '$employee'");
        if (!pg_num_rows($query) > 0) {
            $message = "Employee ID does not exist";
            $valid = false;
        }
    }
    if (!isset($confirm) || trim($confirm) == "") {
        $message = "Confirmation is required";
        $valid = false;

    }

    if (!isset($employee) || trim($employee) == "") {
        $message = "Employee ID is required";
        $valid = false;

    }

    if (!$confirm == "CONFIRM") {
        $message = "You must type 'CONFIRM' for deletion";
        $valid = false;

    }


    $sql = "DELETE FROM employee";
    $sql .= " WHERE employee_id = $employee";


    if ($valid) {
        if (pg_query($conn, $sql)) {

            $message = "Account successfully deleted!";

        }
    }

}
?>
    <div class="main-content">
    <div class="container">
    <div>
        <h1><b>Delete Employee Account</b></h1>
        <a href="index.php">
            <i class="fa-solid fa-arrow-left"></i>
            <span class="nav-item">Back to Employee Page</span>


        </a>
    </div>

    <h2 id="errors"> <?php echo $message; ?></h2>

    <div>

        <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">


            <div class="form-group">
                <label for="employee_id">Employe ID:</label>
                <input class="form-control" name="employee_id" placeholder="Enter employee ID" type="number">

            </div>

            <div class="form-group">
                <label for="confirm">Type 'CONFIRM' to delete account:</label>
                <input class="form-control" name="confirm" placeholder="CONFIRM" type="text">

            </div>


            <button class="btn btn-primary" type="submit">Delete</button>
        </form>

    </div>
    </div>
    </div>

<?php include './includes/footer.php';


?>