<?php include './includes/header.php'; ?>
<?php

if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $email_address = "";
    $message = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_address = trim($_POST['email_address']);


    $query = "SELECT * FROM repair where client_email =  '$email_address' ";


    $search_result = filterTable($query);
    ?>
    <div class="main-content">
    <div class="container">
        <div width="400">

            <style>
                table, tr, th, td {
                    border: 1px solid black;
                }
            </style>

            <h3>All Repairs</h3>
            <table>

                <tr>
                    <th>Repair ID</th>
                    <th>Employee ID</th>
                    <th>Console</th>
                    <th>Repair Date</th>
                    <th>Repair Status</th>
                    <th>Client Email</th>
                </tr>
                <?php while ($row = pg_fetch_array($search_result)): ?>
                    <tr>
                        <td><?php echo $row['repair_id']; ?></td>
                        <td><?php echo $row['employee_id']; ?></td>
                        <td><?php echo $row['console']; ?></td>
                        <td><?php echo $row['repair_date']; ?></td>
                        <td><?php echo $row['repair_status']; ?></td>
                        <td><?php echo $row['client_email']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>

        </div>
    </div>

    <?php
}
?>


    <div class="main-content">
        <div class="container">
            <div width="400">

                <div>
                    <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

                        <div class="form-group">
                            <h1>Search Reapair Page</h1>
                            <label for="email_address">Search repair based on client:</label>
                            <input class="form-control" value="<?php $email_address ?>" name="email_address"
                                   placeholder="Enter client email" type="email">

                            <button class="btn btn-primary" type="submit">Search Repair</button>
                    </form>
                </div>
                <a href="repair.php" class="inventory-link">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="nav-item">Back to Repairs</span>
                </a>
            </div>
        </div>
    </div>
    </div>




<?php include './includes/footer.php';


?>