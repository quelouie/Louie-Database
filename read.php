<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
	require_once 'config.php';
    
    
	$sql = "SELECT * FROM tblRegister WHERE id = ?";
    
    
	if($stmt = mysqli_prepare($conn, $sql)){

    	mysqli_stmt_bind_param($stmt, "i", $param_id);
   	 
    	$param_id = trim($_GET["id"]);   

    	if(mysqli_stmt_execute($stmt)){
        	$result = mysqli_stmt_get_result($stmt);
    
        	if(mysqli_num_rows($result) == 1){
   			 
            	$row = mysqli_fetch_array ($result, MYSQLI_ASSOC);
           	 
            	$name = $row["name"];
            	$pet = $row["pet"];
   			 $kind = $row["kind"];
   			 $con = $row["con"];
            	$period = $row["period"];
   			 $about = $row["about"];
        	} else{
            	header("location: error.php");
            	exit();
        	}
       	 
    	} else{
        	echo "Oops! Something went wrong. Please try again later.";
    	}
	}
	 
	mysqli_stmt_close($stmt);
    
	mysqli_close($conn);
} else{
	header("location: error.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>View Record</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
	<style type="text/css">
    	.wrapper{
        	width: 600px;
        	margin: 0 auto;
    	}
    	.page-header h2{
        	margin-top: 0;
    	}
    	table tr td:last-child a{
        	margin-right: 15px;
    	}
	</style>
	<script type="text/javascript">
    	$(document).ready(function(){
        	$('[data-toggle="tooltip"]').tooltip();   
    	});
	</script>
</head>
<body>
	<div class="wrapper">
    	<div class="container-fluid">
        	<div class="row">
            	<div class="col-md-12">
                	<div class="page-header">
                    	<h1>View Record</h1>
                	</div>
                	<div class="form-group">
                    	<label>Owner's Name</label>
                    	<p class="form-control-static"><?php echo $row["name"]; ?></p>
                	</div>
                	<div class="form-group">
                    	<label>Pet's Name</label>
                    	<p class="form-control-static"><?php echo $row["pet"]; ?></p>
                	</div>
                	<div class="form-group">
                    	<label>Kind of Pet</label>
                    	<p class="form-control-static"><?php echo $row["kind"]; ?></p>
                	</div>
   				 <div class="form-group">
                    	<label>Contact Number</label>
                    	<p class="form-control-static"><?php echo $row["con"]; ?></p>
                	</div>
                	<div class="form-group">
                    	<label>Period of Stay</label>
                    	<p class="form-control-static"><?php echo $row["period"]; ?></p>
                	</div>
                	<div class="form-group">
                    	<label>Special Request</label>
                    	<p class="form-control-static"><?php echo $row["about"]; ?></p>
                	</div>
                	<p><a href="index.php" class="btn btn-primary">Back</a></p>
            	</div>
        	</div>   	 
    	</div>
	</div>
</body>
</html>
