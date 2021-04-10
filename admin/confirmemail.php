<?php
    require_once 'header.php';
    require_once 'navbar.php';
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
<div class="content-wrapper">
    <section class="content-header">
        <h1>
          Customise Email Template
        </h1>
    </section>
    <section class="content">
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
                <p><b>Subject:</b> <?=$email['subject']?></p>
                <p><?=$email['greetings']?> Mr.End User,</p>
                <p><?=$email['body']?></p>
                <p><?=$email['endgreetings']?></p>
                <br><br>
                <div class="row">
                    <a style="margin-left:30px;" href="emailaddedit?token=<?=$email['id']?>" class="btn btn-success">Edit</a>
                    <a href="customiseemail" class="btn btn-primary">Confirm</a>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="control-sidebar-bg"></div>
<?php
require_once "js-links.php";
?>