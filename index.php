<?php
include './includes/header.php';
$message = "";
$method = 1;

if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $first_name = "";
    $last_name = "";
    $password = "";
    $confirmpassword = "";
    $phonenumber = "";
    $address = "";
    $manaager = "";


} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    $phonenumber = trim($_POST['phonenumber']);
    $address = trim($_POST['address']);
    $manager = trim($_POST['manager']);


    // Validate the form data
    $valid = true;

    if ($_SESSION['typeemployee'] == 'M') {


        if (!isset($first_name) || trim($first_name) == "") {
            $message = "First name is required";
            $first_name = "";
            $valid = false;

        }
        if (!isset($last_name) || trim($last_name) == "") {
            $message = "Last name is required";
            $last_name = "";
            $valid = false;

        }
        if (!isset($password) || trim($password) == "") {
            $message = "Password is required";
            $password = "";
            $valid = false;

        }
        if (!isset($confirmpassword) || trim($confirmpassword) == "") {
            $message = "Confirm Password is required";
            $confirmpassword = "";
            $valid = false;

        }
        if (!isset($phonenumber) || trim($phonenumber) == "") {
            $message = "Phone Number is required";
            $phonenumber = "";
            $valid = false;

        }
        if (!isset($address) || trim($address) == "") {
            $message = "Address is required";
            $address = "";
            $valid = false;

        }
        if (strlen($password) < 6) {
            $message = "Password must be greater then 6 characters";
            $password = "";
            $valid = false;

        }


        if (!($password == $confirmpassword)) {
            $message = "Passwords must match";
            $valid = false;


        }
        if (strlen($first_name) <= 1) {
            $message = "First name must be greater then 1 character";
            $first_name = "";
            $valid = false;

        }
        if (strlen($last_name) <= 1) {
            $message = "last name must be greater then 1 character";
            $last_name = "";
            $valid = false;

        }
        if (strlen($phonenumber) < 12) {
            $message = "Phone number not formatted properly";
            $phonenumber = "";
            $valid = false;

        }
        if (!($manager == 'M' || $manager == 'E')) {
            $message = "Status of employee can only be 'M' or 'E'";
            $manager = "Status of employee can only be 'M' or 'E'";
            $valid = false;
        }

        $query = pg_query($conn, "SELECT * FROM  employee WHERE phone_number= '$phonenumber'");
        if (pg_num_rows($query) > 0) {
            $message = "A employee already has that phone number";
            $valid = false;
        }


    } else {
        $valid = false;
        $message = "Only manager can register employees";
    }


    if (isset($password)) {
        $enc_password = password_hash($password, $method);

    }


    $sql = "INSERT INTO employee (first_name,last_name,password,phone_number,address,type)";
    $sql .= "VALUES ('$first_name','$last_name','$enc_password','$phonenumber','$address','$manager')";

    if ($valid) {
        if (pg_query($conn, $sql)) {
            $message = "Employee successfully registered!";

        } else {
            $message = "Something went wrong";
        }
    }


}
?>
    <div class="wrapper">
    <div class="main-content">
        <div class="container">
            <div>
                <h1>Employee Page || Currently logged in: <?php echo $_SESSION['employee_name']; ?></h1>
                <br>
                <h3 >Employee Settings</h3>
                <div>
                    <a href="updatename.php" class="inventory-link">
                        <span class="nav-item">Update First Name</span>
                        <i class="fa-solid fa-signature"></i>

                    </a>
                    <a href="updatelastname.php" class="inventory-link">
                        <span class="nav-item">Update Last Name</span>
                        <i class="fa-solid fa-signature"></i>

                    </a>
                    <br>
                    <a href="changephone.php" class="inventory-link">
                        <span class="nav-item">Update Phone Number</span>
                        <i class="fa-solid fa-phone"></i>

                    </a>
                    <a href="changeaddress.php" class="inventory-link">
                        <span class="nav-item">Update Address</span>
                        <i class="fa-solid fa-house"></i>

                    </a>
                    <br>
                    <a href="employeestatus.php" class="inventory-link">
                        <span class="nav-item">Update Employee Status</span>
                        <i class="fa-solid fa-user-tie"></i>

                    </a>
                    <a href="deleteemployee.php" class="inventory-link">
                        <span class="nav-item">Delete Employee Account</span>
                        <i class="fa-solid fa-trash"></i>

                    </a>
                    <a href="changepassword.php" class="inventory-link">
                        <span class="nav-item">Change Password</span>
                        <i class="fa-solid fa-lock"></i>

                    </a>
                </div>
                <?php
                $ongoingqeury = "select * from employee";
                $ongoingresult = pg_query($conn, $ongoingqeury);
                ?>

                <br>
                <h2 align="center">Employees</h2>
                <table class="table table-bordered text-center">
                    <tr>
                        <td>Employee ID</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Status</td>
                    </tr>
                    <tr>
                        <?php

                        while ($row = pg_fetch_assoc($ongoingresult))
                        {
                        ?>
                        <td><?php echo $row['employee_id'] ?></td>
                        <td><?php echo $row['first_name'] ?></td>
                        <td><?php echo $row['last_name'] ?></td>
                        <td><?php echo $row['type'] ?></td>
                    </tr>
                    <?php
                    }
                    ?>

                </table>

            </div>


        <div>
            <h2 id="errors"> <?php echo $message; ?></h2>

            <div>
                <h2 align="center">Register Employee</h2>
                <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label for="first_name">First name:</label>
                        <input class="form-control" value="<?php $first_name ?>" name="first_name"
                               placeholder="Enter first name" type="text">

                    </div>
                    <div class="form-group">
                        <label for="last_name">Last name:</label>
                        <input class="form-control" value="<?php $last_name ?>" name="last_name"
                               placeholder="Enter last name" type="text">

                    </div>
                    <div class="form-group">
                        <label for="last_name">Password:</label>
                        <input class="form-control" value="<?php $password ?>" name="password"
                               placeholder="Enter a password" type="password">

                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirm Password:</label>
                        <input class="form-control" value="<?php $confirmpassword ?>" name="confirmpassword"
                               placeholder="Confirm password" type="password">

                    </div>
                    <div class="form-group">
                        <label for="phonenumber">Phone Number:</label>
                        <input class="form-control" value="<?php $phonenumber ?>" name="phonenumber"
                               placeholder="Enter Phone Number" type="text">

                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input class="form-control" value="<?php $address ?>" name="address"
                               placeholder="Enter address"
                               type="text">

                    </div>
                    <div class="form-group">
                        <label for="manager">Status of employee</label>
                        <input class="form-control" value="<?php $is_manager ?>" name="manager"
                               placeholder="'M' or 'E'"
                               type="text">

                    </div>

                    <button class="btn btn-primary" type="submit">Add Employee</button>
                </form>


            </div>
        </div>
    </div>
    </div>
    </div>

<?php include './includes/footer.php';