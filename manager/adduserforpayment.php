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

            $sql="select cm_id from projects where id='$project'";

            if($result =  $conn->query($sql))

            {

                if($result->num_rows)

                {

                    $row = $result->fetch_assoc();

                    $cmid=$row['cm_id'];

                }

            }

            $sql="insert into users(p_id, pm_id, com_id, salutation, f_name, l_name, email, m_num, incentive, status, pay_status) values('$project', '$MANAGER_ID',  '$cmid', '$salutation', '$f_name', '$l_name', '$email', '$m_num', '$incentive', '1', '6')";

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

                if(upload_tandc2($_FILES,$conn,"projects","id","tandcfile",$pid,"projectFile",$website_link."/manager/uploads"))

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

                if(upload_tandc($_FILES,$conn,"projects","id","tandcfile",$pid,"projectFile",$website_link."/manager/uploads"))

                {

                    $resMember = "all_true";

                }else

                {

                    $errorMember = "Something Went Wrong (Check your file extension).";

                }

            }

        }

    

    if ( isset($_POST["userbulkadd"]) ) 

    {



        if ( isset($_FILES["file"])) 

        {

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

            // $sql = "insert into users(salutation, f_name, l_name, email, m_num, p_id, incentive,pm_id, com_id, status, pay_status) values";

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 

            {

                if($rcount==1)

                {

                    $rcount++;

                    continue;

                    

                }

                $num = count($data);

                $rcount++;

                // $sql.="('".implode($data,"','")."'),";

                $pm_email=$data[5];

                if($pm_email==$MANAGER_EMAIL)

                {

                    $p_ref=$data[1];

                    $sql="select * from projects where project_reference='$p_ref' and pm_id='$MANAGER_ID' and cm_id='$MANAGERCOM_ID'";

                    if($result = $conn->query($sql))

                    {

                        if($result->num_rows>0)

                        {

                            $row=$result->fetch_assoc();

                            $pid=$row['id'];

                            $sql="select * from users where p_id='$pid' and pm_id='$MANAGER_ID' and email='$data[15]' and com_id='$MANAGERCOM_ID'";

                            if($result = $conn->query($sql))

                            {

                                if($result->num_rows>0)

                                {  

                                    $count++; 

                                    continue;  

                                }

                                else

                                {

                                    $sql = "insert into users(salutation, f_name, l_name, email, m_num, pm_id, p_id, com_id, status, pay_status, incentive) values('$data[12]','$data[13]', '$data[14]','$data[15]','$data[16]',$MANAGER_ID,$pid,'$MANAGERCOM_ID', 1, 6, '$data[17]')";

                                    if($conn->query($sql))

                                    {

                                        $count++; 

                                    }

                                    else

                                    {

                                        $error[]=$rcount-1;

                                    }

                                }

                            }

                            else

                            {

                                $error[]=$rcount-1;

                            }

                        }

                        else

                        {

                            $check=strtolower($data[10]);

                            if($check=='yes')

                            {

                                $data[10]=1;

                            }

                            else

                            {

                                $data[10]=2;

                            }

                            $signortickcheck=strtolower($data[11]);

                            if($signortickcheck=='sign')

                            {

                                $data[11]=1;

                            }

                            else if($signortickcheck=='tick')

                            {

                                $data[11]=2;

                            }

                            $sql="insert into projects(title, project_reference,description,incentive,participants, group_num, start_date, termandcondition, pm_id, cm_id,status, signortick) values('$data[0]','$data[1]','$data[2]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]', $MANAGER_ID, '$MANAGERCOM_ID',1,'$data[11]')";

                            if($conn->query($sql))

                            {

                                $pid=$conn->insert_id;

                                $sql="select * from users where p_id='$pid' and pm_id='$MANAGER_ID' and email='$data[15]' and com_id='$MANAGERCOM_ID'";

                                if($result = $conn->query($sql))

                                {

                                    if($result->num_rows>0)

                                    {

                                        $count++; 

                                        continue;   

                                    }

                                    else

                                    {

                                    $sql = "insert into users(salutation, f_name, l_name, email, m_num, pm_id, p_id, com_id, status, pay_status, incentive) values('$data[12]','$data[13]', '$data[14]','$data[15]','$data[16]',$MANAGER_ID,$pid,'$MANAGERCOM_ID', 1, 6, '$data[17]')";

                                        if($conn->query($sql))

                                        {

                                            $count++; 

                                        }

                                        else

                                        {

                                            $error[]=$rcount-1;

                                        }

                                    }

                                }

                            }

                            else

                            {

                                $error[]=$rcount-1;

                            }

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

            else

            {

                $errorMember="Something Went Wrong!! Check Data At Row(s): $err";

            }

            

            fclose($handle);

        }

    }

 

    $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, c.l_name as pml_name , p.project_reference as p_ref, p.tandcfile, p.termandcondition, p.signortick from users u, projects p, com_admins c where u.pm_id='$MANAGER_ID' and u.pm_id=p.pm_id and c.id=u.pm_id and u.p_id=p.id and p.pm_id=c.id and u.pay_status=6";  

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

            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">

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

                    <button title="" class="btn btn-primary" style="margin-right: 5px; padding:5px 5px;;" data-toggle="modal" data-target="#modal-default"><i class="fa fa-user-plus"></i>&nbspAdd User</button>

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

                <div class="col-md-4">

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

                                                <td style="  text-align: center; " id="pay_reference<?=$i?>"><?=$detail['p_ref'];?></td>

                                            <?php

                                            if($detail['termandcondition']==1)

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

                                            <td style="  text-align: center; " id="email_template<?=$i?>"><button type="button" class="btn btn-success" onclick="template(<?=$detail['id']?>)"><div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>

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

                <div class="col-md-4">

                   <form method="get" action="../files/template.csv">

                    <button class="btn btn-success"  style="font-size: 14px; padding: 10px;">Download Bulk Upload Template</button></form>

                </div>

                <div class="col-md-4">

                    <button class="btn btn-success"  style="font-size: 14px; padding: 10px;" data-toggle="modal" data-target="#modal-bulk-user"><i class="fa fa-upload"></i>&nbspBulk Upload</button>

                </div>

            </div>

        </div>

    </div>

</div>



<button class="btn btn-success" style="display: none;" id="showtemp" style="font-size: 14px; padding: 10px;" data-toggle="modal" data-target="#modal-email-temp"><i class="fa fa-upload"></i></button>

<button class="btn btn-success" style="display: none;" id="uploadfile" style="font-size: 14px; padding: 10px;" data-toggle="modal" data-target="#modal-tncfile"><i class="fa fa-upload"></i></button>





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

                                <?php

                                if(isset($sal))

                                {

                                    foreach($sal as $data)

                                    {

                                        $selected=" ";

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

<div class="modal fade" id="modal-bulk-user">

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

                                <input type="file" name="file" style="font-size: 14px; padding-bottom:30px;" id="file" class="form-control"  required>  

                            </div> 

                        </div>

                        

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin-top:10; width: 90px; height: 30px; font-size: 16px;">Close</button>

                    <button type="submit" name="userbulkadd" class="btn btn-primary" style="margin-top:10; width: 65px; height: 30px; font-size: 16px;">Submit</button>

                </div>

            </form>

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

        $.ajax({

            url:"emailtemp.php",

            type:"POST",

            

            data:{

                userid:uid,
                com_id: <?=$MANAGERCOM_ID?>

            },

            

            success:function(response)

            {

                var obj=JSON.parse(response);

                $("#linkspin").hide();

                $("#useremailtemp").html(`<p><b>To:</b>${obj.user_email}</p>

                    <p><b>CC:</b>${obj.pm_email}</p>

                    <p><b>Subject:</b>${obj.sub}</p><br>

                    <p>${obj.greet}</p><br>

                    <p>${obj.bd}</p><br>

                    <p>${obj.endgreet}</p>

                    <br><br>`)

                $("#showtemp").trigger('click');

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

        var project =$("#project").val();

        getuser(project);

    } 

    function getuser(project)

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

        $("#userdata").html(obj.str);

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

                    Initiate:true,

                    usercomid: <?=$MANAGERCOM_ID?>

                },

                success:function(data)

                {

                    $("#mailspin").hide()

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





