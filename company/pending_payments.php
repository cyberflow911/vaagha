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

    

    $sql="select u.*, p.title, b.p_tandc_date as tncdate, b.sort_code, b.account_num, p.project_reference as p_ref, a.f_name as pmf_name, a.l_name as pml_name from users u, bank_details b, projects p, com_admins a where u.com_id='$COMPANY_ID' and u.pay_status='4' and u.p_id=p.id and u.pm_id=a.id and b.u_id=u.id";    

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

                        <table class="table" id="example2">

                            <thead style="background-color: #212529;">

                                <tr>

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

                                </tr>

                            </thead>

                            <tbody id="userdata"> 

        

                            

                            <?php 

                                    if (isset($users)) 

                                    {

                                        $i = 1;

                                        foreach ($users as $detail) 
                                        {   

                                            $sfirst=substr($detail['sort_code'],0,2);

                                            $ssecond=substr($detail['sort_code'],2,2);

                                            $sthird=substr($detail['sort_code'],4,2);

                                            

                            ?> 

                                            <tr>

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

                    <!-- <center><button class="btn btn-success" style="font-size: 14px; padding: 10px;">Download User Payment File</button> </center> -->

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

    function displayusers(obj)

    {

        var i=1;

        $("#userdata").empty();

        $("#userdata").html(obj.str);

    }

    

</script>





