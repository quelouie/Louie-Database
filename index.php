<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pet Boarding Booking System</title>
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
                	<div class="page-header clearfix">
						
                    	<a href="create.php" class="btn btn-success pull-right">Make a Reservation</a>
						<h4> Pet Boarding Center Booking System </h4>
                	</div>
<?php
require_once 'config.php';
          	 
$sql = "SELECT * FROM tblRegister";
    if($result = mysqli_query($conn, $sql)){
    	if(mysqli_num_rows($result) > 0){
        	echo "<table class='table table-bordered table-striped table-hover'>";
   		 
        	echo "<tr class='info'>";
        	echo "<th>ID</th>";
        	echo "<th>Owner's Name</th>";
        	echo "<th>Pet's Name</th>";
        	echo "<th>Kind of Pet</th>";
   		 echo "<th>Contact</th>";
        	echo "<th>Period of Stay</th>";
        	echo "<th>Special Request</th>";
        	echo "<th>Action</th>";
        	echo "</tr>";

        	while($row = mysqli_fetch_array($result)){
        	echo "<tr>";
        	echo "<td>" . $row['id'] . "</td>";
        	echo "<td>" . $row['name'] . "</td>";
        	echo "<td>" . $row['pet'] . "</td>";
        	echo "<td>" . $row['kind'] . "</td>";
   		 echo "<td>" . $row['con'] . "</td>";
        	echo "<td>" . $row['period'] . "</td>";
        	echo "<td>" . $row['about'] . "</td>";
        	echo "<td>";
   		 
        	echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
        	echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
   		 
        	echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
       	 
   		 echo "</td>";
        	echo "</tr>";
        	}
                             	 
        	echo "</table>";
       	 
        	mysqli_free_result($result);
        	} else{
                	echo "<p class='lead'><em>No records were found.</em></p>";
                    	}
                	} else{
                    	echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                	}

                	mysqli_close($conn);
                	?>
            	</div>
        	</div>   	 
    	</div>
	</div>
</body>
</html>
