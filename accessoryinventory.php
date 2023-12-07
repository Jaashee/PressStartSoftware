<?php include './includes/header.php'; ?>
<?php

if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $accessory_name = "";
    $message = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accessory_name = trim($_POST['name']);


    $query = "SELECT * FROM accessories where name =  '$accessory_name' ";


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

            <h3>All Accessories</h3>
            <table>

                <tr>
                    <th>Accessory ID</th>
                    <th>Accessory Name</th>
                    <th>Price</th>
                    <th>In stock</th>
                </tr>
                <?php while ($row = pg_fetch_array($search_result)): ?>
                    <tr>
                        <td><?php echo $row['accessories_id']; ?></td>
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
                            <h1>Search Accessory Inventory</h1>
                            <label for="accessory_name">Search inventory based on accessory:</label>
                            <input class="form-control" value="<?php $accessory_name ?>" name="name"
                                   placeholder="Enter Accessory Name" type="text">

                            <button class="btn btn-primary" type="submit">Search Accessory</button>
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