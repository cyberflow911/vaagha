
<?php
    require_once 'header.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token=$_GET['token'];
        $sql = "select type from email where id='$token'";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $row = $result->fetch_assoc();  
                $type=$row['type'];
            } 
        }
        if(isset($_POST['edit']))
        {
            $subject=$conn->real_escape_string($_POST['subject']);
            $body=$conn->real_escape_string($_POST['body']);
            $name=$conn->real_escape_string($_POST['name']);
            $greetings=$conn->real_escape_string($_POST['greetings']);
            $endgreetings=$conn->real_escape_string($_POST['endgreetings']);
            $sql="select * from customise_email where type='$type' and com_id='$COMPANY_ID'";
            if($result = $conn->query($sql))
            {
                if($result->num_rows>0)
                {
                    $sql="delete from customise_email where type='$type' and com_id='$COMPANY_ID'";
                    if($conn->query($sql))
                    {
                        $resMember=true;
                    }
                    else
                    {
                        $errorMember=$conn->error;
                    }
                    $sql="insert into customise_email(com_id, type, greetings, subject, body, endgreetings, name) values('$COMPANY_ID', '$type', '$greetings', '$subject', '$body', '$endgreetings', '$name')";
                    if($conn->query($sql))
                    {
                        header("location: customiseemail");
                    }
                    else
                    {
                        $errorMember=$conn->error;
                    }
                } 
                else
                {
                    $sql="insert into customise_email(com_id, type, greetings, subject, body, endgreetings, name) values('$COMPANY_ID', '$type', '$greetings', '$subject', '$body', '$endgreetings', '$name')";
                    if($conn->query($sql))
                    {
                        header("location: customiseemail");
                    }
                    else
                    {
                        $errorMember=$conn->error;
                    }
                }
            }
            
            
        }
    }
    
    $sql = "select * from email where id='$token'";
    if($result = $conn->query($sql))
    {
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();  
            $email=$row;
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
            <!--breadcrumb-->
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
    
            <form method="post">
                <div class="row">
                    <div class="col-md-10"> 
                        <div class="form-group">
                            <label>Email Template Name</label><br>   
                            <input type="text" style="font-size: 16px;" minlength="5" maxlength="50" value="<?=$email['name']?>" id="name" name="name" class="form-control" required>  
                        </div> 
                    </div>
                </div> <br>
                <div class="row">
                    <div class="col-md-10"> 
                        <div class="form-group">
                            <label>Subject<button class="btn btn-secondary" type="button" id="insertProject" style="margin-left:5px" onclick='setTextToCurrentPos4("pro_title")'>
                                    Insert Project Title
                            </button></label><br>   
                            <textarea  id="subject"  minlength="20" maxlength="250"  name="subject" class="form-control" style="resize: vertical;font-size: 16px;height:150px"><?=$email['subject']?></textarea>   
                        </div> 
                    </div>
                </div>  <br>
                <div class="row">
                    <div class="col-md-10"> 
                        <div class="form-group">
                            
                            <label>Greetings
                            <button class="btn btn-secondary" type="button" id="insertSalutation" style="margin-left:5px" onclick='setTextToCurrentPos("salutation")'>
                                    Insert Salutation
                            </button>
                            <button class="btn btn-secondary" type="button" id="insertFName" style="margin-left:5px" onclick='setTextToCurrentPos("f_name")'>Insert First Name</button>
                            <button class="btn btn-secondary" type="button" id="insertLName" style="margin-left:5px" onclick='setTextToCurrentPos("l_name")'>Insert Last Name</button></label><br>   
                            <input type="text"  minlength="2" maxlength="50" id="greetings" name="greetings" class="form-control" style="font-size: 16px;" value="<?=$email['greetings']?>"  required>
                        </div> 
                    </div>
                </div> <br>
                <div class="row">
                    <div class="col-md-10"> 
                        <div class="form-group">
                            <label>Mail Body Content
                            <button class="btn btn-secondary" type="button" id="insertProject" style="margin-left:5px" onclick='setTextToCurrentPos2("pro_title")'>
                                    Insert Project Title
                            </button>  
                            <button class="btn btn-secondary" type="button" id="insertProject" style="margin-left:5px" onclick='setTextToCurrentPos2("incentive")'>
                                    Insert Incentive
                            </button>  
                            <button class="btn btn-secondary" type="button" id="insertProject" style="margin-left:5px" onclick='setTextToCurrentPos2("link")'>
                                    Link
                            </button>
                            <button class="btn btn-secondary" type="button" id="insertbreak" style="margin-left:5px" onclick='setTextToCurrentPos2("break")'>
                                    Insert Line Break
                            </button></label><br>   
                            <textarea type="text"  id="body"  minlength="100" maxlength="500"  name="body" class="form-control" style="resize: vertical;height:150px; font-size:16px;"><?=$email['body']?></textarea> 
                        </div> 
                    </div>
                </div> <br>
                <div class="row">
                    <div class="col-md-10"> 
                        <div class="form-group">
                            <label>End Greetings
                            <button class="btn btn-secondary" type="button" id="insertPMFname" style="margin-left:5px" onclick='setTextToCurrentPos3("prof_name")'>
                                    Insert PM First Name
                            </button> 
                            <button class="btn btn-secondary" type="button" id="insertPMLname" style="margin-left:5px" onclick='setTextToCurrentPos3("prol_name")'>
                                    Insert PM Last Name
                            </button> 
                            <button class="btn btn-secondary" type="button" id="insertbreak" style="margin-left:5px" onclick='setTextToCurrentPos3("break")'>
                                    Insert Line Break
                            </button> 
                            <button class="btn btn-secondary" type="button" id="insertPMcontact" style="margin-left:5px" onclick='setTextToCurrentPos3("pro_contact")'>
                                Insert PM Number
                            </button></label><br>   
                            <input type="text" style="font-size: 16px;" minlength="2" maxlength="50" value="<?=$email['endgreetings']?>" id="endgreetings" name="endgreetings" class="form-control">  
                        </div> 
                    </div>
                </div> <br>
                
    
                <button type="submit" name="edit" class="btn btn-primary" style="margin-top:10; font-size: 14px; padding: 10px;" value="">Save</button>

            </form>
        </div>
    </div>
</div>

<div class="control-sidebar-bg"></div>
   
<?php
    require_once 'js-links.php';
?>
<script>
    function setTextToCurrentPos(mode) { 
        var insert="";
        if(mode=="salutation")
        {
            insert = "[SALUTATION]";
        }
        else if(mode=='f_name')
        {
            insert = '[FIRST NAME]';
        }
        else if(mode=='l_name')
        {
            insert = '[LAST NAME]';
        }
        var curPos =  document.getElementById("greetings").selectionStart; 
        let x = $("#greetings").val(); 
        $("#greetings").val(x.slice(0, curPos) + insert + x.slice(curPos)); 
    } 
    function setTextToCurrentPos2(mode) { 
        var insert="";
        if(mode=="pro_title")
        {
            insert = "[PROJECT TITLE]";
        }
        else if(mode=="incentive")
        {
            insert = "[INCENTIVE]";
        }
        else if(mode=="link")
        {
            insert = "[LINK]";
        }
        else if(mode=="break")
        {
            insert = "<br>";
        }
        var curPos =  document.getElementById("body").selectionStart; 
        let x = $("#body").val(); 
        $("#body").val(x.slice(0, curPos) + insert + x.slice(curPos)); 
    } 
    function setTextToCurrentPos4(mode) { 
        var insert="";
        if(mode=="pro_title")
        {
            insert = "[PROJECT TITLE]";
        }
        var curPos =  document.getElementById("subject").selectionStart; 
        let x = $("#subject").val(); 
        $("#subject").val(x.slice(0, curPos) + insert + x.slice(curPos)); 
    } 
    function setTextToCurrentPos3(mode) { 
        var insert="";
        if(mode=="prof_name")
        {
            insert = "[PM FIRST Name]";
        }
        else if(mode=="prol_name")
        {
            insert = "[PM LAST Name]";
        }
        else if(mode=="pro_contact")
        {
            insert = "[PM CONTACT NUMBER]";
        }
        else if(mode=="break")
        {
            insert = "<br>";
        }
        var curPos =  document.getElementById("endgreetings").selectionStart; 
        let x = $("#endgreetings").val(); 
        $("#endgreetings").val(x.slice(0, curPos) + insert + x.slice(curPos)); 
    } 
</script>