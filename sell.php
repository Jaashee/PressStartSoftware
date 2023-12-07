<?php include './includes/header.php'; ?>
<?php
if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
}

?>
<div class="main-content">
    <div class="container">
        <a href="sellgame.php" class="inventory-link">
            <span class="nav-item">Game Sell</span>
            <i class="fas fa-gamepad"></i>

        </a>
        <br>
        <a href="sellconsole.php" class="inventory-link">
            <span class="nav-item">Console Sell</span>
            <i class="fas fa-tv"></i>

        </a>
        <br>
        <a href="sellaccessory.php" class="inventory-link">
            <span class="nav-item">Accessory Sell</span>
            <i class="fas fa-headphones"></i>

        </a>
    </div>
</div>

<?php include './includes/footer.php';

?>
 