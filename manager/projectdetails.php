<?php
    require_once 'header.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['add']))
        {
              
            $start_date=$_POST['start_date'];
            $incentive=$_POST['incentive'];
            $title=$_POST['title'];
            $description=$_POST['description'];
            $pmid=$_POST['pmanager'];
            $group_num=$_POST['group_num'];
            $tac=$_POST['tac'];
            $preference=$_POST['preference'];
            $signortick=$_POST['signortick'];
            $participants=$_POST['participants'];
            echo $sql="insert into projects(pm_id, cm_id, title, description, start_date, incentive, participants, group_num, project_reference, termandcondition, signortick, status) values('$MANAGER_ID', '$MANAGERCOM_ID', '$title', '$description', '$start_date', $incentive, '$participants', '$group_num', '$preference', '$tac', '$signortick', '1')";
            if($conn->query($sql))
            {
                $insert_id = $conn->insert_id;
                if($signortick==2 && $tac==1)
                {
                    if(upload_tandc2($_FILES,$conn,"projects","id","tandcfile",$insert_id,"projectFile",$website_link."/manager/uploads"))
                    {
                        $resMember = "all_true";
                    }else
                    {
                        $errorMember = "Something Went Wrong (Check your file extension).";
                    }
                }
                else if($signortick==1 && $tac==1)
                {
                    if(upload_tandc($_FILES,$conn,"projects","id","tandcfile",$insert_id,"projectFile",$website_link."/manager/uploads"))
                    {
                        $resMember = "all_true";
                    }else
                    {
                        $errorMember = "Something Went Wrong (Check your file extension).";
                    }
                }
                $resMember=true;
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
    }
       
    if(isset($_GET['token'])&& !empty($_GET['token']))
    {
        $token=$_GET['token'];
        if(isset($_POST['edit']))
        {  
            $start_date=$_POST['start_date'];
            $incentive=$_POST['incentive'];
            $title=$_POST['title'];
            $description=$_POST['description'];
            $pmid=$_POST['pmanager'];
            $group_num=$_POST['group_num'];
            $tac=$_POST['tac'];
            $preference=$_POST['preference'];
            $signortick=$_POST['signortick'];
            $participants=$_POST['participants'];
            $sql="update projects set start_date='$start_date', project_reference='$preference', title='$title', description='$description', participants='$participants', group_num='$group_num', incentive='$incentive', termandcondition='$tac', signortick='$signortick'  where id='$token'";
            if($conn->query($sql))
            {
                $insert_id = $token;
                if($signortick==2 && $tac==1)
                {
                    if(upload_tandc2($_FILES,$conn,"projects","id","tandcfile",$insert_id,"projectFile",$website_link."/manager/uploads"))
                    {
                        $resMember = "all_true";
                    }
                    else
                    {
                        $errorMember = "Something Went Wrong (Check your file extension).";
                    }
                }
                else if($signortick==1 && $tac==1)
                {
                    if(upload_tandc($_FILES,$conn,"projects","id","tandcfile",$insert_id,"projectFile",$website_link."/manager/uploads"))
                    {
                        $resMember = "all_true";
                    }else
                    {
                        $errorMember = "Something Went Wrong (Check your file extension).";
                    }
                }
                $resMember=true;
            }
            else
            {
                $errorMember=$conn->error;
            }
        } 
        $sql = "select p.*, pm.id as pmid from projects p, com_admins pm where pm.type=2 and p.id=$token and pm.id=p.pm_id";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $project_details  = $result->fetch_assoc();  
            } 
        }
        else
        {
            $errorMember=$conn->error;
        }
    }  
       
    $pdate = date("Y-m-d", strtotime("-1 month"));
?>


<style>
    .box-body{
	overflow: auto!important;
}

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
</style>


