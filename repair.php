<?php include './includes/header.php'; ?> 
<?php

if(! isset($_SESSION['employee_id'])) 
{
	Header("Location: login.php");
}
$qty = 1;
$message = "";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $employee_id = 0;
        $email_address = "";
        $console = "";
        $price = 0;
        $prodid = 0;
       
        
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $employee_id = trim($_POST['employee_id']);
        $email_address = trim($_POST['email_address']);
        $console = trim($_POST['console']);
        $price = trim($_POST['price']);
        $prodid = trim($_POST['productid']);
     
        
        
        
        //error checking
        $valid = true;
        if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            $valid = false;
            $message = "Client email not formatted correctly";
        }
      
        if(!isset($price)){
            $message ="The price of repair is required";
            $price = "";
            $valid = false;
        }
        if(!isset($console)||trim($console)==""){
            $message ="The name of console is required";
            $console = "";
            $valid = false;
        }
        if(!is_numeric($prodid)){
            $message = "Product ID must be a number";
            $prodid = "";
            $valid = false;
            
            }
            else{
                $query2 = pg_query($conn,"SELECT * FROM  product WHERE product_id= '$prodid'");
                if(pg_num_rows($query2)>0)
                {
                  
                    $message = "Product ID entered already exists";
                    $valid = false;
                }
            }
        if(!is_numeric($employee_id)){
                $message = "Employee ID is required";
                $valid = false;
                
            }
       else{
        $query = pg_query($conn,"SELECT * FROM  employee WHERE employee_id= '$employee_id'");
        if(!(pg_num_rows($query)>0))
        {
           
            $message = "Employee ID does not exist";
            $valid = false;
        }
       }
       $query3 = pg_query($conn,"SELECT * FROM  client WHERE client_email= '$email_address'");
       if(! pg_num_rows($query3)>0)
       {
         
           $message = "Client Email entered does not exist";
           $valid = false;
       }
        
    
        $date = date("Y-m-d");
        
        $sql = "INSERT INTO repair (employee_id,console,repair_date,repair_status,client_email,repair_price)";
        $sql .= "VALUES ('$employee_id','$console','$date','ongoing','$email_address','$price')";
        $sql2 = "INSERT INTO transactions (date,transaction_type,price)";
        $sql2 .= "VALUES ('$date','+','$price')"; 
        $sql3 = "INSERT INTO product (product_id,name_of_product,product_type,price)";
        $sql3 .= "VALUES ('$prodid','$console','console','$price')";
        $sql4 = "INSERT INTO invoice_item (product_id,order_date,item_qty)";
        $sql4 .= "VALUES ('$prodid','$date','$qty')";
     
    
        if ($valid) {
            if (pg_query($conn, $sql)) {
                if (pg_query($conn, $sql2)) {
                    if (pg_query($conn, $sql3)) {
                        if (pg_query($conn, $sql4)) {
                            $message = "The repair was successfully saved!";
                        }
                    }
                }
                
                
            } 
        }
    
    }
    ?>
    <div class="main-content">
        <div class="container">
            <div width="400">
            <h1><b>Console Repair Page</b></h1>
            <h2 id = "errors"> <?php echo $message; ?></h2>
  <div>
  <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <div class="form-group">
        <label for="employee_id">Employee ID:</label>
        <input class="form-control" value="<?php $employee_id ?>" name="employee_id" id="gametitle" placeholder="Enter Employee who assisted"  type="number">
    </div>


    <div class="form-group">
        <label for="email_address">Client Email:</label>
        <input class="form-control" value="<?php $email_address ?>" name="email_address" placeholder="Enter client email" type="email">
    </div>
    
    <div class="form-group">
        <label for="console">Console:</label>
        <input class="form-control" value="<?php $console ?>" name="console" placeholder="Enter console name" type="text">
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input class="form-control" value="<?php $employee_id ?>" name="price" placeholder="Enter price of repair" type="number" step="any">
    </div>
    <div class="form-group">
        <label for="productid">Product ID:</label>
        <input class="form-control" value="<?php $prodid ?>" name="productid" placeholder="Enter sequence of numbers" type="number">
    </div>

   

    <button class="btn btn-primary" type="submit">Save Repair</button>
</form>
</div>
 </div>
 
    
    <?php
    $ongoingqeury = "select * from repair WHERE repair_status= 'ongoing'";
    $ongoingresult = pg_query($conn,$ongoingqeury);
    ?>
   
      
                    
    
    
       <div>
        <h2>All ongoing repairs</h2>
         <table class="table table-bordered text-center">
        <tr>
            <td>Repair ID</td>
            <td>Employee ID</td>
            <td>Console Name</td>
            <td>Repair Start Date</td>
            <td>Client Email</td>
        </tr>
        <tr>
       <?php
    
        while($row = pg_fetch_assoc($ongoingresult))
        {
        ?>
        <td><?php echo $row['repair_id']?></td>
        <td><?php echo $row['employee_id']?></td>
        <td><?php echo $row['console']?></td>
        <td><?php echo $row['repair_date']?></td>
        <td><?php echo $row['client_email']?></td>
        </tr>
        <?php
        } 
       ?>
        
    </table>
</div>
        <div>
                <a href="deleterepair.php">
                        <span class="nav-item">Delete Repair</span>
                        <i class="fa-solid fa-arrow-right"></i>
                       
                    </a>
                    <br>
                     <a href="repairsearch.php">
                        <span class="nav-item">Search for repairs</span>
                        <i class="fa-solid fa-magnifying-glass"></i>
                       
                    </a>
                    </div>
        </div>
    </div>
    <?php include './includes/footer.php'; 
 

?>