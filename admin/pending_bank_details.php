<?php

    require_once 'header.php';

    require_once 'left-navbar.php';

 

    $id=$_SESSION['id'];

    

    $sql="select u.*, p.title, a.f_name as pmf_name, a.l_name as pml_name from users u, projects p, com_admins a where u.pay_status='1' and u.p_id=p.id and u.pm_id=a.id order by u.email_date";    

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

    $date = date("Y-m-d");

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

                <div class="breadcrumb-title pr-3">Pending Bank Details</div>

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

                                    <th scope="col" style="text-align: center;">Email Sent Date</th>

                                    <th scope="col" style="text-align: center;">Days Email Sent</th>

                                    <th scope="col" style="text-align: center;">Fill Bank Details</th>

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

                                            

                                            $dateDiff = dateDiffInDays($date1, $date);

                                            if($dateDiff==0)

                                            {

                                                $dateDiff="Today";

                                            }

                            ?> 

                                            <tr> 

                                                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="<?=$detail['id']?>"></td> 

                                                <td style="  text-align: center; " id="f_name<?=$i?>"><?=$detail['f_name'];?></td> 

                                                <td style="  text-align: center; " id="l_name<?=$i?>"><?=$detail['l_name'];?></td> 

                                                <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 

                                                <td style="  text-align: center; " id="m_num<?=$i?>"><?=$detail['m_num'];?></td>

                                                <td style="  text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive'];?></td>

                                                <td style="  text-align: center; " id="p_title<?=$i?>"><?=$detail['title'];?></td>

                                                <td style="  text-align: center; " id="pm_name<?=$i?>"><?=$detail['pmf_name'];?> <?=$detail['pml_name'];?></td>

                                                <td style="  text-align: center; " id="email_date<?=$i?>"><?=$detail['email_date'];?></td>

                                                <td style="  text-align: center; " id="email_days<?=$i?>"><?=$dateDiff?></td>

                                                <td><a target="_blank" class="btn btn-primary" href="../company/bankdetails?uid=<?=$detail['id']?>">Fill Bank Details</a></td>

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

                    <center><button class="btn btn-success" onclick="sendmail()" style="font-size: 14px; padding: 10px;"><div class="spinner-border" id="mailspin" style="display: none;" role="status"><span class="sr-only"></span></div>Send Reminder Email</button> </center>

                </div>

            </div>

        </div>

    </div>

</div>

  



<?php

    require_once 'js-links.php';

?>



<script>

    var xhr;

    var xhrRequest;

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

            url:"pendbankdajax.php",

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

            url:"pendbankdajax.php",

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

            url:"pendbankdajax.php",

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

            url:"pendbankdajax.php",

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

            url:"pendbankdajax.php",

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

            url:"pendbankdajax.php",

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

            url:"pendbankdajax.php",

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

        $("#userdata").empty();

        $("#userdata").html(obj.str)

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

                    bankdetails:true

                },

                success:function(data)

                {

                    $("#mailspin").hide();

                    $("#showmsg").show()

                    $("#showmsg").html("Email Sent Successfully!!")

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







