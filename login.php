<?php

include './includes/header.php';
?>
<?php
$method = 1;
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $employee_id = 0;
    $password = "";


} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = trim($_POST['employee_id']);
    $password = trim($_POST['password']);

    $value = true;
    if (!isset($employee_id) || trim($employee_id) == "") {
        $message = "Employee ID is required";
        $employee_id = "";
        $valid = false;
    }
    if (!isset($password) || trim($password) == "") {
        $message = "Password is required";
        $password = "";
        $valid = false;
    }


    $sql = "SELECT * FROM employee WHERE employee_id='$employee_id'";

    $result = pg_query($conn, $sql);


    if (pg_num_rows($result) == 1) {


        $row = pg_fetch_assoc($result);
        $hashed = $row['password'];

        if (password_verify($password, $hashed)) {

            if ($row['employee_id'] === $employee_id && $row['password'] === $hashed) {
                $_SESSION['employee_id'] = $row['employee_id'];
                $_SESSION['employee_name'] = $row['first_name'];
                $_SESSION['typeemployee'] = $row['type'];
                header("Location: index.php");


            }


        }


    } else {
        $message = "Employee ID or Password is not correct";
    }

}


?>

    <div class="main-content">
        <div class="login-form-container">
            <h2 id="errors"> <?php echo $message; ?></h2>
            <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <h1 class="h3 mb-3 font-weight-normal">Employee Login</h1>
                <label for="employee_id" class="sr-only"></label>
                <input type="number" id="employee_id" class="form-control" name="employee_id"
                       value="<?php echo $employee_id; ?>" placeholder="Enter Employee ID" required autofocus>
                <label for="password" class="sr-only"></label><input type="password" id="password" name="password"
                        value="<?php echo $password; ?>" class="form-control" placeholder="Enter password" required>
                <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Sign in</button>
            </form>
        </div>
    </div>


<?php include './includes/footer.php'; ?>