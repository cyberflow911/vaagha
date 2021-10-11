<?php
    require_once 'header.php';
    require_once 'left-navbar.php';

    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token=$_GET['token'];
        $sql="select * from email where id='$token'";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $email = $result->fetch_assoc();  
            } 
        }
    }
?>
<div class="page-wrapper">
	<div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Customise Email Template</div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ml-auto">
                    <div class="btn-group"> 
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
                    </div>
                </div>
            </div>
        <?php
            if(isset($resMember))
            {
        ?>
                <div class="alert alert-success"><strong>Success! </strong> your request successfully updated. </div>   
        <?php
            }
            else if(isset($errorMember))
            {
        ?>
                <div class="alert alert-danger"><strong>Error! </strong><?=$errorMember?></div> 
        <?php
                
            }
        ?>
            <div class="box">
                <div class="box-body" style="font-size:16px;">
                    <p><b>To:</b>enduser@gmail.com</p>
                    <p><b>CC:</b> projectmanager@abc.com</p>
                    <p><b>Subject:</b> <?=$email['subject']?></p>
                    <p><?=$email['greetings']?> Mr.End User,</p>
                    <p><?=$email['body']?></p>
                    <p><?=$email['endgreetings']?></p>
                    <br><br>
                    <div class="row">
                        <a style="margin-left:30px; font-size: 14px; padding: 8px;" href="emailaddedit?token=<?=$email['id']?>" class="btn btn-success">Edit</a>
                        <a href="standardemail" style="margin-left: 5px;font-size: 14px; padding: 8px;" class="btn btn-primary">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="control-sidebar-bg"></div>
<?php
require_once "js-links.php";
?>