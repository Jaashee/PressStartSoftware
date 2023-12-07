<?php include './includes/header.php';


if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
} ?>
    <body class="inventory-page">
    <div class="main-content">
        <div class="inventory-container">
            <h1><strong>Inventory Page</h1>
            <div class="inventory-content">
                <h1 class="inventory-title"></h1>
                <div class="inventory-links">
                    <a href="gameinventory.php" class="inventory-link">Game Inventory</a>
                    <a href="consoleinventory.php" class="inventory-link">Console Inventory</a>
                    <a href="accessoryinventory.php" class="inventory-link">Accessories Inventory</a>
                </div>
            </div>
        </div>
    </div>
    </body>

<?php include './includes/footer.php';