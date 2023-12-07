<?php include './includes/header.php'; ?>
<?php

if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $name = "";
    $message = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);


    $query = "SELECT * FROM console where name =  '$name' ";


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

            <h3>All Consoles</h3>
            <table>

                <tr>
                    <th>Console ID</th>
                    <th>Console Name</th>
                    <th>Price</th>
                    <th>In stock</th>
                </tr>
                <?php while ($row = pg_fetch_array($search_result)): ?>
                    <tr>
                        <td><?php echo $row['console_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['in_stock']; ?></td>
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
                            <h1>Search Console Inventory</h1>
                            <label for="console_name">Search inventory based on console:</label>
                            <input class="form-control" value="<?php $console_name ?>" name="name"
                                   placeholder="Enter Console Name" type="text">

                            <button class="btn btn-primary" type="submit">Search Console</button>
                    </form>
                </div>
                <a href="inventory.php" class="inventory-link">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="nav-item">Back to Inventory</span>
                </a>
            </div>
            </div>
        </div>
    </div>




<?php include './includes/footer.php';


?>