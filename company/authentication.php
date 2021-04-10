<?php
    require_once '../lib/core.php';
    
    
    

?>

<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from codervent.com/syndash/demo/vertical/authentication-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 17 Mar 2021 17:27:20 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>Authentication Screen</title>
	<!-- loader-->
	<link href="../css/pace.min.css" rel="stylesheet" />
	<script src="../js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&amp;family=Roboto&amp;display=swap" />
	<!-- Icons CSS -->
	<link rel="stylesheet" href="../css/icons.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" />
	<!-- App CSS -->
	<link rel="stylesheet" href="../css/app.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');
    </style>
	<style>
		.card {
                width: 500px;
                padding: 10px;
                border-radius: 20px;
                background: #fff;
                border: none;
                height: min(600px, 1000px);
                position: relative;
                font-family: 'Open Sans', sans-serif;
            }
            .box{
                border: 2px solid transparent;
                border-radius: 20px;
                height: 700px;;
                width: 90vw;
                margin: 50px 50px;
            }

            .container {
                height: 100vh
            }

            body {
                background: #eee
            }

            .mobile-text {
                color: #989696b8;
                font-size: 15px
            }

            .form-control {
                margin-right: 12px
            }

            .form-control:focus {
                color: #495057;
                background-color: #fff;
                border-color: #ff8880;
                outline: 0;
                box-shadow: none
            }

            .cursor {
                cursor: pointer
            }

	</style>
</head>

<body style="background-color: white;">
	<!-- wrapper -->
	<div class="wrapper" >
    <div class="box" style="background-color: #e1f3ff;">
		<div class="section-authentication-login d-flex align-items-center justify-content-center">	
            <div class="d-flex justify-content-center align-items-center container">
                <div class="card py-5 px-3" style="margin-top: 150px;">
                    <h2><center><b>Authentication Screen</b></center></h2>
                    <br>
                    <h5 class="m-0"><center>You are now eligible for a payment of £[incentive of the user]. For security purpose we will now send you an One-time-password (OTP) to the mobile number [078xxxxxx12] you have registered. Please make sure you have the mobile at hand</center></h5><br>
                    <center><button type="submit" name="login"class="btn btn-primary">Send OTP</button></center><br>
                    <div class="d-flex flex-row mt-2"><input type="text" class="form-control" autofocus=""><input type="text" class="form-control"><input type="text" class="form-control"><input type="text" class="form-control"><input type="text" class="form-control"><input type="text" class="form-control"></div><br>
                    <center><button type="submit" name="login"class="btn btn-primary">Submit</button></center>
                    <div class="text-center mt-5"><span class="d-block mobile-text">Don't receive the code?</span><span class="font-weight-bold text-danger cursor">Resend</span></div>
                </div>
            </div>
	    </div>
        </div>
    </div>
</body>
</html>
<?php
require_once "js-links.php";
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>