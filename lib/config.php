<?php

//opne server error
ini_set('display_errors', 1);
error_reporting(1);

//select time zone
date_default_timezone_set('Asia/Kolkata');

//for the database
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "vaagha";

$servername = "localhost";
$username = "root_dubuddy";
$password = "tnske1z}U6zR";
$dbname = "vaagha";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//google api key
$google_key="AIzaSyCl2Zq1Xr7l1qLT2INlKwvlpsFnlTa3D58";

// Check connection
if($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
//website link
$website_link="http://localhost/vaagha"; 
//page value;
$admin=1;
$subadmin=2;
$user=3;
$deafult_img = $website_link."/images/avatar3.png";
//payment gateway details
$merchant_id=178079;

//sms config
//function send_sms($numbers,$message)
//{
//    $sms_username ='shvetdhara';
//    $sendername = 'SVTDRA';
//    $smstype   = 'TRANS';
//    $apikey   = 'ca41b227-49b0-4c8f-b02c-201ced3b8a28';
//    $url="http://login.aquasms.com/sendSMS?username=$sms_username&message=".urlencode($message)."&sendername=$sendername&smstype=$smstype&numbers=$numbers&apikey=$apikey";
//    $ret = file_get_contents($url);
//    return $ret;
//}


////mail config
$mail = new PHPMailer(); 
$mail->SMTPDebug = false;               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.tattbooking.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'info@tattbooking.com';                 // SMTP username
$mail->Password = '${ZULymF5Ur+';                            // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('info@tattbooking.com', 'Vaagha');                                    // TCP port to connect to

 
// 	$mail->addReplyTo('No Reply Please', 'Information');
 
//    // Optional name
	$mail->isHTML(true);                                   // Set email format to HTML
    $mail->AltBody = 'This is an auto generated email so please dont reply this';
  
 	 
?>