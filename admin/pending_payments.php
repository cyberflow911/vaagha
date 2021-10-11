<?php

    require_once 'header.php';

    require_once 'left-navbar.php';

    

    if ( isset($_POST["userbulkadd"]) ) 

    {

        if ( isset($_FILES["file"])) 

        {
            echo "cehcli";

            //if there was an error uploading the file

            if ($_FILES["file"]["error"] > 0) 

            {

                echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

            }

            else 

            {

                

                //if file already exists

                if (file_exists("upload/" . $_FILES["file"]["name"])) {

                echo $_FILES["file"]["name"] . " already exists. ";

                }

                else 

                {

                    //Store file in directory "upload" with the name of "uploaded_file.txt"

                    $storagename = "uploaded_file.txt";

                    move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $storagename);

                }

            }

        } 

        else 

        {

            echo "No file selected <br />";

        }

        $rcount=1;

        $count=1;

        if ( isset($storagename) && (($handle = fopen("uploads/" . $storagename , r )) !== FALSE) ) 

        {

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 

            {

                if($rcount==1)
                {
                    $rcount++;
                    continue;
                }

                $num = count($data);

                $rcount++;
                $uemail=$data[1];
                $pref=$data[2];
                $scode=$data[8];
                $account_num = $data[9];
                $p_date = $data[10];
                $sql="SELECT u.id as uid from users u, bank_details b, projects p where u.email='$uemail' and p.project_reference='$pref' and b.sort_code='$scode' and b.account_num='$account_num' and b.u_id=u.id and u.p_id=p.id and b.p_id=p.id";
                if($result=$conn->query($sql))
                {
                    if($result->num_rows)
                    {
                        $row=$result->fetch_assoc();
                            $uid = $row['uid'];
                        $sql="UPDATE users set pay_status=5, paid_date='$p_date' where id='$uid'";
                        if($conn->query($sql))
                        {
                            $sql="update bank_details set status=5 where u_id='$uid'";
                            if($conn->query($sql))
                            {
                                $count++;
                            }
                            else
                            {
                                $error[]=$rcount-1;
                            }
                        }
                        else
                        {
                            $error[]=$rcount-1;
                        }
                    }
                    else
                    {
                        $error[]=$rcount-1;
                    }
                }
                else
                {
                    $error[]=$rcount-1;
                }
            }
            $err = "".implode($error,",")." ";
           
            if($rcount==$count+1)
            {
                $resMember=true;

            }

            // else

            // {

            //     $errorMember="Something Went Wrong!! Check Data At Row(s): $err";

            // }

            

            fclose($handle);

        }

    }



    $sql="select u.*, p.title, b.p_tandc_date as tncdate,  b.sort_code, b.account_num, p.project_reference as p_ref, a.f_name as pmf_name, a.l_name as pml_name from users u, bank_details b, projects p, com_admins a where u.pay_status='4' and u.p_id=p.id and u.pm_id=a.id and b.u_id=u.id";    

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

                <div class="breadcrumb-title pr-3">Pending Payments</div>

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
            <div id="showsmsg" style="display:none;" class="alert alert-success"></div> 
            <div id="showemsg" style="display:none;" class="alert alert-danger"></div>             
            
            <br>

            <h2>User Details</h2>

            <br>

            <div class="card radius-15">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table" id="example2">

                            <thead style="background-color: #212529;">

                                <tr>
                                    <th scope="col" style="text-align: center;">Select</th>

                                    <th scope="col" style="text-align: center;">name</th>

                                    <th scope="col" style="text-align: center;">recipientEmail</th>

                                    <th scope="col" style="text-align: center;">paymentReference</th>

                                    <th scope="col" style="text-align: center;">receiverType</th>

                                    <th scope="col" style="text-align: center;">amountCurrency</th>

                                    <th scope="col" style="text-align: center;">amount</th>

                                    <th scope="col" style="text-align: center;">sourceCurrency</th>

                                    <th scope="col" style="text-align: center;">targetCurrency</th>

                                    <th scope="col" style="text-align: center;">sortCode</th>

                                    <th scope="col" style="text-align: center;">accountNumber</th>
                                    <th scope="col" style="text-align: center;">apiErrorCode</th>
                                    <th scope="col" style="text-align: center;">userErrorMessage</th>

                                    <th scope="col" style="text-align: center;">Mark as Paid</th>

                                </tr>

                            </thead>

                            <tbody id="userdata"> 

        

                            

                            <?php 

                                    if (isset($users)) 

                                    {

                                        $i = 1;

                                        foreach ($users as $detail) 

                                        {   

                                            $date1 = $detail['tncdate'];

                                            

                                            $dateDiff = dateDiffInDays($date1, $date);

                                            if($dateDiff==0)

                                            {

                                                $dateDiff="Today";

                                            }

                                            $sfirst=substr($detail['sort_code'],0,2);

                                            $ssecond=substr($detail['sort_code'],2,2);

                                            $sthird=substr($detail['sort_code'],4,2);

                            ?> 

                                            <tr id="row<?=$detail['id']?>">
                                                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="<?=$detail['id']?>"></td> 

                                                <td style="  text-align: center; " id="f_name<?=$i?>"><?=$detail['f_name'];?> <?=$detail['l_name'];?></td> 

                                                <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 

                                                <td style="  text-align: center; " id="p_ref<?=$i?>"><?=$detail['p_ref'];?></td>

                                                <td style="  text-align: center; " id="receiver<?=$i?>">PERSON</td>

                                                <td style="  text-align: center; " id="source<?=$i?>">SOURCE</td>

                                                <td style="  text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive']?></td>

                                                <td style="  text-align: center; " id="source_currency<?=$i?>">GBP</td>

                                                <td style="  text-align: center; " id="target_currency<?=$i?>">GBP</td>

                                                <td style="  text-align: center; " id="sort_code<?=$i?>"><?=$sfirst?>-<?=$ssecond?>-<?=$sthird?></td>

                                                <td style="  text-align: center; " id="acc_num<?=$i?>"><?=$detail['account_num'];?></td>
                                                <td style="  text-align: center; " id="errorcode<?=$i?>"></td>
                                                <td style="  text-align: center; " id="errormsg<?=$i?>"></td>

                                                <td style="  text-align: center; " id="paid<?=$i?>"><button type="button" onclick="paidcheck(<?=$detail['id']?>)" class="btn btn-success" ><i class="fa fa-check"></i>&nbspPaid</button></td>

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
                    <button data-toggle="modal" data-target="#modal-bulkpaid" class="btn btn-success" style="font-size: 14px; padding: 10px;">Mark as Paid</button>
                </div>
                <div class="col-md-4">
                    <button data-toggle="modal" data-target="#modal-bulkupload" class="btn btn-success" style="font-size: 14px; padding: 10px;">Bulk Upload</button>
                </div>
                <div class="col-md-4">
                <form method="get" action="../files/Paid_user_template.csv">

                <button class="btn btn-success"  style="font-size: 14px; padding: 10px;">Download Bulk Upload Template</button></form>
                </div>

            </div>

        </div>

    </div>

</div>

<button class="btn btn-success" style="display: none;" id="showmodal" style="font-size: 14px; padding: 10px;" data-toggle="modal" data-target="#modal-paidcheck"><i class="fa fa-upload"></i></button>


<div class="modal fade" id="modal-paidcheck">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Mark as Paid</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label>Paid Date</label><br>  
                                <input type="date" id="pdate" style="font-size: 16px" class="form-control"  required>
                                <input type="text" name="tncuid" style="display: none;" id="puid" class="form-control"  required>  
                            </div> 
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="mclose" class="btn btn-default pull-left" data-dismiss="modal" style="margin-top:10; width: 90px; height: 30px; font-size: 16px;">Close</button>
                    <button type="button" onclick="movetopaid()" class="btn btn-primary" style="margin-top:10; width: 65px; height: 30px; padding-right:10px; font-size: 16px;">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> 
<div class="modal fade" id="modal-bulkpaid">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Mark as Paid</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label>Paid Date</label><br>  
                                <input type="date" id="pbulkdate" style="font-size: 16px" class="form-control"  required>
                            </div> 
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="mbulkclose" class="btn btn-default pull-left" data-dismiss="modal" style="margin-top:10; width: 90px; height: 30px; font-size: 16px;">Close</button>
                    <button type="button"  onclick="markpaidbulk()" class="btn btn-primary" style="margin-top:10; width: 65px; height: 30px; padding-right:10px; font-size: 16px;">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> 

<div class="modal fade" id="modal-bulkupload">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add CSV File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label>Select File</label><br>   
                                <input type="file" name="file" style="font-size: 14px; padding-bottom: 30px;" id="file" class="form-control"  required>  
                            </div> 
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin-top:10; width: 90px; height: 30px; font-size: 16px;">Close</button>
                    <button type="submit" name="userbulkadd" class="btn btn-primary" style="margin-top:10; width: 65px; height: 30px; padding-right:10px; font-size: 16px;">Save</button>
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

            url:"pendpayajax.php",

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

            url:"pendpayajax.php",

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

            url:"pendpayajax.php",

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

            url:"pendpayajax.php",

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

            url:"pendpayajax.php",

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

            url:"pendpayajax.php",

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

            url:"pendpayajax.php",

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

    function paidcheck(uid)
    {
        $("#puid").val(uid)
        $("#showmodal").trigger("click")
        // $("#modal-paidcheck").modal('show')
    }

    function movetopaid()
    {
        var uid=$("#puid").val();
        var pdate=$("#pdate").val()
        $.ajax({
            url:"pendpayajax.php",
            type:"POST",
            
            data:{
                checkpaid:true,
                user_id:uid,
                paiddate: pdate
            },
            
            success:function(response)
            {
                var obj=JSON.parse(response);
                $("#mclose").trigger("click")
                $(".modal-backdrop.show").attr('class','modal-backdrop fade')
                // $("#modal-paidcheck").modal('hide')
                if(obj.msg=="ok")
                {
                    $("#showsmsg").show();
                    $("#showsmsg").html("User Moved successfully");
                    $("#row"+uid).remove();
                }
                else if(obj.msg=="error")
                {
                    $("#showemsg").show();
                    $("#showemsg").html("Error");
                }
            },
            
            error:function()
            {

            }
        })
    }

    function markpaidbulk()
    {
        var pbulkdate=$("#pbulkdate").val()
        if($('input[type="checkbox"]:checked'))
        {
            var mails = [];
           $('input[type="checkbox"]:checked').each(function(){
                mails.push($(this).val());
            })
        }
        $.ajax({
            url:"pendpayajax.php",
            type:'POST',
            data:
            {
                id:JSON.stringify(mails),
                bulkmarkpaid:true,
                bulkdate: pbulkdate
            },
            success:function(data)
            {
                $("#mbulkclose").trigger('click');
                $(".modal-backdrop.show").attr('class','modal-backdrop fade')
                $("#showsmsg").show()
                $("#showsmsg").html("User Moved Successfully!!")
                $.each(mails, function(k, v) {
                    $("#row"+v).remove()
                })
            },
            error:function(data){}
        })
    }

</script>





