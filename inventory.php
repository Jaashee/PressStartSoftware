<?php include './includes/header.php';


if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
} ?>
    <div class="main-content">
        <div class="container">
            <h1>Inventory Page</h1>
            <div>
                <a href="gameinventory.php">
                    <span class="nav-item">Game Inventory</span>
                    <i class="fa-solid fa-arrow-right"></i>

                </a>
                <br>
                <a href="consoleinventory.php">
                    <span class="nav-item">Console Inventory</span>
                    <i class="fa-solid fa-arrow-right"></i>

                </a>
                <br>
                <a href="accessoryinventory.php">
                    <span class="nav-item">Accessories inventory</span>
                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>

        </div>
    </div>


<?php include './includes/footer.php';