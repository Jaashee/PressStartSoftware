<?php

include "./includes/header.php";
?>

<?php
$message = "";
$qty = 1;
if (!isset($_SESSION['employee_id'])) {
    Header("Location: login.php");
}


$qty = 1;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $accessoryid = 0;
    $price = 0;
    $type = 0;
    $title = 0;
    $prodid = "";


} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accessoryid = trim($_POST['accessoryid']);
    $price = trim($_POST['price']);
    $type = trim($_POST['type']);
    $title = trim($_POST['title']);
    $prodid = trim($_POST['productid']);


    // Validate the form data
    $valid = true;
    $return = false;
    $sell = false;


    if (!is_numeric($accessoryid)) {
        $message = "Accessory ID must be a number";
        $prodid = "";
        $valid = false;

    } else {
        $query = pg_query($conn, "SELECT * FROM  accessories WHERE accessories_id= '$accessoryid'");
        if (!pg_num_rows($query) > 0) {
            $message = "Accessory ID does not exist";
            $valid = false;
        }
    }

    if (!is_numeric($prodid)) {
        $message = "Product ID must be a number";
        $prodid = "";
        $valid = false;

    } else {
        $query = pg_query($conn, "SELECT * FROM  product WHERE product_id= '$prodid'");
        if (pg_num_rows($query) > 0) {
            $message = "Product ID already exist";
            $valid = false;
        }
    }
    if (!isset($type) || trim($type) == "") {
        $message = "Type of sell is required";

        $valid = false;
    }
    if (!isset($price)) {
        $message = "Price of game is required";

        $valid = false;
    }
    if (!isset($title)) {
        $message = "Title is required";

        $valid = false;
    }
    if (!isset($prodid)) {
        $message = "Product ID is required";

        $valid = false;
    }
    if (!is_numeric($prodid)) {
        $message = "Product ID must be numeric";
        $valid = false;

    }
    if (!is_numeric($accessoryid)) {
        $message = "Accessory ID must be numeric";
        $valid = false;

    }
    if (!($type == 'Return' || $type == 'Sell')) {
        $message = "Type can only be 'Return' - 'Sell''";
        $valid = false;
    }

    if ($type == 'Return') {
        $return = true;
    }
    if ($type == 'Sell') {
        $sell = true;
    }


    $date = date("Y-m-d");

    $returngamesql = "UPDATE accessories";
    $returngamesql .= " SET in_stock = ('Yes')";
    $returngamesql .= " WHERE accessories_id = $accessoryid";
    $returntransaction = "INSERT INTO transactions (date,transaction_type,price)";
    $returntransaction .= "VALUES ('$date','-','$price')";
    $returnproduct = "INSERT INTO product (product_id,name_of_product,product_type,price)";
    $returnproduct .= "VALUES ('$prodid','$title','accessory','$price')";
    $returninvoice = "INSERT INTO invoice_item (product_id,order_date,item_qty)";
    $returninvoice .= "VALUES ('$prodid','$date','$qty')";

    $sellgamesql = "UPDATE accessories";
    $sellgamesql .= " Set in_stock = 'No'";
    $sellgamesql .= " WHERE accessories_id = $accessoryid";
    $selltransaction = "INSERT INTO transactions (date,transaction_type,price)";
    $selltransaction .= "VALUES ('$date','+','$price')";
    $sellproduct = "INSERT INTO product (product_id,name_of_product,product_type,price)";
    $sellproduct .= "VALUES ('$prodid','$title','accessory','$price')";
    $sellinvoice = "INSERT INTO invoice_item (product_id,order_date,item_qty)";
    $sellinvoice .= "VALUES ('$prodid','$date','$qty')";


    //for returns
    if ($valid) {
        if ($return) {
            if (pg_query($conn, $returngamesql)) {
                if (pg_query($conn, $returntransaction)) {
                    if (pg_query($conn, $returnproduct)) {
                        if (pg_query($conn, $returninvoice)) {
                            $message = "The accessory was successfully returned!";
                        }
                    }
                }


            }
        }
    }

    if ($valid) {
        if ($sell) {
            if (pg_query($conn, $sellgamesql)) {
                if (pg_query($conn, $selltransaction)) {
                    if (pg_query($conn, $sellproduct)) {
                        if (pg_query($conn, $sellinvoice)) {
                            $message = "The acessory was successfully sold!";
                        }
                    }
                }


            }
        }
    }


}
?>
<div class="main-content">
    <div class="sell-console-container">
        <h1 class="sell-console-title">Sell Accessory Page</h1>
        <h2 id="errors"> <?php echo $message; ?></h2>
        <form class="buy-form">
            <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <div class="form-group">
                    <label for="accessoryid">Acessory ID:</label>
                    <input class="form-control" name="accessoryid" placeholder="Enter Accessory ID" type="number">
                </div>
                <div class="form-group">
                    <label for="title">Name of console:</label>
                    <input class="form-control" name="title" placeholder="Enter Name of acessory" type="text">
                </div>
                <div class="form-group">
                    <label for="dob">Price:</label>
                    <input class="form-control" name="price" placeholder="Enter Price of transaction" type="number"
                           step="any">
                </div>
                <div class="form-group">
                    <label for="adsress">Return or Sell?:</label>
                    <input class="form-control" name="type" placeholder="'Return' - 'Sell'" type="text">
                </div>
                <div class="form-group">
                    <label for="productid">Product ID:</label>
                    <input class="form-control" name="productid" placeholder="Enter sequence of numbers" type="number">
                </div>


                <button class="btn btn-primary" type="submit">Process</button>
            </form>
        </form>
    </div>
</div>


<?php
include "./includes/footer.php";
?> 