<?php include './includes/header.php'; ?>
<?php
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $employee_id = 0;
    $last_name = "";
    $message = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee = $_SESSION['employee_id'];
    $last_name = trim($_POST['last_name']);


    //error checking
    $valid = true;


    if (strlen($last_name) <= 1) {
        $message = "last name must be greater then 1 character";
        $last_name = "";
        $valid = false;

    }


    $sql = "UPDATE employee ";
    $sql .= "SET last_name = ('$last_name')";
    $sql .= "WHERE employee_id = $employee";


    if ($valid) {
        if (pg_query($conn, $sql)) {

            $message = "Last name successfully updated!";

        }
    }

}
?>
    <div class="main-content">
        <div class="form-container">
            <div>
                <h1><b>Update last name</b></h1>
            </div>
            <h2 id="errors"> <?php echo $message; ?></h2>
            <div>
                <form class="update-name-form" method="post" enctype="multipart/form-data"
                      action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label for="first_name">Update your First Name:</label>
                        <input class="form-control" name="last_name" placeholder="Enter last name" type="text">
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