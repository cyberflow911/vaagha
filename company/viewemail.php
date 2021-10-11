<?php
    require_once 'header.php';
    require_once 'left-navbar.php';;
    
        if(isset($_GET['token'])&&!empty($_GET['token']))
        {
            $token=$_GET['token'];
        }
    
        $sql="Select * from email where id=$token";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
                {
                    $row = $result->fetch_assoc();
                        $email = $row;
                }
        }
    
?>

<style>
    .box-body{
	overflow: auto!important;
}
</style>

<div class="page-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Standard Email Template</div>
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
                <div class="box-body">
                    <p><b>To:</b>enduser@gmail.com</p>
                    <p><b>CC:</b> projectmanager@abc.com</p>
                    <p><b>Subject:</b> <?=$email['subject']?></p><br>
                    <p><?=$email['greetings']?> Mr.End User</p><br>
                    <p><?=$email['body']?></p><br>
                    <p><?=$email['endgreetings']?></p>
                    <br><br>
                    <div class="row">
                        <a style="margin-left:30px; padding:10px; font-size: 14px;" href="standardemail" class="btn btn-success">Back</a>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
<div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>