<?php
require_once 'config.php';

// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$nameErr = $petErr = $kindErr = $conErr= $periodErr = $aboutErr = "";
$name = $pet = $kind = $con = $period =  $about = "";

if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
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
    } else{
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
    
    // Check for validation errors
    if(empty($nameErr) && empty($petErr) && empty($kindErr) && empty($conErr) && empty($periodErr) && empty($aboutErr)){

        // SQL query for updating record
        $sql = "UPDATE tblregister SET name=?, pet=?, kind=?, con=?, period=?, about=? WHERE id=?";
         
        // Prepare statement
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_name, $param_pet, $param_kind, $param_con, $param_period, $param_about, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_pet = $pet;
            $param_kind = $kind;
            $param_con = $con;
            $param_period = $period;
            $param_about = $about;
            $param_id = $id;
            
            // Execute the statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to index page after successful update
                header("location: index.php");
                exit();
            } else{
                // Display error if update fails
                echo "Something went wrong. Please try again later.";
            }
        } else {
            // Display error if prepare statement fails
            echo "Error: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else {
    // Fetch data for pre-populating form fields
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);

        $sql = "SELECT * FROM tblRegister WHERE id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $name = $row["name"];
                    $pet = $row["pet"];
                    $kind = $row["kind"];
                    $con = $row["con"];
                    $period = $row["period"];
                    $about = $row["about"];
                } else {
                    // Redirect to error page if no records found
                    header("location: error.php");
                    exit();
                }
                
            } else {
                // Error handling for statement execution
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close ($conn);
    } else {
        // Redirect to error page if no ID is provided
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                        <h2>Update Reservation</h2>
                    </div>
                    <p>Please edit the input values and submit to update your reservations.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <!-- Input fields for updating record -->
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

