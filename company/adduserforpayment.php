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
            $incentive=$_POST['incentive'];
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
            $sql="insert into users(p_id, pm_id, com_id, salutation, f_name, l_name, email, m_num, incentive, status) values('$project', '$pmid',  '$COMPANY_ID', '$salutation', '$f_name', '$l_name', '$email', '$m_num', '$incentive', '1')";
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
    
 
    $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, c.l_name as pml_name , p.termandcondition as tnc from users u, projects p, com_admins c where u.com_id='$COMPANY_ID' and u.pm_id=p.pm_id and c.id=u.pm_id and u.p_id=p.id and p.pm_id=c.id and u.pay_status=6 order by u.email_date";  
    if($result =  $conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $users[] = $row;
            }
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
    $sql="select * from com_admins where c_id='$COMPANY_ID' and type=2";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $pm_name[] = $row;
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
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3" >
                <div class="breadcrumb-title pr-3">Users to Capture Bank Details</div>
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
                    <button title="" class="btn btn-primary" style="margin-right: 5px; font-size: 12px; padding: 5px;"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-user-plus"></i>Add User</button>
                        <a href="" data-toggle="tooltip" class="btn btn-primary" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>  
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
			<div class="row" style="margin-top: 40px; padding: 30px;">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Project Manager</label><br>
                        <select class="form-control selectpicker" id="pmanager"  multiple data-live-search="true">
                    <?php
                        if(isset($pm_name))
                        { 
                            foreach($pm_name as $data)
                            {
                                
                    ?>
                            <option value=<?=$data['id']?>><?=$data['f_name']?> <?=$data['l_name']?>-<?=$data['email']?></option>
                    <?php
                            }
                        }
                    ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-4" >
                    <div class="form-group">
                        <label>Projects</label><br>
                        <select class="form-control selectpicker" id="project" style="font-size: 16px;" id="pro"  multiple data-live-search="true">
                    <?php
                        if(isset($projects))
                        { 
                            foreach($projects as $data)
                            {
                                
                    ?>
                            <option value=<?=$data['id']?>><?=$data['title']?></option>
                    <?php
                            }
                        }
                    ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label></label><br>
                        <button class="btn btn-primary" onclick="pManager()" style="font-size: 12px; padding: 5px;">  <i class="fa fa-search"></i> Search</button> 
                        <button type="button" class="btn btn-danger" onClick="window.location.reload();" style="font-size: 12px; padding: 5px;"><i class="fa fa-trash"></i>&nbspClear</button>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <h2>User Details</h2>
            <br>
            <div class="card radius-15">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead style="background-color: #212529;">
                                <tr>
                                    <th scope="col" style="text-align: center;">Select</th>
                                    <th scope="col" style="text-align: center;">First Name</th>
                                    <th scope="col" style="text-align: center;">Last Name</th>
                                    <th scope="col" style="text-align: center;">Email</th>
                                    <th scope="col" style="text-align: center;">Phone Number</th>
                                    <th scope="col" style="text-align: center;">Incentive</th>
                                    <th scope="col" style="text-align: center;">Project Title</th>
                                    <th scope="col" style="text-align: center;">Project Manager</th>
                                    <th scope="col" style="text-align: center;">Payment Reference</th>
                                    <th scope="col" style="text-align: center;">T&C'S</th>
                                    <th scope="col" style="text-align: center;">Email Template</th>
                                </tr>
                            </thead>
                            <tbody id="userdata"> 
        
                            
                            <?php 
                                    if (isset($users)) 
                                    {
                                        $i = 1;
                                        foreach ($users as $detail) 
                                        {   
                                            
                                            $date1 = $detail['email_date'];
                                            $date2 = date("Y-m-d");
                                            $dateDiff = dateDiffInDays($date1, $date2);
                                                
                            ?> 
                                            <tr> 
                                                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="<?=$detail['id']?>"></td> 
                                                <td style="  text-align: center; " id="f_name<?=$i?>"><?=$detail['f_name'];?></td> 
                                                <td style="  text-align: center; " id="l_name<?=$i?>"><?=$detail['l_name'];?></td> 
                                                <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                                                <td style="  text-align: center; " id="m_num<?=$i?>"><?=$detail['m_num'];?></td>
                                                <td style="  text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive'];?></td>
                                                <td style="  text-align: center; " id="title<?=$i?>"><?=$detail['p_title'];?></td>
                                                <td style="  text-align: center; " id="pname<?=$i?>"><?=$detail['pmf_name'];?> <?=$detail['pml_name'];?></td>
                                                <td style="  text-align: center; " id="pay_reference<?=$i?>"><?=$detail['pay_reference'];?></td>
                                            <?php
                                            if($detail['tnc']==1)
                                            {
                                            ?>
                                                <td style="  text-align: center; " id="tandc<?=$i?>">Yes</td>
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                                <td style="  text-align: center; " id="tandc<?=$i?>">No</td>
                                            <?php
                                            }
                                            ?>
                                                
                                                <td style="  text-align: center; " id="email_template<?=$i?>">link</td>
                                            </tr>
                                        
                                    <?php
                                        $i++;            
                                        }
                                    }
                                ?>
                
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-12">
                   <center> <button class="btn btn-success" onclick="sendmail()" style="font-size: 14px; padding: 10px;">Initiate Email</button>
                    <button class="btn btn-success"  style="font-size: 14px; padding: 10px;">Download Bulk Upload Template</button>
                    <button class="btn btn-success"  style="font-size: 14px; padding: 10px;">Bulk Upload Users</button></center>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <b>Add New User</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label>Salutation</label>
                                <select name="salutation" id="salutation" style="font-size: 16px;" class="form-control" onchange="check()" required>
                                    <option value=" ">Select</option>
                                    <option value="Mr.">Mr</option>
                                    <option value="Mrs.">Mrs</option>
                                    <option value="Miss.">Miss</option>
                                    <option value="Dr.">Dr</option>
                                    <option value="no">Prefer not to say</option>
                                </select>  
                            </div> 
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label>First Name</label><br>   
                                <input type="text" minlength="2" maxlength="50" style="font-size: 16px;"  id="userf_name" name="userf_name" class="form-control" required>  
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label>Last Name</label><br>   
                                <input type="text" minlength="2" maxlength="50" style="font-size: 16px;"  id="userl_name" name="userl_name" class="form-control"  required>  
                            </div> 
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label>Email</label><br>   
                                <input type="email" style="font-size: 16px;"  id="useremail"  name="useremail" class="form-control"  required>  
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label>Mobile Number</label><br>   
                                <input type="number" style="font-size: 16px;"  id="userm_num"  name="userm_num" class="form-control" value="0" required>  
                            </div> 
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label>Incentive</label><br>   
                                <input type="text" style="font-size: 16px;"  id="userincentive" name="userincentive" minlength='3' maxlength='5' class="form-control" required>  
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
                                <input type="text" style="font-size: 16px;"  id="userpro_ref" name="userpro_ref" class="form-control" readonly>  
                            </div> 
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;">Close</button>
                    <button type="submit" name="useradd" class="btn btn-primary" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>


  

