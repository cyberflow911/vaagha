<?php
    require_once 'header.php';
    require_once 'left-navbar.php';
 
    if(isset($_POST['tncupload']))
    {
        $type=$_POST['type'];
        $uid=$_POST['tncuid'];
        $sql="select p_id from users where id='$uid'";
        if($result =  $conn->query($sql))
        {
            if($result->num_rows)
            {
                $row = $result->fetch_assoc();
                    $pid = $row['p_id'];
            }
        }

        if($type==2)
        {
            if(upload_tandc2($_FILES,$conn,"projects","id","tandcfile",$pid,"projectFile",$website_link."/admin/uploads"))
            {
                $resMember = "all_true";
            }
            else
            {
                $errorMember = "Something Went Wrong (Check your file extension).";
            }
        }
        else if($type==1)
        {
            if(upload_tandc($_FILES,$conn,"projects","id","tandcfile",$pid,"projectFile",$website_link."/admin/uploads"))
            {
                $resMember = "all_true";
            }else
            {
                $errorMember = "Something Went Wrong (Check your file extension).";
            }
        }
    }

    $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, p.project_reference as p_ref, c.l_name as pml_name , p.tandcfile, p.termandcondition, p.signortick from users u, projects p, com_admins c where u.pm_id=p.pm_id and c.id=u.pm_id and u.p_id=p.id and p.pm_id=c.id and u.pay_status=6 order by u.email_date, p.title";  
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
    $sql="select * from projects";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $projects[] = $row;
        }
    }
    $sql="select * from com_admins where type=2";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $pm_name[] = $row;
        }
    }
    $sql="select * from companies";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $company[] = $row;
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
                <div class="col-md-3">
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
                <div class="col-md-3" >
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
                <div class="col-md-3" >
                    <div class="form-group">
                        <label>Company</label><br>
                        <select class="form-control selectpicker" id="company" style="font-size: 16px;" id="pro"  multiple data-live-search="true">
                    <?php
                        if(isset($company))
                        { 
                            foreach($company as $data)
                            {
                                
                    ?>
                            <option value=<?=$data['id']?>><?=$data['com_name']?></option>
                    <?php
                            }
                        }
                    ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label></label><br>
                        <button class="btn btn-primary" onclick="Search()" style="font-size: 12px; padding: 5px;">  <i class="fa fa-search"></i> Search</button> 
                        <button type="button" class="btn btn-danger" onClick="window.location.reload();" style="font-size: 12px; padding: 5px;"><i class="fa fa-trash"></i>&nbspClear</button>
                    </div>
                </div>
            </div>
            <br>
            <div id="showmsg" style="display:none;" class="alert alert-success"></div> 
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
                                    <th scope="col" style="text-align: center;">Upload File</th>
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
                                            <tr id="row<?=$detail['id']?>"> 
                                            <?php
                                            if($detail['termandcondition']==1&&$detail['tandcfile']==""&&($detail['signortick']==1||$detail['signortick']==2))
                                            {
                                            ?>
                                                 <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="<?=$detail['id']?>" disabled></td> 
                                                
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="<?=$detail['id']?>"></td> 
                                            <?php
                                            }
                                            ?>  
                                                <td style="  text-align: center; " id="f_name<?=$i?>"><?=$detail['f_name'];?></td> 
                                                <td style="  text-align: center; " id="l_name<?=$i?>"><?=$detail['l_name'];?></td> 
                                                <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                                                <td style="  text-align: center; " id="m_num<?=$i?>"><?=$detail['m_num'];?></td>
                                                <td style="  text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive'];?></td>
                                                <td style="  text-align: center; " id="title<?=$i?>"><?=$detail['p_title'];?></td>
                                                <td style="  text-align: center; " id="pname<?=$i?>"><?=$detail['pmf_name'];?> <?=$detail['pml_name'];?></td>
                                                <td style="  text-align: center; " id="pay_reference<?=$i?>"><?=$detail['p_ref'];?></td>
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
                                                
                                            <td style="  text-align: center; " id="email_template<?=$i?>"><button type="button" class="btn btn-success"  onclick="template(<?=$detail['id']?>)">
                                            <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                                            <?php
                                            if($detail['termandcondition']==1&&$detail['tandcfile']==""&&($detail['signortick']==1||$detail['signortick']==2))
                                            {
                                            ?>
                                                <td><button type="button" class="btn btn-primary" onclick="uploadfile(<?=$detail['id']?>, <?=$detail['signortick']?>)"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"> <span class="sr-only"></span></div>Upload T&Cs</button></td>
                                                
                                            <?php
                                            }
                                            ?>
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
                <div class="col-md-4">
                  <button class="btn btn-success" onclick="sendmail()" style="font-size: 14px; padding: 10px;"><div class="spinner-border" id="mailspin" style="display: none;" role="status"><span class="sr-only"></span></div>Initiate Email</button>
                </div>
            </div>
        </div>
    </div>
