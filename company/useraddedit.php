<?php
    require_once 'header.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['useradd']))
        {
            $f_name=$_POST['userf_name'];
            $l_name=$_POST['userl_name'];
            $m_num=$_POST['userm_num'];
            $salutation=$_POST['salutation'];
            $incentive=$_POST['userincentive'];
            $email=$_POST['useremail'];
            $project=$_POST['userproject'];
            $sql="select pm_id from projects where id='$project'";
            if($result =  $conn->query($sql))
            {
                if($result->num_rows)
                {
                    $row = $result->fetch_assoc();
                    $pmid=$row['pm_id'];
                }
            }
            $sql="insert into users(p_id, pm_id, com_id, salutation, f_name, l_name, email, m_num, incentive, status, pay_status) values('$project', '$pmid',  '$COMPANY_ID', '$salutation', '$f_name', '$l_name', '$email', '$m_num', '$incentive', '1', 6)";
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

    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token=$_GET['token'];
        
        if(isset($_POST['edit']))
        {  
            $f_name=$_POST['userf_name'];
            $l_name=$_POST['userl_name'];
            $m_num=$_POST['userm_num'];
            $salutation=$_POST['salutation'];
            $incentive=$_POST['userincentive'];
            $email=$_POST['useremail'];
            $project=$_POST['userproject'];
            
            $sql="update users set salutation='$salutation', email='$email', p_id='$project', m_num='$m_num', f_name='$f_name', l_name='$l_name', incentive='$incentive'  where id='$token'";
            if($conn->query($sql))
            {
                $resMember  = "true";
            }
            else
            {
                $errorMember=$conn->error;
            }
        } 
        $sql = "select u.*, p.title, p.id as pid, p.project_reference as p_ref from users u, projects p where u.id='$token' and u.com_id='$COMPANY_ID' and u.p_id=p.id";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $user_details  = $result->fetch_assoc();  
            } 
        }
        else
        {
            $errorMember=$conn->error;
        }
        
    }
    
    $sql="select * from projects where cm_id='$COMPANY_ID'";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $projects[] = $row;
        }
    }
    $sql="select * from salutation";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $sal[] = $row;
        }
    }
       
    
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
                <div class="breadcrumb-title pr-3">User Details</div>
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
            <form method="post">
                <div class="card radius-15 border-lg-top-primary">
                    <div class="card-body p-5">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label>Salutation</label>
                                        <select name="salutation" id="salutation" style="font-size: 16px;" class="form-control" required>
                                            <?php
                                            if(isset($sal))
                                            {
                                                foreach($sal as $data)
                                                {
                                                    $selected=" ";
                                                    if($data['salutation']==$user_details['salutation'])
                                                    {
                                                        $selected="selected";
                                                    }
                                            ?>
                                                    <option <?=$selected?> value="<?=$data['salutation']?>"><?=$data['salutation']?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>  
                                    </div> 
                                </div> 
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label>First Name</label><br>   
                                        <input type="text" minlength="2" value="<?=$user_details['f_name']?>" maxlength="50" style="font-size: 16px;"  id="userf_name" name="userf_name" class="form-control" required>  
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label>Last Name</label><br>   
                                        <input type="text" minlength="2" value="<?=$user_details['l_name']?>"  maxlength="50" style="font-size: 16px;"  id="userl_name" name="userl_name" class="form-control"  required>  
                                    </div> 
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label>Email</label><br>   
                                        <input type="email" style="font-size: 16px;" value="<?=$user_details['email']?>"  id="useremail"  name="useremail" class="form-control"  required>  
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label>Mobile Number</label><br>   
                                        <input type="number" style="font-size: 16px;" value="<?=$user_details['m_num']?>"  id="userm_num" onchange="check(this)" name="userm_num" class="form-control"  required>  
                                    </div> 
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label>Incentive</label><br>   
                                        <input type="text" style="font-size: 16px;"  id="userincentive" name="userincentive" value="<?=$user_details['incentive']?>"  minlength='3' maxlength='5' class="form-control" required>  
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label>Projects</label><br> 
                                        <select name="userproject" oninput="projectRef()" id="userproject" style="font-size: 16px;"  class="form-control">
                                        <option value=" ">Select</option>
                                        <?php
                                            if(isset($projects))
                                            {
                                                foreach($projects as $data)
                                                {    
                                                    $selected=" ";  
                                                    if($data['id']==$user_details['pid'])
                                                    {
                                                        $selected="selected";
                                                    }    
                                                        
                                        ?>
                                                        <option value="<?=$data['id']?>" <?=$selected?>><?=$data['title']?></option>
                                        <?php
                                                    
                                                }
                                            }
                                            else
                                            {
                                        ?>
                                                <a href="projectdetails.php" class="btn btn-primary">Add Project</a>
                                        <?php
                                            }
                                        ?>  
                                        </select> 
                                    </div> 
                                </div> 
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label>Project Reference</label><br>   
                                        <input type="text" value="<?=$user_details['p_ref']?>"  style="font-size: 16px;"  id="userpro_ref" name="userpro_ref" class="form-control" readonly>  
                                    </div> 
                                </div> 
                            </div>
                            <?php
                                    if(isset($user_details))
                                    {
                            ?>
                                    <button type="submit" name="edit" style="width: 60px; height: 30px; font-size: 16px;" class="btn btn-primary" value="">Save</button>
                            <?php
                                }
                                else
                                {
                            ?>
                                        
                                <button type="submit" style="width: 60px; height: 30px; font-size: 16px;" name="useradd" class="btn btn-primary" value="">Add</button>
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
    function projectRef(input)
    {
        var pid=$('#userproject').val();
         getprojectdata(pid);
    }
    function getprojectdata(id)
    {
        $.ajax({
            url:"managerdata.php",
            type:"POST",
            
            data:{
                projectdata:id
            },
            success:function(response){
                var obj=JSON.parse(response);
            var project_reference = obj.project_reference;
            var incentive = obj.incentive;
            $("#userpro_ref").val(project_reference);
            $("#userincentive").val(incentive);
            },
            error:function()
            {

            }
        
        })
    }

    function check(input)
    {
        var num=$("#userm_num").val();
        var one = String(num).charAt(0);
        var one_as_number = Number(one); 
        var len=num.length;
        if(one_as_number==0)
        {
            $("#userm_num").attr("maxlength","11");
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
            $("#userm_num").attr("maxlength","10");
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
