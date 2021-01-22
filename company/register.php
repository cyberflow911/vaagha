<?php 
	require_once '../lib/core.php';
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if(isset($_POST['reg-num'])&&isset($_POST['com-name'])&&isset($_POST['address'])&&isset($_POST['post'])&&isset($_POST['vat'])&&isset($_POST['first-name'])&&isset($_POST['last-name'])&&isset($_POST['email'])&&isset($_POST['password']))
		{
			$reg_num = $_POST['reg-num'];	
			$com_name = $_POST['com-name'];
			$address = $_POST['address'];
			$post = $_POST['post'];
			$vat = $_POST['vat'];
			$first_name = $_POST['first-name'];
			$last_name = $_POST['last-name'];
			$email = $_POST['email'];
			$password = md5($_POST['password']);
			$sql="INSERT INTO companies(reg_num,com_name,address,post,vat,status) VALUES('$reg_num','$com_name','$address','$post','$vat','1')";
			if($conn->query($sql))
			{
				$com_id = $conn->insert_id;
				$sql="INSERT INTO com_admins(c_id,f_name,l_name,email,password,status) values('$com_id','$first_name','$last_name','$email','$password','1')";
				if($conn->query($sql))
				{
					$register_success = true;
					$token = md5("success");
					header("Location:index?token=$token");
				}
				else
				{
					$register_error = $conn->error; 
				}
			}
			else
			{
				$register_error = $conn->error;
			}
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Register</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/opensans-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- Main Style Css -->
	<link rel="stylesheet" href="css/style.css?token=1"/>
	<!-- bootstrap -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
	<style>
		input:focus, textarea:focus, select:focus,button:focus{
			outline: none;
		}
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
		
 

.btn-info {
    color: #fff;
    background-color: #17a2b8;
    border-color: #17a2b8;
}
.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
	margin:10px;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
	</style>
</head>
<body>
	
	<div class="page-content">
	
		<div class="form-v1-content">
			
			<div class="wizard-form">
		        <form class="form-register" action="#" method="post" id="register-form">
		        	<div id="form-total">
		        		<!-- SECTION 1 -->
			            <h2>
			            	<p class="step-icon"><span>01</span></p>
							<span class="step-text">Company Infomation</span>
							
			            </h2>
			            <section >
			                <div class="inner" id="company-infomation">
			                	<div class="wizard-header">
									<?php
										if(isset($register_success))
										{
									?>
											<div class="alert alert-success" role="alert">
														Company Registered successfully
											</div>
									<?php
										}
										else if(isset($register_error))
										{
									?>
												<div class="alert alert-danger" role="alert">
														Unable To Register Company! Try again later   
												</div>
									<?php
										}
									?>
									
									<h3 class="heading">Company Infomation</h3>
									<p>Please enter your Company infomation and proceed to the next step so we can build your Company account.  </p>
									
								</div>
								<div class="form-row">
									<div class="form-holder">
										<fieldset>
											<legend>Company Reg. Number</legend>
											<input type="text" class="form-control" id="reg-num" name="reg-num" placeholder="Company Reg. Number" required>
											
										</fieldset>
										<button  class="btn btn-info" type="button">Search</button>
									</div>
									<div class="form-holder">
										<fieldset>
											<legend>Company Name</legend>
											<input type="text" class="form-control" id="com-name" name="com-name" placeholder="Company Name" required>
										</fieldset>
										<button  class="btn btn-info" type="button">Search</button>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Address</legend>  
											<textarea id="address" name="address" placeholder="Company Address" class="form-control" rows="3" style="resize: none;width: 100%;border:none;" required></textarea>
										</fieldset>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Post Code</legend>
											<input type="text" class="form-control" id="post" name="post" placeholder="496034" required>
										</fieldset>
									</div>
								</div> 
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>VAT</legend>
											<input type="text" class="form-control" id="vat" name="vat" placeholder="VAT" required>
										</fieldset>
										
									</div>
								</div>
							</div>
			            </section>
						<!-- SECTION 2 -->
			            <h2>
			            	<p class="step-icon"><span>02</span></p>
			            	<span class="step-text">Admin Information</span> 
			            </h2>
			            <section>
			                <div class="inner" id="admin-infomation">
			                	<div class="wizard-header">
									<div class="alert alert-danger" role="alert" style="display:none" id="alert_user">
														Unable To Register Company! Try again later   
									</div>
									<h3 class="heading">Administrator Information</h3>
									<p>Please enter Administrator infomation and proceed to the next step so we can build your Company accounts.</p>
								</div> 
								<div class="form-row">
									<div class="form-holder">
										<fieldset>
											<legend>First Name</legend>
											<input type="text" class="form-control" id="first-name" name="first-name" placeholder="First Name" required>
										</fieldset>
									</div>
									<div class="form-holder">
										<fieldset>
											<legend>Last Name</legend>
											<input type="text" class="form-control" id="last-name" name="last-name" placeholder="Last Name" required>
										</fieldset>
									</div>

								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Email Address</legend>
											<input type="email" name="email" id="email" class="form-control" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="example@email.com" required>
										</fieldset>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Verify Email Address</legend>
											<input type="email" name="re_email" id="re_email" class="form-control" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="example@email.com" required>
										</fieldset>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Password</legend>
											<input type="password" name="password" id="password" class="form-controle" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}"   required>
										</fieldset>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<fieldset>
											<legend>Verify Password</legend>
											<input type="password" name="re_password" id="re_password" class="form-controle" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}"   required>
										</fieldset>
									</div>
								</div>
								 
							</div>
					 
			            </section> 
						<p style="position:absolute;bottom:-1%;margin-left:10px">Already Registered <a href="index">Click Here</a></p>
		        	</div>
					
		        </form>
				
			</div>
			
		</div>
		
	</div>
	<!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
	<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCl2Zq1Xr7l1qLT2INlKwvlpsFnlTa3D58&libraries=places"></script> -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.steps.js"></script>
	<script src="js/main.js?token=2"></script>
</body> 
</html>