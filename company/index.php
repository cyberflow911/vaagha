<?php
    require_once '../lib/core.php';
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
        if(isset($_POST['email'])&& isset($_POST['password']))
        {
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            if(!login($email,$password,$conn))
            {
                $error ="Inavlid Email or Password";
            }   
        }
    }
    if($_SERVER['REQUEST_METHOD'] == 'GET')
	{
        if(isset($_GET['token'])&&!empty($_GET['token']))
        {
            $token = $_GET['token'];
            if($token=md5("success"))
            {
                $registration_success = true;
            }
        }
    }
    

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Company Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- LINEARICONS -->
		<link rel="stylesheet" href="fonts/linearicons/style.css">
		
		<!-- STYLE CSS -->
        <link rel="stylesheet" href="css/style_login.css?token=232">
        <style> 
		.alert-danger {
			color: #721c24;
			background-color: #f8d7da;
			border-color: #f5c6cb;
		}
		.alert {
			position: relative;
			padding: .75rem 1.25rem;
			margin-bottom: 1rem;
			border: 1px solid transparent;
			border-radius: .25rem;
		}
		.alert-success {
			color: #155724;
			background-color: #d4edda;
			border-color: #c3e6cb;
		}
	</style>
	</head>

	<body style="overflow:hidden">

		<div class="wrapper">
			<div class="inner">
				<img src="images/image-1.png" alt="" class="image-1">
				<form method="post" >
                    <?php 
                    if(isset($error))
                    {
                    ?>
                        <div class="alert alert-danger" role="alert">
                           <?=$error?>
                        </div>
                    <?php
                    }

                    if(isset($registration_success))
                    {
                    ?>
                        <div class="alert alert-success" role="alert">
                           Company Registered Successfully. Use Admin Credentials to Login
                        </div>  
                    <?php
                    }
                    ?>
					<center><a href="../"><img src="../img/logo/logo.png" height="150px"  /></a></center>
					<h3>Company Login</h3>
					<div class="form-holder">
						<span class="lnr lnr-user"></span>
						<input type="text" name="email" class="form-control" placeholder="Email">
					</div> 
					<div class="form-holder">
						<span class="lnr lnr-lock"></span>
						<input type="password" name="password" class="form-control" placeholder="Password">
					</div> 
					<button>
						<span>Login</span>
					</button>
					<br>
					<p>Not Registered Yet <a href="register" style="color:red">Click Here</a> </p>
				</form>
				<img src="images/image-2.png" alt="" class="image-2">
			</div>
			
		</div>
		
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/main_login.js"></script>
	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>