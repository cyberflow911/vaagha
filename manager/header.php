<?php
ob_start();
require_once '../lib/core.php';

$id=$_SESSION['projectmanager_signed_in'];
if(!projectmanager_auth())
{
    header("location: logout");
}


$sql="select * from com_admins where email='$id'";
$res=$conn->query($sql);
if($res->num_rows > 0)
{
    $row=$res->fetch_assoc();
    $MANAGER_DATA=$row;
}

$MANAGER_COMID=$MANAGER_DATA['c_id'];
$MANAGER_ID=$MANAGER_DATA['id']; 
$F_NAME=$MANAGER_DATA['f_name'];
$L_NAME=$MANAGER_DATA['l_name'];
 $FNAME=$F_NAME[0];
 $LNAME=$L_NAME[0];

//user_auth($type,$subadmin);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Project Manager Panel | PW</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../admin/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../admin/bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../admin/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../admin/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../admin/dist/css/style.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../admin/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>Project Manager Panel</title>
	<!--favicon-->
	<link rel="icon" href="../images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="../admin/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="../admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="../admin/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="../css/pace.min.css" rel="stylesheet" />
	<script src="../js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&amp;family=Roboto&amp;display=swap" />
	<!-- Icons CSS -->
	<link rel="stylesheet" href="../css/icons.css" />
	<!-- App CSS -->
	<link rel="stylesheet" href="../css/app.css" />
	<link rel="stylesheet" href="../css/dark-sidebar.css" />
	<link rel="stylesheet" href="../css/dark-theme.css" />  
     
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> 
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


	<style>
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 7%;
  right: 0;
}

.profileImage {
  width: 60px;
  height: 48;
  background: #25383C;
  font-size: 35px;
  color: #fff;
  text-align: center;
  line-height: 60px;
  border-radius: 50%;
}
.profileImageUser {
  width: 60px;
  height: 48;
  background: #25383C;
  font-size: 35px;
  color: #fff;
  text-align: center;
  line-height: 60px;
  border-radius: 50%; 
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}
.card .nav.flex-column>li {
    border-bottom: 1px solid rgba(0,0,0,.125);
    margin: 0;}
.float-right {
    float: right!important;
}
.card-primary:not(.card-outline)>.card-header, .card-primary:not(.card-outline)>.card-header a {
    color: #fff;
}
.badge-warning {
    color: #1f2d3d;
    background-color: #ffc107;
}
.badge-danger {
    color: #1f2d3d;
    background-color: red;
}
.btn-secondary, .btn-secondary:hover{
    background-color: #555555;
    color: white;
}


.badge-success {
    color: #fff;
    background-color: #28a745;
}
.btn-pink
{
  background-color: #fc6c85;
  color: white;
}
.btn-info
{
  background-color: #17a2b8;
  color: white;
}


.card-primary:not(.card-outline)>.card-header {
    background-color: #007bff;
}
.card-header:first-child {
    border-radius: calc(.25rem - 0) calc(.25rem - 0) 0 0;
}

.card-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0,0,0,.125);
    padding: .75rem 1.25rem;
    position: relative;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
}
.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 0 solid rgba(0,0,0,.125);
}
*, ::after, ::before {
    box-sizing: border-box;
}
div {
    display: block;
}
button, input {
    overflow: visible;
}
button, input, optgroup, select, textarea {
    margin: 0;
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
}
*, ::after, ::before {
    box-sizing: border-box;
}
input[type="text" i] {
    
    padding: 1px 2px;
}

.form-group {
    margin-bottom: 3rem;
}

label:not(.form-check-label):not(.custom-file-label) {
    font-weight: 700;
    font-size: 16px;
}
label {
    display: inline-block;
    margin-bottom: .5rem;
}

label {
    cursor: default;
}

.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    min-height: 1px;
   
    padding: 1.25rem;
}


*, ::after, ::before {
    box-sizing: border-box;
}
div {
    display: block;
}

.card-footer:last-child {
    border-radius: 0 0 calc(.25rem - 0) calc(.25rem - 0);
}
.card-footer {
    padding: .75rem 1.25rem;
    background-color: rgba(0,0,0,.03);
    border-top: 0 solid rgba(0,0,0,.125);
}



.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9; 
}
._1qUuq{margin-left:.5rem;font-size:15px;font-size:.9375rem;font-weight:500;font-stretch:normal;font-style:normal;letter-spacing:.14px;letter-spacing:.00875rem;text-align:left;color:#4a4a4a}
._3qzZ9{display:-ms-flexbox;display:flex;-ms-flex-direction:row;flex-direction:row;-ms-flex-align:start;align-items:flex-start}
</style>
</head>
<body>
<header class="top-header">
    <nav class="navbar navbar-expand">
        <div class="right-topbar ml-auto">
            <ul class="navbar-nav">
                
            </ul>
        </div>
    </nav>
</header>
