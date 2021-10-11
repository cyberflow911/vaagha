<?php

    require_once 'header.php';

    require_once 'left-navbar.php';

 

    if($_SERVER["REQUEST_METHOD"] == "POST")

    {

        if(isset($_POST['delete']))

        {

            $id=$_POST['delete'];

            $sql = "delete from users where id=$id";

            

            if($conn->query($sql))

            {

                $sql = "delete from bank_details where u_id=$id";
                if($conn->query($sql))
                {
                    $resMember=true;
                }
                else
                {
                    $errorMember=$conn->error;
                }

            }

            else

            {

                $errorMember=$conn->error;

            }

        }



        if(isset($_POST['block']))

        {

            $id=$_POST['block'];

            $sql="update users set status=0 where id=$id";

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

            $sql="update users set status=1 where id=$id";

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

                $sql="select u.*, pm.f_name as pmf_name, pm.l_name as pml_name from users u, com_admins pm where pm.id=u.pm_id and u.status=1";

                $title ="Unblocked Users";

                break;

            case  "2":

                $sql="select u.*, pm.f_name as pmf_name, pm.l_name as pml_name from users u, com_admins pm where pm.id=u.pm_id and u.status=0";

                $title ="Blocked Users";

                break; 

            case "3": 

                $sql="select u.*, pm.f_name as pmf_name, pm.l_name as pml_name from users u, com_admins pm where pm.id=u.pm_id  and u.status!=2";

                $title="Users";

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

                $users[] = $row;

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

</style>

<!-- Content Wrapper. Contains page content -->

<div class="page-wrapper">

	<div class="page-content-wrapper">

        <div class="page-content">

            <!--breadcrumb-->

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

      

            <div class="card radius-15">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped">

                            <thead style="background-color: #212529; color: white;">

                                <tr style="background-color: #212529; color: white;">

                                    <th style="  text-align: center; ">S.No.</th> 

                                    <th style="  text-align: center; ">First Name</th>

                                    <th style="  text-align: center; ">Last Name</th>

                                    <th style="  text-align: center; ">Email</th>

                                    <th style="  text-align: center; ">Phone Number</th>

                                    <th style="  text-align: center; ">Project Manager</th>

                                    <th style="  text-align: center; ">Action</th>

                                </tr>

                            </thead>

                            <tbody> 

 

                    

                                <?php 

                                        if (isset($users)) 

                                        {

                                            $i = 1;

                                            foreach ($users as $detail) 

                                            {     

                                ?> 

                                                <tr> 

                                                    

                                                    <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 

                                                    <td style="  text-align: center; " id="f_name<?=$i?>"><?=$detail['f_name'];?></td> 

                                                    <td style="  text-align: center; " id="l_name<?=$i?>"><?=$detail['l_name'];?></td> 

                                                    <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 

                                                    <td style="  text-align: center; " id="m_num<?=$i?>"><?=$detail['m_num'];?></td>

                                                    <td style="  text-align: center; " id="pmname<?=$i?>"><?=$detail['pmf_name'];?> <?=$detail['pml_name'];?></td>

                                                    <td>

                                                        <form method="post">

                                                        <a href="viewusers?token=<?=$detail['id']?>" class="btn btn-primary"><i class="fa fa-eye">View</i></a>

                                                            <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>" onclick="return confirm('Are You Sure You want to Delete <?=$detail['f_name'];?> <?=$detail['l_name'];?> ?')">

                                                                        <i class="fa fa-trash-o"></i> Delete

                                                            </button>

                                                            <?php

                                                                if($detail['status']==1)

                                                                {

                                                            ?>

                                                                <button  class="btn btn-warning" type="submit" name="block" value="<?=$detail['id']?>">

                                                                            <i class="fa fa-ban ">Block</i>

                                                                </button>

                                                            <?php

                                                                }else if($detail['status']==0)

                                                                {

                                                            ?>

                                                                    <button  class="btn btn-success" type="submit" name="unblock" value="<?=$detail['id']?>">

                                                                                <i class="fa fa-check">Unblock</i>

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

</div>      

<div class="control-sidebar-bg"></div>



  



<?php

    require_once 'js-links.php';

?>





