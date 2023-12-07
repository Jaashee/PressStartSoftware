<?php include './includes/header.php'; ?>
<?php
$method = 1;
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $employee_id = 0;
    $password = "";
    $confirmpassword = "";
    $message = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee = $_SESSION['employee_id'];
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);


    //error checking
    $valid = true;


    if (strlen($password) < 6) {
        $message = "Password must be greater then 6 characters";
        $password = "";
        $valid = false;

    }


    if (!($password == $confirmpassword)) {
        $message = "Passwords must match";
        $valid = false;


    }

    $enc_password = password_hash($password, $method);

    $sql = "UPDATE employee ";
    $sql .= "SET password = ('$enc_password')";
    $sql .= "WHERE employee_id = $employee";


    if ($valid) {
        if (pg_query($conn, $sql)) {

            $message = "Password successfully updated!";

        }
    }

}
?>
    <div class="main-content">
        <div class="container">
            <div>
                <h1><b>Change Password</b></h1>
                <a href="index.php">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="nav-item">Back to Employee Page</span>


                </a>
            </div>

            <h2 id="errors"> <?php echo $message; ?></h2>

            <div>

                <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">


                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input class="form-control" name="password" placeholder="Enter Password" type="password">

                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirm Password:</label>
                        <input class="form-control" name="confirmpassword" placeholder="Confirm Password"
                               type="password">

                    </div>

                    <button class="btn btn-primary" type="submit">Update</button>
                </form>

            </div>
        </div>
    </div>

<?php include './includes/footer.php';


?>