<?php
  require_once('../private/initialize.php');
	

  // Set default values for all variables the page needs.
  $first_name = '';
  $last_name = '';
  $email = '';
  $username = '';
	
	
  // if this is a POST request, process the form
  // Hint: private/functions.php can help
    // Confirm that POST values are present before accessing them.
	if (isset($_POST['submit'])){
		require_once('../private/functions.php');
		$first_name = h($_POST['first_name']); 
		$last_name = h($_POST['last_name']); 
		$email = h($_POST['email']); 
		$username = h($_POST['username']); 
		
	    // Perform Validations
    	// Hint: Write these in private/validation_functions.php
		require_once('../private/validation_functions.php');
		$first_name_blank = is_blank($first_name);
		$last_name_blank = is_blank($last_name);
		$email_blank = is_blank($email);
		$username_blank = is_blank($username);
	
		$first_name_length = has_length($first_name, ['min' => 2, 'max' => 255]);
		$last_name_length = has_length($last_name, ['min' => 2, 'max' => 255]);
		$email_length = has_length($email, ['min' => 8, 'max' => 255]);
		$username_length = has_length($username, ['min' => 8, 'max' => 255]);
		$valid_first_name = has_valid_name($first_name);
		$valid_last_name  = has_valid_name($last_name);
		$valid_username = has_valid_username($username);
		$valid_email = has_valid_email_format($email);
		$username_check = "SELECT * FROM users WHERE username = '$username';";
		$username_exists = db_query($db, $username_check);

		$success = true;
		$errorList = array();
	
		if($first_name_blank){
			$success = false;
			array_push($errorList,"First name must have a value.");
		}  elseif($first_name_length==false){
			$success = false;
			array_push($errorList,"First name must be between 2 to 255 characters.");
		} elseif($valid_first_name==false){
			$success = false;
			array_push($errorList,"First name must be in a valid format.");
		}
		
		if($last_name_blank){
			$success = false;
			array_push($errorList,"Last name must have a value.");
		} elseif($last_name_length==false){
			$success = false;
			array_push($errorList,"Last name must be between 2 to 255 characters.");
		} elseif($valid_last_name==false){
			$success = false;
			array_push($errorList,"Last name must be in a valid format.");
		}
		
		if($email_blank){
			$success = false;
			array_push($errorList,"Email must have a value.");
		} elseif($email_length==false){
			$success = false;
			array_push($errorList,"Email must be between 8 to 255 characters.");
		} elseif($valid_email==false){
			$success = false;
			array_push($errorList,"Email must be in a valid format.");
		}
		
		if($username_blank){
			$success = false;
			array_push($errorList,"Username must have a value.");
		} elseif($username_length==false){
			$success = false;
			array_push($errorList,"Username must be between 8 to 255 characters.");
		} elseif($valid_username==false){
			$success = false;
			array_push($errorList,"Username name must be in a valid format.");
		} elseif(mysqli_num_rows($username_exists)==1){
      		$success = false;
			array_push($errorList,"The username you entered already exists.");
      	}
      	
    	// if there were no errors, submit data to database
		if($success){
		
      		// Write SQL INSERT statement
       		$created = date("Y-m-d H:i:s");
       		$sql = "INSERT INTO users (first_name,last_name,email,username,created_at)
			VALUES ('$first_name','$last_name','$email','$username','$created');";
			
      		// For INSERT statments, $result is just true/false
      		 $result = db_query($db, $sql);
      		 if($result) {
      		    db_close($db);

      		//   TODO redirect user to success page
  			 if($result) {
    			redirect_to('registration_success.php');
  		      }else {
      			  // The SQL INSERT statement failed.
      		     // Just show the error, not the form
      			 echo db_error($db);
      			 db_close($db);
      		//   exit;
      		}
      		}
      	} // end validation success check
	}//end code to check to check for post value
	
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
	if (isset($_POST['submit'])){
		if($success==false){
			$getList = display_errors($errorList);
			echo $getList;
		}
	}
	
  ?>
  
  <!-- TODO: HTML form goes here -->
 
  <form action="register.php" method="post">
  	<p>
  		First name:<br />
  		<input type="text" name="first_name" id="first_name"  
  		value="<?php echo $first_name ?>" /><br />
  		Last name:<br />
  		<input type="text" name="last_name" id="last_name"
  		 value="<?php echo $last_name ?>" /><br />
		Email:<br />
		<input type="text" name="email" id="email"		
		value="<?php echo $email ?>" /><br />
		Username:<br />
		<input type="text" name="username" id="username"
		value="<?php echo $username ?>" /><br />
		<br /> 
		<input type="submit" value="Submit" name="submit" id="submit" />
  	</p>
  </form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
