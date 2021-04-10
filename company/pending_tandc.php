<?php
    require_once 'header.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['useradd']))
        {
            $name=$_POST['username'];
            $m_num=$_POST['userm_num'];
            $address=$_POST['useraddress'];
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
            $sql="insert into users(pm_id, name,  m_num, address, com_id, p_id, email, status) values('$pmid', '$name',  '$m_num', '$address', '$COMPANY_ID', '$project', '$email', '1')";
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
    
    $sql="select u.*, p.title, a.f_name as pmf_name, a.l_name as pml_name from users u, projects p, com_admins a where u.com_id='$COMPANY_ID' and u.pay_status='3' and u.p_id=p.id and u.pm_id=a.id and p.termandcondition=1 and p.signortick=1";    
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
</style>
<div class="page-wrapper">
	<div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Pending Terms and Conditions</div>
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
			<div class="row" style="margin-top: 40px;">
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
                <div class="col-md-4">
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
                        <button class="btn btn-primary" onclick="Search()" style="font-size: 12px; padding: 5px;">  <i class="fa fa-search"></i> Search</button> 
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label></label><br>
                        <button type="button" class="btn btn-danger" onClick="window.location.reload();" style="font-size: 12px; padding: 5px;"><i class="fa fa-trash"></i>&nbspClear</button> 
                    </div>
                </div>
            </div>
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
                                    <th scope="col" style="text-align: center;">Email Sent Date</th>
                                    <th scope="col" style="text-align: center;">Days Email Sent</th>
                                </tr>
                            </thead>
                            <tbody id="userdata"> 
        
                            
                            <?php 
                                    if (isset($users)) 
                                    {
                                        $i = 1;
                                        foreach ($users as $detail) 
                                        {   
                                            // $datetime1 = new DateTime(date($detail['email_date']));
                                            // $datetime2 = new DateTime(date("d-m-Y"));
                                            // $interval = $datetime1->diff($datetime2);
                                            // $days= $interval->format('%a');  
                            ?> 
                                            <tr> 
                                                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="<?=$detail['id']?>"></td> 
                                                <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['f_name'];?></td> 
                                                <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['l_name'];?></td> 
                                                <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                                                <td style="  text-align: center; " id="m_num<?=$i?>"><?=$detail['m_num'];?></td>
                                                <td style="  text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive'];?></td>
                                                <td style="  text-align: center; " id="p_title<?=$i?>"><?=$detail['title'];?></td>
                                                <td style="  text-align: center; " id="pm_name<?=$i?>"><?=$detail['pmf_name'];?> <?=$detail['pml_name'];?></td>
                                                <td style="  text-align: center; " id="email_date<?=$i?>"><?=$detail['email_date'];?></td>
                                                <td style="  text-align: center; " id="email_days<?=$i?>">0</td>
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
                    <center><button class="btn btn-success" onclick="sendmail()" style="font-size: 14px; padding: 10px;">Send Reminder Email</button> </center>
                </div>
            </div>
        </div>
    </div>
</div>
  

<?php
    require_once 'js-links.php';
?>

<script>
    var xhrRequest;
    var xhr;
    function Search()
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
            url:"pendtandcajax.php",
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
            url:"pendtandcajax.php",
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
            
            url:"pendtandcajax.php",
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
                <td style="  text-align: center; " id="name${i}">${v.f_name}</td> 
                <td style="  text-align: center; " id="name${i}">${v.l_name}</td> 
                <td style="  text-align: center; " id="email${i}">${v.email}</td> 
                <td style="  text-align: center; " id="m_num${i}">${v.m_num}</td>
                <td style="  text-align: center; " id="incentive${i}">${v.incentive}</td>
                <td style="  text-align: center; " id="p_title${i}">${v.p_title}</td>
                <td style="  text-align: center; " id="pm_name${i}">${v.pmf_name} ${v.pml_name}</td>
                <td style="  text-align: center; " id="pay_reference${i}">${v.pay_reference}</td>
                <td style="  text-align: center; " id="tandc${i}">${v.tnc}</td> </tr>`)
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
</script>

