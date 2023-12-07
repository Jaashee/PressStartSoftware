<?php include './includes/header.php'; ?>
<?php
if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
}

?>
<div class="main-content">
    <div class="container">
        <a href="sellgame.php">
            <span class="nav-item">Game Sell</span>
            <i class="fa-solid fa-house"></i>

        </a>
        <br>
        <a href="employeestatus.php">
            <span class="nav-item">Console Sell</span>
            <i class="fa-solid fa-user-tie"></i>

        </a>
        <br>
        <a href="deleteemployee.php">
            <span class="nav-item">Accessory Sell</span>
            <i class="fa-solid fa-trash"></i>

        </a>
    </div>
</div>

<?php include './includes/footer.php';

?>
 