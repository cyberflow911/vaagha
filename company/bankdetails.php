<?php
    require_once '../lib/core.php';
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
    }
    if(isset($_GET['uid'])&& !empty($_GET['uid']))
    {
        $uid=$_GET['uid'];
        $sql="select u.*,p.id as pid, p.title, p.termandcondition as tnc, p.signortick as sot from users u, projects p where u.id=$uid and u.p_id=p.id";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $row=$result->fetch_assoc();
                    $user_details=$row;
            } 
        }
        $pid=$user_details['pid'];
        if(isset($_POST['continue']))
        {
            $name=$_POST['name'];
            $bank_name=$_POST['bank_name'];
            $sort_code=$_POST['sort_code'];
            $acc_num=$_POST['acc_num'];
            $sql="insert into bank_details(u_id, p_id, user_name, bank_name,sort_code, account_num, com_tandc,status) values('$uid','$pid','$name', '$bank_name', '$sort_code', '$acc_num', 1, 1)";
            if($conn->query($sql))
            {
                $insert_id = $conn->insert_id;
                header("Location: confirmbankdetails?token=$insert_id");
            }
            else
            {
                $errorMember = $conn->error;
            }
        }

    }
    if(isset($_GET['token'])&& !empty($_GET['token']))
    {
        $token=$_GET['token'];
        if(isset($_POST['edit']))
        {
            $name=$_POST['name'];
            $bank_name=$_POST['bank_name'];
            $sort_code=$_POST['sort_code'];
            $acc_num=$_POST['acc_num'];
            $ctnc=$_POST['ctnc'];
            if($ctnc==1)
            {
                $sql="update bank_details set user_name='$name', bank_name='$bank_name',sort_code='$sort_code', account_num='$acc_num', com_tandc=1, status=2 where id=$token";
                if($conn->query($sql))
                {
                    $insert_id = $token;
                    header("Location: confirmbankdetails?token=$insert_id");
                }
                else
                {
                    $errorMember = $conn->error;
                }
            }
            else
            {
                $sql="update bank_details set user_name='$name', bank_name='$bank_name',sort_code='$sort_code', account_num='$acc_num', status=2 where id=$token";
                if($conn->query($sql))
                {
                    $insert_id = $token;
                    header("Location: confirmbankdetails?token=$insert_id");
                }
                else
                {
                    $errorMember = $conn->error;
                }
            }
        }
        $sql="select * from bank_details where id=$token";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $bank_details  = $result->fetch_assoc();  
            } 
        }
        $bpid=$bank_details['p_id'];
    }
    $sql="select * from projects where id='$bpid' or id='$pid'";
    if($result = $conn->query($sql))
    {
        if($result->num_rows)
        {
            $project_details  = $result->fetch_assoc();  
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>Bank Details</title>
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
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
</head>

<body style="background-color: #e1f3ff;">
    <div class="row"  >
        <div class="col-12 col-lg-9 mx-auto" style="margin-top: 50px;">
            <div class="card radius-15"  style=" background-color: white;">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="mb-0">Enter Bank Details</h4>
                    </div>
                    <hr/>
                    <div class="form-body">
                        <form method="post">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name as given in Bank</label>
                                <div class="col-sm-10">
                                    <input type="text" minlength="3" maxlength="225" name="name" id="name" class="form-control" value="<?=$bank_details['user_name']?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Bank Name</label>
                                <div class="col-sm-10">
                                    <input type="text" minlength="3" maxlength="225" name="bank_name" id="bank_name" value="<?=$bank_details['bank_name']?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Sort Code</label>
                                <div class="col-sm-10">
                                    <input type="number" name="sort_code" value="<?=$bank_details['sort_code']?>" onchange="check(this)" id="sort_code" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Account Number</label>
                                <div class="col-sm-10">
                                    <input type="number" name="acc_num" value="<?=$bank_details['account_num']?>" onchange="check2(this)" id="acc_num" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Projectwize Terms & Conditions</label><br><br>
                                <div class="form-check" style="margin-left: 12px;">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                    <label class="form-check-label" for="flexCheckDefault">I have read and understood Projectwize Terms and Conditions. I hear by accept Projectwize Terms and Conditions.</label>
                                </div>
                        <?php
                            if($project_details['signortick']==2)
                            {
                        ?>
                                <label class="col-sm-2 col-form-label">Client Terms & Conditions</label><br><br>
                                <div class="form-check" style="margin-left: 12px;">
                                    <input class="form-check-input" type="checkbox" value="1" name="ctnc" id="flexCheckDefault" required>
                                    <label class="form-check-label" for="flexCheckDefault">I have read and understood Client Terms and Conditions. I hear by accept Projectwize Terms and Conditions.</label>
                                </div>
                        <?php
                            }
                        ?>
                            </div>
                            <div class="form-group row">
                        <?php
                                if(isset($bank_details))
                                {
                        ?>
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" name="edit" class="btn btn-primary px-4">Save Changes</button>
                                    </div> 
                            <?php
                                }
                                else
                                {
                            ?>
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" name="continue" class="btn btn-primary px-4">Continue</button>
                                </div>
                            <?php
                                }
                            ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
require_once "js-links.php";
?>
<script>
    function check(input) 
    {
        var code=$("#sort_code").val().length;
        if (code > 6 || code < 6) 
        {
            input.setCustomValidity('The number must be a 6-digit number');
        } 
        else 
        {
            input.setCustomValidity('');
        }
     }
    function check2(input) 
    {
        var code=$("#acc_num").val().length;
        if (code > 8 || code < 8) 
        {
            input.setCustomValidity('The number must be a 8-digit number');
        } 
        else 
        {
            input.setCustomValidity('');
        }
     }
</script>
</html>
