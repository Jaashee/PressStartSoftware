<?php

include "./includes/header.php";
?>

<?php
$message = "";
$qty = 1;
if(! isset($_SESSION['employee_id'])) 
{
	Header("Location: login.php");
}


$qty = 1;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$gameid = 0;
	$price = 0;
    $type  =0;
    $title = 0;
    $prodid = "";
	

}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$gameid = trim($_POST['gameid']);
	$price = trim($_POST['price']);
    $type = trim($_POST['type']);
    $title = trim($_POST['title']);
    $prodid= trim($_POST['productid']);


	// Validate the form data
	$valid = true;
    $return = false;
    $sell = false;
	

    if (!is_numeric($gameid)) {
        $message = "Repair ID must be a number";
        $prodid = "";
        $valid = false;

    } else {
        $query = pg_query($conn, "SELECT * FROM  games WHERE game_id= '$gameid'");
        if (!pg_num_rows($query) > 0) {
            $message = "Game ID does not exist";
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
	if(!isset($type)||trim($type)==""){
		$message ="Type of sell is required";
	
		$valid = false;
	}
	if(!isset($price)){
		$message ="Price of game is required";
	
		$valid = false;
	}
    if(!isset($title)){
		$message ="Title is required";
	
		$valid = false;
	}
	if(!isset($prodid)){
		$message ="Product ID is required";
	
		$valid = false;
	}
    if(!is_numeric($prodid)){
        $message = "Product ID must be numeric";
        $valid = false;
        
    }
    if(!is_numeric($gameid)){
        $message = "Game ID must be numeric";
        $valid = false;
        
    }
    if(!($type == 'Return'|| $type == 'Sell')){
		$message ="Type can only be 'Return' - 'Sell''";
		$valid = false;
	}

    if($type == 'Return'){
		$return = true;
	}
    if($type == 'Sell'){
		$sell = true;
	}
  

    $math = 0;
    if (is_numeric($price))
    {
        $math = $price * 0.80;
    }
    


   
    $date = date("Y-m-d");

        $returngamesql = "UPDATE games";
        $returngamesql .= " SET in_stock = ('Yes')";
        $returngamesql .= " WHERE game_id = $gameid";
        $returntransaction = "INSERT INTO transactions (date,transaction_type,price)";
        $returntransaction .= "VALUES ('$date','-','$price')"; 
        $returnproduct = "INSERT INTO product (product_id,name_of_product,product_type,price)";
        $returnproduct .= "VALUES ('$prodid','$title','game','$price')";
        $returninvoice = "INSERT INTO invoice_item (product_id,order_date,item_qty)";
        $returninvoice .= "VALUES ('$prodid','$date','$qty')";

        $sellgamesql = "UPDATE games";
        $sellgamesql .= " Set in_stock = 'No'";
        $sellgamesql .= " WHERE game_id = $gameid";
        $selltransaction = "INSERT INTO transactions (date,transaction_type,price)";
        $selltransaction .= "VALUES ('$date','+','$price')"; 
        $sellproduct = "INSERT INTO product (product_id,name_of_product,product_type,price)";
        $sellproduct .= "VALUES ('$prodid','$title','game','$price')";
        $sellinvoice = "INSERT INTO invoice_item (product_id,order_date,item_qty)";
        $sellinvoice .= "VALUES ('$prodid','$date','$qty')";



	
	//for returns
        if ($valid) {
        if($return){
            if (pg_query($conn, $returngamesql)) {
                if (pg_query($conn, $returntransaction)) {
                    if (pg_query($conn, $returnproduct)) {
                        if (pg_query($conn, $returninvoice)) {
                            $message = "The game was successfully returned!";
                        }
                    }
                }
                
                
            } 
        }
    }

    if ($valid) {
        if($sell){
            if (pg_query($conn, $sellgamesql)) {
                if (pg_query($conn, $selltransaction)) {
                    if (pg_query($conn, $sellproduct)) {
                        if (pg_query($conn, $sellinvoice)) {
                            $message = "The game was successfully sold!";
                        }
                    }
                }
                
                
            } 
        }
    }
	

}
?>
<div class="main-content">

    <div class="container">
        <h1><b>Sell Game Page</b></h1>
		<h2 id = "errors"> <?php echo $message; ?></h2>
        
 <form  method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
 <div class="form-group">
	 <label for="gameid">Game ID:</label>
	 <input class="form-control" name="gameid"  placeholder="Enter Game ID" type="number">
 </div>
 <div class="form-group">
	 <label for="title">Title:</label>
	 <input class="form-control" name="title"  placeholder="Enter Title of game" type="text">
 </div>
 <div class="form-group">
	 <label for="dob">Price:</label>
	 <input class="form-control" name="price"  placeholder="Enter Price of transaction" type="number" step="any">
 </div>
 <div class="form-group">
	 <label for="adsress">Return or Sell?:</label>
	 <input class="form-control" name="type"  placeholder="'Return' - 'Sell'" type="text">
 </div>
 <div class="form-group">
        <label for="productid">Product ID:</label>
        <input class="form-control" name="productid" placeholder="Enter sequence of numbers" type="number">
    </div>
 
 
 

 <button class="btn btn-primary" type="submit">Process</button>
</form>

<a href="https://www.pricecharting.com/" target="_blank">
  <button class="btn btn-primary" type="button">Online Market</button>
</a>
   
    </div>
</div>






<?php
include "./includes/footer.php";
?> 