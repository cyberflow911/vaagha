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
            $sql="insert into projects(pm_id, cm_id, title, description, start_date, incentive, participants, group_num, project_reference, termandcondition, signortick, status) values('$pmid', '$COMPANY_ID', '$title', '$description', '$start_date', $incentive, '$participants', '$group_num', '$preference', '$tac', '$signortick', '1')";

            if($conn->query($sql))

            {

                $insert_id = $conn->insert_id;

                if($signortick==2 && $tac==1)

                {

                    if(upload_tandc2($_FILES,$conn,"projects","id","tandcfile",$insert_id,"projectFile",$website_link."/company/uploads"))

                    {

                        $resMember = "all_true";

                    }else

                    {

                        $errorMember = "Something Went Wrong (Check your file extension).";

                    }

                }

                else if($signortick==1 && $tac==1)

                {
                    if(upload_tandc($_FILES,$conn,"projects","id","tandcfile",$insert_id,"projectFile",$website_link."/company/uploads"))

                    {

                        $resMember = "all_true";

                    }else

                    {

                        $errorMember = "Something Went Wrong (Check your file extension).";

                    }

                }

                else
                {
                    $resMember=true; 

                }

            }

            else

            {

                $errorMember=$conn->error;

            }

        }

        if(isset($_POST['addpm']))

        {

            $f_name=$_POST['pmf_name'];

            $l_name=$_POST['pml_name'];

            $email=$_POST['pmemail'];

            $m_num=$_POST['pmm_num'];

            $sql="insert into com_admins(c_id, f_name, l_name, email, m_num, type, status) values('$COMPANY_ID', '$f_name','$l_name', '$email', '$m_num', '2', '1')";

            if($conn->query($sql))

            {

                $resMember = "true";  

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

                    if(upload_tandc2($_FILES,$conn,"projects","id","tandcfile",$insert_id,"projectFile",$website_link."/company/uploads"))

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

                    if(upload_tandc($_FILES,$conn,"projects","id","tandcfile",$insert_id,"projectFile",$website_link."/company/uploads"))

                    {

                        $resMember = "all_true";

                    }else

                    {

                        $errorMember = "Something Went Wrong (Check your file extension).";

                    }

                }
                else
                {
                    $resMember=true; 

                }


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



        $sql = "SELECT * from project_files where p_id=$token";

        if($result = $conn->query($sql))

        {

            if($result->num_rows)

            {

                while($row = $result->fetch_assoc())

                {

                    $project_files[]=$row;

                }

                

            }

            

        }

    }    

    



    

    $sql="select * from com_admins where type=2 and c_id='$COMPANY_ID'";

    $result =  $conn->query($sql);

    if($result->num_rows)

    {

        while($row = $result->fetch_assoc())

        {

            $pm_name[] = $row;

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

                            <?php

                                if(isset($pm_name))

                                {

                            ?>

                                    <div class="row">

                                        <div class="col-md-5"> 

                                            <div class="form-group">

                                            <label style="margin-left:5px" >Project Manager</label><br> 

                                            <select name="pmanager" oninput="pmcheck()" style="font-size: 16px;" id="pmanager" class="form-control">

                                            <option value="">Select</option>

                            <?php

                                            foreach($pm_name as $data)

                                            {

                                                $selected=" ";

                                                if($data['id']==$project_details['pm_id'])

                                                {

                                                    $selected="selected";

                                                }

                                    ?>

                                                <option <?=$selected?> value="<?=$data['id']?>"><?=$data['f_name']?> <?=$data['l_name']?>-<?=$data['email']?></option>

                            <?php

                                            }

                            ?>

                                            </select>

                                            </div>

                                        </div>

                                    </div>

                            <?php

                                    

                                }

                                else

                                {

                            ?>

                                   <br> <div class="row">

                                        <div class="col-md-5"> 

                                            <div class="form-group">

                                                <button title="" style="padding: 8px; font-size: 14px;" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i>&nbspAdd Project Manager</button>

                                            </div>

                                        </div>

                                    </div>

                                    <br>

                            <?php

                                }

                            ?>

                                    

                            <div class="row">

                                <div class="col-md-5"> 

                                    <div class="form-group">

                                        <label>Project Manager Number</label><br> 

                                        <input type="text"  id="pmnumber" style="font-size: 16px;"  name="pmnumber" class="form-control" readonly>  

                                    </div> 

                                </div>

                                <div class="col-md-5"> 

                                    <div class="form-group">

                                        <label>Project Manager Email</label><br> 

                                        <input type="text"  id="pmemail" style="font-size: 16px;" name="pmemail" class="form-control"  readonly>  

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
                                        if(isset($project_details))
                                        {
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
                                if(isset($project_details))
                                {
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
                                    if(isset($project_details))
                                    {
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
                                            else
                                            {
                                            ?>
                                                <input type="file" style="font-size: 16px; padding-bottom: 35px;" id='projectfile' name="projectFile[]" class="form-control" >

                                                <span style="font-size: 10px; color: gray;">For Sign Accepted format = .docx</span> <br> 

                                                <span style="font-size: 10px; color: gray;">For CheckBox Accepted format = .docx, .pdf, .txt</span>
                                            <?php
                                            }

                                        }
                                        else if($project_details['termandcondition']==2)
                                        {
                                            ?>
                                                <input type="file" style="font-size: 16px; padding-bottom: 35px;" id='projectfile' name="projectFile[]" class="form-control" >

                                                <span style="font-size: 10px; color: gray;">For Sign Accepted format = .docx</span> <br> 

                                                <span style="font-size: 10px; color: gray;">For CheckBox Accepted format = .docx, .pdf, .txt</span>
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

<div class="modal fade" id="modal-default">

    <div class="modal-dialog" >

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" style="font-size: 18px;">Add Project Manager</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <form method="post">

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6"> 

                            <div class="form-group">

                                <label>First Name</label><br>   

                                <input type="text" minlength="2" maxlength="50" style="font-size: 16px;" id="pmf_name" name="pmf_name" class="form-control" required>  

                            </div> 

                        </div>

                        <div class="col-md-6"> 

                            <div class="form-group">

                                <label>Last Name</label><br>   

                                <input type="text" minlength="2" maxlength="50" style="font-size: 16px;" id="pml_name" name="pml_name" class="form-control" required>  

                            </div> 

                        </div>

                    </div>  

                    <div class="row">

                        <div class="col-md-6"> 

                            <div class="form-group">

                                <label>Email</label><br>   

                                <input type="email" style="font-size: 16px;" id="pmemail" name="pmemail" class="form-control"  required>  

                            </div> 

                        </div>

                        <div class="col-md-6"> 

                            <div class="form-group">

                                <label>Contact Number</label><br>   

                                <input type="text" style="font-size: 16px;" oninput="numcheck(this)" id="pmm_num" name="pmm_num" class="form-control"  required>  

                            </div> 

                        </div>

                    </div> 

                </div>

                <div class="modal-footer">

                    <button type="button" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                    <button type="submit" name="addpm" class="btn btn-primary" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;" value="">Add</button>

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



    function numcheck(input)

    {

        var num=$("#pmm_num").val();

        var one = String(num).charAt(0);

        var one_as_number = Number(one); 

        var len=num.length;

        if(one_as_number==0)

        {

            $("#pmm_num").attr("maxlength","11");

            if (len < 11 || len > 11) 

            {

                input.setCustomValidity('The number must be eleven digit with 0');

            } 

            else 

            {

                input.setCustomValidity('');

            }

        }

        else

        {

            $("#pmm_num").attr("maxlength","10");

            if (len < 10 || len > 10) 

            {

                input.setCustomValidity('The number must be ten digit without 0');

            } 

            else 

            {

                input.setCustomValidity('');

            }

        }

    }

</script>







