<?php
    require_once 'header.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    $sql="select u.*, p.title from users u, projects p where u.pm_id='$MANAGER_ID' and u.pay_status='3' and u.p_id=p.id and p.termandcondition=1 and p.signortick=1 and u.pm_id=p.pm_id";    
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
    $sql="select * from projects where pm_id='$MANAGER_ID'";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $projects[] = $row;
        }
    }
    $date=date("Y-m-d");
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
                                            $date1 = $detail['email_date'];
                                            
                                            $dateDiff = dateDiffInDays($date1, $date);
                                            if($dateDiff==0)
                                            {
                                                $dateDiff="Today";
                                            } 
                                            if($detail['email_date']=="0000-00-00")
                                            {
                                                $dateDiff="NA";
                                            }
                            ?> 
                                            <tr id="row<?=$detail['id']?>"> 
                                                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="<?=$detail['id']?>"></td> 
                                                <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['f_name'];?></td> 
                                                <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['l_name'];?></td> 
                                                <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                                                <td style="  text-align: center; " id="m_num<?=$i?>"><?=$detail['m_num'];?></td>
                                                <td style="  text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive'];?></td>
                                                <td style="  text-align: center; " id="p_title<?=$i?>"><?=$detail['title'];?></td>
                                                <td style="  text-align: center; " id="email_date<?=$i?>"><?=$detail['email_date'];?></td>
                                                <td style="  text-align: center; " id="email_days<?=$i?>"><?=$dateDiff?></td>
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
    var xhrRequest;
    var xhr;
    function Search()
    {
        var project =$("#project").val();
       getuser(project)
    } 
    function getuser(project)
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
        $("#userdata").html(obj.str)
    }
    function sendmail()
    {
        $("#mailspin").show()
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
                    tandc:true,
                    usercomid: <?=$MANAGERCOM_ID?>
                },
                success:function(data)
                {
                    $("#mailspin").hide()
                    $("#showmsg").show()
                    $("#showmsg").html("Email Sent Successfully!!")
                },
                error:function(data){}
            })
        }
    }
</script>

