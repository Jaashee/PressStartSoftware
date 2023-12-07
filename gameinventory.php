<?php include './includes/header.php'; ?>
<?php

if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
}
$game_name = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $game_name = "";
    $message = "";

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $game_name = trim($_POST['game_name']);


    $query = "SELECT * FROM games where title =  '$game_name' ";


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

            <h3>All Games</h3>
            <table>

                <tr>
                    <th>Game ID</th>
                    <th>Game Title</th>
                    <th>Price</th>
                    <th>Condition</th>
                    <th>Platform</th>
                    <th>Sold?</th>
                </tr>
                <?php while ($row = pg_fetch_array($search_result)): ?>
                    <tr>
                        <td><?php echo $row['game_id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['condition']; ?></td>
                        <td><?php echo $row['platform']; ?></td>
                        <td><?php echo $row['is_sold']; ?></td>
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
                            <h1>Search Game Inventory</h1>
                            <label for="game_title">Search inventory based on game:</label>
                            <input class="form-control" value="<?php $game_name ?>" name="game_name"
                                   placeholder="Enter Game Title" type="text">

                            <button class="btn btn-primary" type="submit">Search Game</button>
                    </form>
                </div>
                <a href="inventory.php">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="nav-item">Back to Inventory</span>


                </a>


            </div>
        </div>
    </div>

    </div>



<?php include './includes/footer.php';


?>