<?php

    require_once 'header.php';

    require_once 'left-navbar.php';

 

    $id=$_SESSION['id'];

    if($_SERVER["REQUEST_METHOD"] == "POST")

    {

        if(isset($_POST['delete']))

        {

            $id=$_POST['delete'];

            $sql = "delete from com_admins where id=$id";

            

            if($conn->query($sql))

            {

                $resMember=true;   

            }

            else

            {

                $errorMember=$conn->error;

            }

        }



        if(isset($_POST['add']))

        {

            $f_name=$_POST['f_name'];

            $l_name=$_POST['l_name'];

            $email=$_POST['email'];

            $m_num=$_POST['m_num'];
            $p=12345;

            $pass = md5($p);

            $sql="insert into com_admins(c_id, f_name, l_name, email, type, status, m_num, password) values('$COMPANY_ID', '$f_name','$l_name', '$email', '2', '1', '$m_num', '$pass')";

            if($conn->query($sql))

            {

                $resMember = "true";  

            }

            else

            {

                $errorMember=$conn->error;

            }

        }

            

        if(isset($_POST['edit']))

        {  

            $f_name=$_POST['ef_name'];

            $l_name=$_POST['el_name'];

            $email=$_POST['eemail'];

            $m_num=$_POST['em_num'];

            $id=$_POST['eid'];

            $sql="update com_admins set f_name='$f_name', l_name='$l_name', email='$email', m_num='$m_num'  where id='$id'";

            if($conn->query($sql))

            {

                $resMember  = "true";

            }

            else

            {

                $errorMember=$conn->error;

            }

        }



        if(isset($_POST['block']))

        {

            $id=$_POST['block'];

            $sql="update com_admins set status=0 where id=$id";

            if($conn->query($sql))

            {

                $resMember = "true";

            }

            else

            {

                $errorMember=$conn->error;

            }

        }

        if(isset($_POST['unblock']))

        {

            $id=$_POST['unblock'];

            $sql="update com_admins set status=1 where id=$id";

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

        $token = $_GET['token'];

        switch ($token) {

            case '1':

                $sql="select * from com_admins where c_id='$COMPANY_ID' and type=2 and status=1";

                $title ="Unblocked Project Managers";

                break;

            case  "2":

                $sql="select * from com_admins where c_id='$COMPANY_ID' and type=2 and status=0";

                $title ="Blocked Project Managers";

                break; 

            case "3": 

                $sql="select * from com_admins where c_id='$COMPANY_ID' and type=2";

                $title="Project Managers";

                break;

            default:

                $title="INVALID REQUEST";

                break;

        }

        

        $result =  $conn->query($sql);

        if($result->num_rows)

        {

            while($row = $result->fetch_assoc())

            {

                $projectmanager[] = $row;

            }

        }



    }

    else{

        $title="INVALID REQUEST";

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

                <div class="breadcrumb-title pr-3"><?=$title?></div>

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

                        <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></button> 

                        <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>

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

            <div class="box">

                <div class="box-body">

                    <table class="table table-bordered table-hover">

                        <thead style="background-color: #212529; color: white;">

                            <tr>

                            <th>S.No.</th> 

                             <th>First Name</th>

                             <th>Last Name</th>

                             <th>Email</th>

                             <th>Contact Number</th>

                             <th>Date</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                     <tbody> 

 

                    

                     <?php 

                            if (isset($projectmanager)) 

                            {

                                $i = 1;

                                foreach ($projectmanager as $detail) 

                                {     

                     ?> 

                                     <tr id="row<?=$detail['id']?>"> 

                                         

                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 

                                         <td style="  text-align: center; " id="f_name<?=$i?>"><?=$detail['f_name'];?> </td> 

                                         <td style="  text-align: center; " id="l_name<?=$i?>"><?=$detail['l_name'];?> </td> 

                                         <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td>

                                         <td style="  text-align: center; " id="m_num<?=$i?>"><?=$detail['m_num'];?></td>

                                         <td style="  text-align: center; " id="date<?=$i?>"> <?php $date=date_create($detail['time_stamp']);

                                                echo date_format($date,"M d Y"); ?></td>

                                         <td>

                                             <form method="post">

                                                <button name="confirm" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-edit"  onclick="setEditValues(<?=$detail['id'] ?>,<?=$i?>)" value="<?=$detail['id'] ?>">

                                                            <i class="fa fa-edit">&nbspEdit</i>

                                                </button>

                                                <button name="delete" type="button" class="btn btn-danger" onclick="deletepm(<?=$detail['id']?>)" value="<?=$detail['id'] ?>"><i class="fa fa-trash-o">&nbspDelete</i></button>

                                                <?php

                                                    if($detail['status']==1)

                                                    {

                                                ?>

                                                    <button  class="btn btn-warning" type="submit" name="block" value="<?=$detail['id']?>">

                                                                <i class="fa fa-ban ">&nbspBlock</i>

                                                    </button>

                                                <?php

                                                    }else if($detail['status']==0)

                                                    {

                                                ?>

                                                        <button  class="btn btn-success" type="submit" name="unblock" value="<?=$detail['id']?>">

                                                                    <i class="fa fa-check">&nbspUnblock</i>

                                                        </button>

                                                <?php

                                                    }

                                                ?>



                                            </form>

                                        </td>

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
        
    </div>

</div> 

<button name="delete" id="deletemodal" type="button" style="display: none" class="btn btn-success" data-toggle="modal" data-target="#modal-delete"  value="<?=$detail['id'] ?>"><i class="fa fa-edit">Delete</i></button>

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

                                <input type="text" minlength="2" maxlength="50" style="font-size: 16px;" id="f_name" name="f_name" class="form-control" required>  

                            </div> 

                        </div>

                        <div class="col-md-6"> 

                            <div class="form-group">

                                <label>Last Name</label><br>   

                                <input type="text" minlength="2" maxlength="50" style="font-size: 16px;" id="l_name" name="l_name" class="form-control" required>  

                            </div> 

                        </div>

                    </div>  

                    <div class="row">

                        <div class="col-md-6"> 

                            <div class="form-group">

                                <label>Email</label><br>   

                                <input type="email" style="font-size: 16px;" id="email" name="email" class="form-control"  required>  

                            </div> 

                        </div>

                        <div class="col-md-6"> 

                            <div class="form-group">

                                <label>Contact Number</label><br>   

                                <input type="number" onchange="check(this)" style="font-size: 16px;" id="m_num" name="m_num" class="form-control"  required>  

                            </div> 

                        </div>

                    </div> 

                </div>

                <div class="modal-footer">

                    <button type="button" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                    <button type="submit" id="add" name="add" class="btn btn-primary" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;" value="">Add</button>

                </div>

            </form>

        </div>

    </div>

    <!-- /.modal-content -->

</div>

<div class="modal fade" id="modal-edit">

    <div class="modal-dialog" >

        <div class="modal-content">

            <div class="modal-header">

            

            <h4 class="modal-title" style="font-size: 18px;">Edit Details</h4>

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

                                <input type="text" minlength="2" maxlength="50" style="font-size: 16px;" id="ef_name" name="ef_name" class="form-control" required>  

                            </div> 

                        </div>

                        <div class="col-md-6"> 

                            <div class="form-group">

                                <label>Last Name</label><br>   

                                <input type="text" minlength="2" maxlength="50" style="font-size: 16px;" id="el_name" name="el_name" class="form-control" required>  

                            </div> 

                        </div>

                        

                    </div>  

                    <div class="row">

                        <div class="col-md-6"> 

                            <div class="form-group">

                                <label>Email</label><br>   

                                <input type="hidden" name="eid" id ="eid"/>

                                <input type="email" style="font-size: 16px;" id="eemail" name="eemail" class="form-control"  required>  

                            </div> 

                        </div>

                        <div class="col-md-6"> 

                            <div class="form-group">

                                <label>Contact Numbr</label><br>   

                                <input type="number" onchange="check2(this)" style="font-size: 16px;" id="em_num" name="em_num" class="form-control"  required>  

                            </div> 

                        </div>

                    </div>  

                </div>



                <div class="modal-footer">

                    <button type="button" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                    <button type="submit" name="edit" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;" class="btn btn-primary" value="">Edit</button>

                </div>

            </form>

        </div>

    </div>

</div>       

<div class="modal fade" id="modal-delete">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
            
            <h4 class="modal-title" style="font-size: 18px;">Error</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="row" id="managerprojectinfo" style="margin-left: 10px;">

                    </div>  
                </div>

                <div class="modal-footer">
                    <button type="button" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
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

    function setEditValues(id,count)

    {

        $("#eid").val(id); 

        $("#ef_name").val($("#f_name"+count).html());

        $("#el_name").val($("#l_name"+count).html());

        $("#eemail").val($("#email"+count).html());

        $("#em_num").val($("#m_num"+count).html());

    } 

    function check(input)

    {

        var num=$("#m_num").val();

        var one = String(num).charAt(0);

        var one_as_number = Number(one); 

        var len=num.length;

        if(one_as_number==0)

        {

            $("#m_num").attr("maxlength","11");

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

            $("#m_num").attr("maxlength","10");

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

    function check2(input)

    {

        var num=$("#em_num").val();

        var one = String(num).charAt(0);

        var one_as_number = Number(one);

        var len=num.length;

        if(one_as_number==0)

        {

            $("#em_num").attr("maxlength","11");

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

            $("#em_num").attr("maxlength","10");

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

    function deletepm(uid)
    {
        
        $.ajax({
            url:"managerdata.php",
            type:"POST",
            
            data:{
                checkmanager:true,
                managerid:uid
            },
            success:function(response)
            {
                var obj=JSON.parse(response);
                if(obj.msg=="yes")
                {
                    $("#deletemodal").trigger('click')
                    $("#managerprojectinfo").html("This project manager cannot be deleted as the project manager has the following project association - ")
                    $("#managerprojectinfo").append('<br><br>');
                    $.each(obj, function(k, v) {
                        $("#managerprojectinfo").append(v.title);
                        $("#managerprojectinfo").append('<br>');
                    })
                    $("#managerprojectinfo").append("Please assign a different project manager to these projects before deleting the project manager.")
                }
                else if(obj.msg=="no")
                {
                    if(confirm('Do you really want to Delete?'))
                    {
                        $.ajax({
                        url:"managerdata.php",
                        type:"POST",
                        
                        data:{
                            deletemanager:true,
                            dmanagerid:uid
                        },
                        success:function(response)
                        {
                            var obj2=JSON.parse(response);
                            if(obj2.msg=="ok")
                            {
                                $("#row"+uid).remove()
                            }
                        }
                    })
                    }
                }
            },
            error:function()
            {

            }
        
        })
    }
    

</script>

