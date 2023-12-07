<?php include './includes/header.php'; ?>
<?php
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $employee_id = 0;
    $first_name = "";
    $message = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee = $_SESSION['employee_id'];
    $first_name = trim($_POST['first_name']);


    //error checking
    $valid = true;


    if (strlen($first_name) <= 1) {
        $message = "First name must be greater then 1 character";
        $first_name = "";
        $valid = false;

    }


    $sql = "UPDATE employee ";
    $sql .= "SET first_name = ('$first_name')";
    $sql .= "WHERE employee_id = $employee";


    if ($valid) {
        if (pg_query($conn, $sql)) {

            $message = "First name successfully updated!";

        }
    }

}
?>
    <div class="main-content">
        <div class="container">
            <div>
                <h1><b>Update first name</b></h1>
                <a href="index.php">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="nav-item">Back to Employee Page</span>


                </a>
            </div>

            <h2 id="errors"> <?php echo $message; ?></h2>

            <div>

                <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">


                    <div class="form-group">
                        <label for="first_name">Update your First Name:</label>
                        <input class="form-control" name="first_name" placeholder="Enter first name" type="text">

                    </div>

                    <button class="btn btn-primary" type="submit">Update</button>
                </form>

            </div>
        </div>
    </div>

<?php include './includes/footer.php';


?>