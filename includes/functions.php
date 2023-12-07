<?php
/*
Jashakan Shanmugathasan
September 27, 2021
WEBD3201
*/

//Function to redirect to another URL
function redirect($url){
	header("location:".$url);
	ob_flush();
}

function dump($arg){
	echo "<prev>";
	print_r($arg);
	echo "<prev>";
}

function display_form($form_inputs)
{
	?>
	<div>
	<form class="form-signin" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
	
	<input type="hidden" name="form2submission" value="yes" >
	<?php
	foreach($form_inputs as $input){	
	?>
		<label> <?php echo $input['label']; ?> </label> <br> 
		<input type= <?php echo $input['type']; ?>  name= <?php echo $input['name']; ?> value= <?php echo $input['value']; ?> > <br>
	<?php
	}
	?>
	<br>
	</div>
	
	
	</form>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
<?php

}

function setMessage($msg){
	// someone successfully logs in
	$_SESSION['message'] = $msg;
}

function getMessage(){
	return $_SESSION['message'];
}

function isMessage(){
	return isset($_SESSION['message'])?true:false; //conditional operator
}

function removeMessage(){
	unset($_SESSION['message']);
}

function flashMessage(){
	$message = "";
	  if(isset($_SESSION['message']))
	  {
		  $message = getMessage();
		  removeMessage();
	  }
	return $message;
}
function filterTable($query)
      {
          $conn = db_connect();
          $filter_Result = pg_query($conn, $query);
          return $filter_Result;
      }
	/*
	$output = "<form>";
	foreach($form_inputs as $input)
	{
		if(isset($input["label"]) && trim($input["label"]) != ""){
			$output .= "<label for =\"" . $input["name"]."\">".$input["label"]."</label>\n";
			unset($input["label"]);
		}
		$output .= "<input ";
		foreach($input as $property => $value)
		{
			$output .= $property . "=\"" . $value . "\" ";
		}
		$output .= " /><br/>\n";
	}
	$output .= "</form>";
	echo ($output);
	*/
	
?>
