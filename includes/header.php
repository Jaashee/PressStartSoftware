<?php
 
session_start();
require( "functions.php" );
require( "constants.php" );
require( "db.php" );
header('Content-Type: text/html; charset=utf-8');


 
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>Press Start - Application</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./node_modules/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="./content/styles.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:400,700&display=swap" rel="stylesheet">


</head>
<body>
<div class="sidebar">
    <div class="top">
        <div class="logo">
        </div>
        <i class="fa-solid fa-bars" id="btn"></i>
        <div class="pressstart">
            <img alt="name" class="pressstart" src="./content/pressstart.webp">
        </div>
        <ul>
            <li>
                <a href="index.php">
                    <i class="fas fa-user"></i>
                    <span class="nav-item">Employee</span>
                </a>
                <span class="tooltip">Employee</span>
            </li>
            <li>
                <a href="inventory.php">
                    <i class="fas fa-boxes"></i>
                    <span class="nav-item">Inventory</span>
                </a>
                <span class="tooltip">Inventory</span>
            </li>
            <li>
                <a href="client.php">
                    <i class="fas fa-users"></i>
                    <span class="nav-item">Client</span>
                </a>
                <span class="tooltip">Client</span>
            </li>
            <li>
                <a href="buy.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="nav-item">Buy</span>
                </a>
                <span class="tooltip">Buy</span>
            </li>
            <li>
                <a href="sell.php">
                    <i class="fas fa-money-bill-wave"></i>
                    <span class="nav-item">Sell/Returns</span>
                </a>
                <span class="tooltip">Sell/Returns</span>
            </li>
            <li>
                <a href="repair.php">
                    <i class="fas fa-tools"></i>
                    <span class="nav-item">Repairs</span>
                </a>
                <span class="tooltip">Repairs</span>
            </li>
           
            
                <?php 
                if ( isset( $_SESSION[ 'employee_id' ] ) ) {

               echo '<li><a href="logout.php">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="nav-item">Logout</span>
                </a>
                <span class="tooltip">Logout</span></li>';
                }
                else{
                    echo '<li><a href="login.php">
                    <i class="fas fa-sign-in-alt"></i>
                         <span class="nav-item">Login</span>
                     </a>
                     <span class="tooltip">Login</span></li>';
                }
                ?>

        </ul>
    </div>
</div>