<?php
    require_once 'js-links.php';
?>

<script>
    var xhrRequest;
    var xhr;
    function pManager()
    {
        var manager = $("#pmanager").val();
        var project =$("#project").val();
        console.log(manager)
        if(project=="" && manager!="")
        {
            getuser(manager);
        }
        else if(project!="" && manager!="")
        {
            getuser2(manager, project)
        }
        else if(project!="" && manager=="")
        {
            getuser3(project)
        }
    } 
    function getuser(manager)
    {
        if(xhrRequest && xhrRequest.readyState != 4)
        {
            xhrRequest.abort();
        }
        xhrRequest =  $.ajax({
            url:"getuserdata.php",
            type:"POST",
            
            data:{
                managerid:manager
            },
            success:function(response)
            {
                var obj=JSON.parse(response);
                displayusers(obj);
            },
            error:function()
            {

            }
        })
    }
    function getuser2(manager, project)
    {
        if(xhr && xhr.readyState != 4){
            xhr.abort();
        }
        xhr =  $.ajax({
            url:"getuserdata.php",
            type:"POST",
            
            data:{
                manager:manager,
                project:project
            },
            success:function(response){
            var obj2=JSON.parse(response);
            displayusers(obj2);
            },
            error:function()
            {

            }
        
        })
    }
    function getuser3(project)
    {
        if(xhrRequest && xhrRequest.readyState != 4){
            xhrRequest.abort();
        }
        xhrRequest =  $.ajax({
            url:"getuserdata.php",
            type:"POST",
            
            data:{
                projectid:project
            },
            
            success:function(response)
            {
                var obj=JSON.parse(response);
                displayusers(obj);
            },
            
            error:function()
            {

            }
        })
    }
    function displayusers(obj)
    {
        var i=1;
        $("#userdata").empty();
            $.each(obj,function(k, v)
            {
                $("#userdata").append(`<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo${i}"><input type="checkbox" id="checkbox" value="${v.id}"></td> 
                <td style="  text-align: center; " id="f_name${i}">${v.f_name}</td> 
                <td style="  text-align: center; " id="l_name${i}">${v.l_name}</td> 
                <td style="  text-align: center; " id="email${i}">${v.email}</td> 
                <td style="  text-align: center; " id="m_num${i}">${v.m_num}</td>
                <td style="  text-align: center; " id="incentive${i}">${v.incentive}</td>
                <td style="  text-align: center; " id="p_title${i}">${v.p_title}</td>
                <td style="  text-align: center; " id="pm_name${i}">${v.pmf_name} ${v.pml_name}</td>
                <td style="  text-align: center; " id="pay_reference${i}">${v.pay_reference}</td>
                <td style="  text-align: center; " id="tandc${i}">${v.tnc}</td>
                <td style="  text-align: center; " id="email_template${i}">link</td> </tr>`)
                i++;
            })
    }
    function sendmail()
    {
        if($('input[type="checkbox"]:checked'))
        {
            var mails = [];
           $('input[type="checkbox"]:checked').each(function(){
                mails.push($(this).val());
            })

            $.ajax({
                url:"send_mail_ajax.php",
                type:'POST',
                data:
                {
                    emails:JSON.stringify(mails),
                    sendMail:true,
                    invite:true
                },
                success:function(data)
                {
                    console.log(data);
                },
                error:function(data){}
            })
        }
    }
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
</script>


