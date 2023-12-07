<?php include './includes/header.php'; ?>
<?php
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
}
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $confirm = "";


} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $repair = trim($_POST['repair_id']);
    $confirm = trim($_POST['confirm']);


    $valid = true;

    if (!is_numeric($repair)) {
        $message = "Repair ID must be a number";
        $prodid = "";
        $valid = false;

    } else {
        $query = pg_query($conn, "SELECT * FROM  repair WHERE repair_id= '$repair'");
        if (!pg_num_rows($query) > 0) {
            $message = "Repair ID does not exist";
            $valid = false;
        }
    }
    if (!isset($confirm) || trim($confirm) == "") {
        $message = "Confirmation is required";
        $valid = false;

    }

    if (!isset($repair) || trim($repair) == "") {
        $message = "Repair ID is required";
        $valid = false;

    }

    if (!$confirm == "CONFIRM") {
        $message = "You must type 'CONFIRM' for deletion";
        $valid = false;

    }


    $sql = "DELETE FROM repair";
    $sql .= " WHERE repair_id = $repair";


    if ($valid) {
        if (pg_query($conn, $sql)) {

            $message = "Repair successfully deleted!";

        }
    }

}
?>
    <div class="main-content">
        <div class="container">
            <div>
                <h1><b>Delete A Repair</b></h1>
                <a href="repair.php">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="nav-item">Back to Repair Page</span>


                </a>
            </div>

            <h2 id="errors"> <?php echo $message; ?></h2>

            <div>

                <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">


                    <div class="form-group">
                        <label for="employee_id">Employe ID:</label>
                        <input class="form-control" name="repair_id" placeholder="Enter Repair ID" type="number">

                    </div>

                    <div class="form-group">
                        <label for="confirm">Type 'CONFIRM' to delete repair:</label>
                        <input class="form-control" name="confirm" placeholder="CONFIRM" type="text">

                    </div>


                    <button class="btn btn-primary" type="submit">Delete</button>
                </form>

            </div>
        </div>
    </div>

<?php include './includes/footer.php';


?>