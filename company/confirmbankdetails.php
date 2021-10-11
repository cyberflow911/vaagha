<?php
    require_once '../lib/core.php';
    if(isset($_GET['token'])&& !empty($_GET['token']))
    {
        $token=$_GET['token'];

        $sql="select b.*, p.termandcondition as tnc, p.signortick from bank_details b, projects p where b.id='$token' and p.id=b.p_id";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $row  = $result->fetch_assoc();  
                $bank_details=$row;
            } 
        }
        if(isset($_POST['confirm']))
        {
            if($bank_details['p_tandc']==1||$bank_details['tnc']==2||($bank_details['tnc']==1&&$bank_details['signortick']==null))
            {    
                $sql="update bank_details set status='3' where id='$token'";
                if($conn->query($sql))
                {
                    $insert_id=$token;
                    $sql="update users set pay_status=4 where id='".$bank_details['u_id']."'";
                    if($conn->query($sql))
                    {
                        $resMember=true;
                    }
                    else
                    {
                        $errorMember=$conn->error;
                    }
                    header("Location: success_screen?token=$insert_id");
                }
            }
            else
            {
                $sql="update bank_details set status='2' where id='$token'";
                if($conn->query($sql))
                {
                    $insert_id=$token;
                    $sql="update users set pay_status=3 where id='".$bank_details['u_id']."'";
                    if($conn->query($sql))
                    {
                        $resMember=true;
                    }
                    else
                    {
                        $errorMember=$conn->error;
                    }
                    header("Location: success_screen?token=$insert_id");
                }
            }
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
    </head>

    <body style="background-color: #e1f3ff;">
        <div class="row"  style="margin-top: 50px;">
            <div class="col-12 col-lg-9 mx-auto">
                <div class="card radius-15" style=" background-color: white;">
                    <div class="card-body" >
                        <div class="card-title">
                            <h4 class="mb-0">Confirm Bank Details</h4>
                        </div>
                        <hr/>
                        <div class="form-body">
                        <form method="post">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name as given in Bank</label>
                                <div class="col-sm-10">
                                    <input type="text" value="<?=$bank_details['user_name']?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Bank Name</label>
                                <div class="col-sm-10">
                                    <input type="text" value="<?=$bank_details['bank_name']?>"  class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Sort Code</label>
                                <div class="col-sm-10">
                                    <input type="text" value="<?=$bank_details['sort_code']?>"  class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Account Number</label>
                                <div class="col-sm-10">
                                    <input type="text" value="<?=$bank_details['account_num']?>"  class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <button type="button" onclick="edit()" class="btn btn-primary px-4">Edit</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <button type="submit" name="confirm" class="btn btn-primary px-4">Confirm</button>
                                    </div>
                                </div>
                            </div>
                            </form>
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
<script>
    function edit()
    {
        window.location.href = "bankdetails?token=<?=$token?>";   
    }
</script>