</div>

<button class="btn btn-success" style="display: none;" id="showtemp" style="font-size: 14px; padding: 10px;" data-toggle="modal" data-target="#modal-email-temp"><i class="fa fa-upload"></i></button>
<button class="btn btn-success" style="display: none;" id="uploadfile" style="font-size: 14px; padding: 10px;" data-toggle="modal" data-target="#modal-tncfile"><i class="fa fa-upload"></i></button>


<div class="modal fade" id="modal-email-temp">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <b>User Email Template</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="useremailtemp" style="padding:10px;">
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-tncfile">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Terms and Conditions</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label>Upload File</label><br>  
                                <span style="font-size: 10px; color: gray;">For Sign Accepted format = .docx</span> <br> 
                                <span style="font-size: 10px; color: gray;">For CheckBox Accepted format = .docx, .pdf, .txt</span> 
                                <input type="file" style="font-size: 14px; padding-bottom: 30px;" id='projectfile' name="projectFile[]" class="form-control" >
                                <input type="text" name="type" style="display: none;" id="type" class="form-control"  required>  
                                <input type="text" name="tncuid" style="display: none;" id="tncuid" class="form-control"  required>  
                            </div> 
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin-top:10; width: 90px; height: 30px; font-size: 16px;">Close</button>
                    <button type="submit" name="tncupload" class="btn btn-primary" style="margin-top:10; width: 65px; height: 30px; padding-right:10px; font-size: 16px;">Submit</button>
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
    function template(uid)
    {
        $("#linkspin").show();
        console.log(uid)
        $.ajax({
            url:"emailtemp.php",
            type:"POST",
            
            data:{
                userid:uid
            },
            
            success:function(response)
            {
                var obj=JSON.parse(response);
                $("#useremailtemp").html(`<p><b>To:</b>${obj.user_email}</p>
                    <p><b>CC:</b>${obj.pm_email}</p>
                    <p><b>Subject:</b>${obj.sub}</p><br>
                    <p>${obj.greet}</p><br>
                    <p>${obj.bd}</p><br>
                    <p>${obj.endgreet}</p>
                    <br><br>`)
                $("#showtemp").trigger('click');
                $("#linkspin").hide();
            },
            
            error:function()
            {

            }
        })
    }

    function uploadfile(id, type)
    {
        $("#tncuid").val(id)
        $("#type").val(type)
        $("#uploadfile").trigger('click')
    }

    function Search()
    {
        var manager = $("#pmanager").val();
        var project =$("#project").val();
        var company =$("#company").val();
        if(project=="" && manager!="" && company=="")
        {
            getuser(manager);
        }
        else if(project!="" && manager!="" && company=="")
        {
            getuser2(manager, project)
        }
        else if(project!="" && manager=="" && company=="")
        {
            getuser3(project)
        }
        else if(project=="" && manager=="" && company!="")
        {
            getuser4(company)
        }
        else if(project!="" && manager=="" && company!="")
        {
            getuser5(project, company)
        }
        else if(project=="" && manager!="" && company!="")
        {
            getuser6(manager, company)
        }
        else if(project!="" && manager!="" && company!="")
        {
            getuser7(project, manager, company)
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
    function getuser4(company)
    {
        if(xhrRequest && xhrRequest.readyState != 4){
            xhrRequest.abort();
        }
        xhrRequest =  $.ajax({
            url:"getuserdata.php",
            type:"POST",
            
            data:{
                companyid:company
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
    function getuser5(project, company)
    {
        if(xhrRequest && xhrRequest.readyState != 4){
            xhrRequest.abort();
        }
        xhrRequest =  $.ajax({
            url:"getuserdata.php",
            type:"POST",
            
            data:{
                company:company,
                project:project
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
    function getuser6(manager, company)
    {
        if(xhrRequest && xhrRequest.readyState != 4){
            xhrRequest.abort();
        }
        xhrRequest =  $.ajax({
            url:"getuserdata.php",
            type:"POST",
            
            data:{
                company:company,
                manager:manager
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
    function getuser7(project, manager, company)
    {
        if(xhrRequest && xhrRequest.readyState != 4){
            xhrRequest.abort();
        }
        xhrRequest =  $.ajax({
            url:"getuserdata.php",
            type:"POST",
            
            data:{
                companycheck:company,
                managercheck:manager,
                projectcheck: project
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
        $("#userdata").html(obj.str);
    }
    function sendmail()
    {
        $("#mailspin").show();
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
                    Initiate:true
                },
                success:function(data)
                {
                    $("#mailspin").hide();
                    $("#showmsg").show()
                    $("#showmsg").html("Email Sent Successfully!!")
                    $.each(mails, function(k, v) {
                        $("#row"+v).remove()
                    })
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


