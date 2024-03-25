<?php
require_once 'config.php';
 
$nameErr = $petErr = $kindErr = $conErr= $periodErr = $aboutErr = "";
$name = $pet = $kind = $con = $period =  $about = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$input_name = trim($_POST["name"]);
	if(empty($input_name)){
    	$nameErr = "Please enter a name.";
	} elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
    	$nameErr = 'Please enter a valid name.';
	} else{
    	$name = $input_name;
	}
    
	$input_pet = trim($_POST["pet"]);
	if(empty($input_pet)){
    	$petErr = 'Please enter your pet name.';	 
	} else{
    	$pet = $input_pet;
	}
    
    $input_kind = trim($_POST["kind"]);
	if(empty($input_kind)){
    	$kindErr = 'Please enter your pets breed.';	 
	} else{
    	$kind = $input_kind;
	}
    
	$input_con = trim($_POST["con"]);
	if(empty($input_con)){
    	$conErr = "Please enter your contact number";	 
	}else {
    	$con = $input_con;
	}
    
    $input_period = trim($_POST["period"]);
	if(empty($input_period)){
    	$periodErr = 'Please enter the period of stay.';	 
	} else{
    	$period = $input_period;
	}
    
    $input_about = trim($_POST["about"]);
	if(empty($input_about)){
    	$aboutErr = 'Please enter your request for your pet.';	 
	} else{
    	$about = $input_about;
	}
	if(empty($nameErr) && empty($petErr) && empty($kindErr) && empty($conErr) && empty($periodErr) && empty($aboutErr)){
    	$sql = "INSERT INTO tblRegister (name, pet, kind, con, period, about) VALUES (?, ?, ?, ?, ?, ?)";
    	 
    	 
    	if($stmt = mysqli_prepare($conn, $sql)){
        	mysqli_stmt_bind_param($stmt, "sssiss", $param_name, $param_pet, $param_kind, $param_con, $param_period, $param_about);
       	 
        	$param_name = $name;
        	$param_pet = $pet;
        	$param_kind = $kind;
   		 $param_con = $con;
        	$param_period = $period;
        	$param_about = $about;
       	 
        	if(mysqli_stmt_execute($stmt)){
            	header("location: index.php");
            	exit();
        	} else{
            	echo "Reservation not confirmed. Something went wrong. Please try again later.";
        	}
    	}
    	 
    	mysqli_stmt_close($stmt);
	}
    
	// Close connection
	mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create Record</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<style type="text/css">
    	.wrapper{
        	width: 500px;
        	margin: 0 auto;
    	}
	</style>
</head>
<body>
	<div class="wrapper">
    	<div class="container-fluid">
        	<div class="row">
            	<div class="col-md-12">
                	<div class="page-header">
                    	<h2> Petgistration </h2>
                	</div>
                	<p>Please fill this form and submit to reserve a stay for your pet</p>
                	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    	<div class="form-group <?php echo (!empty($nameErr)) ? 'has-error' : ''; ?>">
                        	<label>Owner's Name</label>
                        	<input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                        	<span class="help-block"><?php echo $nameErr;?></span>
                    	</div>
                    	<div class="form-group <?php echo (!empty($petErr)) ? 'has-error' : ''; ?>">
                        	<label>Pet's Name </label>
                        	<textarea name="pet" class="form-control"><?php echo $pet; ?></textarea>
                        	<span class="help-block"><?php echo $petErr;?></span>
                    	</div>
   					  <div class="form-group <?php echo (!empty($kindErr)) ? 'has-error' : ''; ?>">
                        	<label>Kind of Pet </label>
                        	<textarea name="kind" class="form-control"><?php echo $kind; ?></textarea>
                        	<span class="help-block"><?php echo $kindErr;?></span>
                    	</div>
                    	<div class="form-group <?php echo (!empty($conErr)) ? 'has-error' : ''; ?>">
                        	<label>Contact Number</label>
                        	<input type="text" name="con" class="form-control" value="<?php echo $con; ?>">
                        	<span class="help-block"><?php echo $conErr;?></span>
                    	</div>
   					 <div class="form-group <?php echo (!empty($periodErr)) ? 'has-error' : ''; ?>">
                        	<label>Period of Stay</label>
                        	<input type="text" name="period" class="form-control" value="<?php echo $period; ?>">
                        	<span class="help-block"><?php echo $periodErr;?></span>
                    	</div>
                    	<div class="form-group <?php echo (!empty($aboutErr)) ? 'has-error' : ''; ?>">
                        	<label>Special Request</label>
                        	<textarea name="about" class="form-control"><?php echo $about; ?></textarea>
                        	<span class="help-block"><?php echo $aboutErr;?></span>
                    	</div>
                    	<input type="submit" class="btn btn-primary" value="Submit">
                    	<a href="index.php" class="btn btn-default">Cancel</a>
                	</form>
            	</div>
        	</div>   	 
    	</div>
	</div>
</body>
</html>