<div class="page-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Project Details</div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>
                            </li>
                        </ol>
                    </nav>
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
            <form method="post" enctype="multipart/form-data">
                <div class="card radius-15 border-lg-top-primary">
                    <div class="card-body p-5">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Project Title</label><br>   
                                        <input type="text" style="font-size: 16px;" id="title"  minlength="3" maxlength="50" name="title" class="form-control" value="<?=$project_details['title']?>" required>  
                                    </div> 
                                </div>
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Project Reference</label><br>   
                                        <input type="text" style="font-size: 16px;" id="preference"  minlength="3" maxlength="18" name="preference" class="form-control" value="<?=$project_details['project_reference']?>" required>  
                                    </div> 
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-10"> 
                                    <div class="form-group">
                                        <label style="margin-left:5px">Project Description</label><br> 
                                        <textarea type="text"  id="description" style="font-size: 16px;" maxlength="500"  name="description" class="form-control" style="resize: vertical;height:150px"><?=$project_details['description']?> </textarea> 
                                    </div> 
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Incentive</label><br> 
                                        <input type="number"  id="incentive" style="font-size: 16px;" minlength="3" maxlength="5" step=".01" oninput="check(this)" name="incentive" class="form-control" value="<?=$project_details['incentive']?>">  
                                    </div> 
                                </div>
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Number of Participants</label><br> 
                                        <input type="number"  id="participants" style="font-size: 16px;" oninput="check(this)" minlength="2" maxlength="5" name="participants" class="form-control" value="<?=$project_details['participants']?>">
                                    </div> 
                                </div> 
                            </div>
                            <div class="row" style="margin-bottom:20px">  
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>No. of Groups</label><br> 
                                        <input type="number"  id="group_num" style="font-size: 16px;" oninput="check(this)" minlength="1" maxlength="3" name="group_num" class="form-control" value="<?=$project_details['group_num']?>">  
                                    </div> 
                                </div>

                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Start Date</label><br> 
                                        <input type="date"  id="start_date" style="font-size: 16px;" min="<?=$pdate?>" name="start_date" class="form-control" value="<?=$project_details['start_date']?>" required>  
                                    </div> 
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Project Specific Terms and Conditions</label><br>  
                                        <?php
                                        if($project_details['termandcondition']==1)
                                        {
                                        ?>
                                            <input type="radio" id="yes" onclick="myFunction(this.value)" name="tac" value="1" checked required>
                                            <label>Yes</label><br>
                                            <input type="radio" id="no" onclick="myFunction(this.value)" name="tac" value="2" >
                                            <label>No</label><br>
                                        <?php
                                        }
                                        else if($project_details['termandcondition']==2)
                                        {
                                        ?>  
                                        <input type="radio" id="yes" onclick="myFunction(this.value)" name="tac" value="1" required>
                                        <label>Yes</label><br>
                                        <input type="radio" id="no" onclick="myFunction(this.value)" name="tac" value="2" checked>
                                        <label>No</label><br>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                            <input type="radio" id="yes" onclick="myFunction(this.value)" name="tac" value="1" required>
                                            <label>Yes</label><br>
                                            <input type="radio" id="no" onclick="myFunction(this.value)" name="tac" value="2">
                                            <label>No</label><br>
                                        <?php
                                        }
                                        ?>
                                        
                                    </div> 
                                </div>
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Does the user need to sign the terms 
                                        and conditions Or Can only tick a 
                                        Check Box </label><br>  
                                    <?php
                                    if($project_details['signortick']==1)
                                    {
                                    ?>
                                        <input type="radio" id="sign" name="signortick" value="1" checked>
                                        <label>User should Sign T&Cs</label><br>
                                        <input type="radio" id="tick" name="signortick" value="2">
                                        <label>User can only tick a Check Box</label><br>
                                    <?php
                                    } 
                                    else if($project_details['signortick']==2)  
                                    {
                                    ?>
                                        <input type="radio" id="sign" name="signortick" value="1">
                                        <label>User should Sign T&Cs</label><br>
                                        <input type="radio" id="tick" name="signortick" value="2"  checked>
                                        <label>User can only tick a Check Box</label><br>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <input type="radio" id="sign" name="signortick" value="1">
                                        <label>User should Sign T&Cs</label><br>
                                        <input type="radio" id="tick" name="signortick" value="2">
                                        <label>User can only tick a Check Box</label><br>
                                    <?php
                                    }
                                    ?>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                    <label>Upload T&Cs </label><br>
                                    <?php
                                    if($project_details['termandcondition']==1)
                                    {
                                        $counter=0;
                                        $ext=pathinfo($project_details['tandcfile'],PATHINFO_EXTENSION);
                                        if($ext=="pdf")
                                        {
                                    ?>
                                             <div class="col-md-2" id="file<?=$counter?>">
                                                <div class="col-md-8">
                                                    <a href="<?=$project_details['tandcfile']?>" target="_blank"><img src="../img/extras/pdf.svg" width="100px" height="100px" id="logoImg"/></a>
                                                </div>
                                            </div>
                                            <input type="file" style="margin-top:30px; font-size: 16px; padding-bottom: 35px;" id='projectfile' name="projectFile[]" class="form-control" >
                                    <?php
                                        }
                                        else if($ext=="docx")
                                        {
                                    ?>
                                            <div class="col-md-2" id="file<?=$counter?>">
                                                <div class="col-md-8">
                                                    <a href="<?=$project_details['tandcfile']?>" target="_blank"><img src="../img/logo/docxlogo.png" width="100px" height="100px" id="logoImg"/></a>
                                                    
                                                </div>
                                                
                                            </div>
                                            <input type="file" style="margin-top:40px;font-size: 16px; padding-bottom: 35px;" id='projectfile' name="projectFile[]" class="form-control" >
                                    <?php
                                        }
                                        else if($ext=="txt")
                                        {
                                    ?>
                                            <div class="col-md-2" id="file<?=$counter?>">
                                                <div class="col-md-8">
                                                    <a href="<?=$project_details['tandcfile']?>" target="_blank"><img src="../img/logo/txt.png" width="100px" height="100px" id="logoImg"/></a>
                                                </div>
                                            </div>
                                            <input type="file" style="margin-top:30px;font-size: 16px; padding-bottom: 35px;" id='projectfile' name="projectFile[]" class="form-control" >
                                    <?php
                                        }
                                    }
                                    else
                                    {
                                    ?>
                                            <input type="file" style="font-size: 16px; padding-bottom: 35px;" id='projectfile' name="projectFile[]" class="form-control" >
                                            <span style="font-size: 10px; color: gray;">For Sign Accepted format = .docx</span> <br> 
                                            <span style="font-size: 10px; color: gray;">For CheckBox Accepted format = .docx, .pdf, .txt</span>
                                    <?php
                                    }
                                    ?>
                                    </div> 
                                </div>
                            </div>


                            <?php
                                    if(isset($project_details))
                                    {
                            ?>
                                            <button type="submit" name="edit" class="btn btn-primary" onclick="return confirm('Do you want to save the changes? Y/N')" style="width: 60px; height: 30px; font-size: 16px;">Save</button>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                            
                                            <button type="submit" name="add" class="btn btn-primary" onclick="return confirm('Do you want to save the changes? Y/N')" style="width: 60px; height: 30px; font-size: 16px;">Add</button>
                            <?php
                                    }
                            ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>
<script>
    
    function myFunction(val)
    {
        console.log(val)
         if(val==1)
         {
             $("#sign").prop("required", true);
             $("#projectfile").attr("required", true);
         }
         else if(val==2)
         {
            $("#sign").prop("required", false);
             $("#projectfile").removeAttr("required");
         }
    }

    function check(input) 
    {
     if (input.value == 0 || input.value < 0) {
         input.setCustomValidity('The number must not be zero or smaller than 0.');
     } else {
         // input is fine -- reset the error message
         input.setCustomValidity('');
     }
     }
     
     function pmcheck()
     {
         var pid=$('#pmanager').val();
         getpmanagerdata(pid);
     } 
    
    function getpmanagerdata(id)
    {
        $.ajax({
            url:"managerdata.php",
            type:"POST",
            
            data:{
                managerdata:id
            },
            success:function(response){
                var obj=JSON.parse(response);
            var email = obj.email;
            var m_num = obj.m_num;
            console.log(email);
            $("#pmemail").val(email);
            $("#pmnumber").val(m_num);
            },
            error:function()
            {

            }
        
        })
    }
</script>



