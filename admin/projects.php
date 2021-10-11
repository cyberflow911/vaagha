<?php

    require_once 'header.php';

    require_once 'left-navbar.php';

 

    $id=$_SESSION['id'];

    if($_SERVER["REQUEST_METHOD"] == "POST")

    {

        if(isset($_POST['delete']))

        {

            $id=$_POST['delete'];

            $sql = "delete from projects where id=$id";

            

            if($conn->query($sql))

            {

                $resMember=true;   

            }

            else

            {

                $errorMember=$conn->error;

            }

        }  

        if(isset($_POST['hold']))

        {

            $id=$_POST['hold'];

            $sql="update projects set status=0 where id=$id";

            if($conn->query($sql))

            {

                $resMember = "true";

            }

            else

            {

                $errorMember=$conn->error;

            }

        }

        if(isset($_POST['active']))

        {

            $id=$_POST['active'];

            $sql="update projects set status=1 where id=$id";

            if($conn->query($sql))

            {

                $resMember = "true";

            }

            else

            {

                $errorMember=$conn->error;

            }

        }  

        if(isset($_POST['completed']))

        {

            $id=$_POST['completed'];

            $sql="update projects set status=2 where id=$id";

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

                $sql="select p.*, pm.f_name, pm.l_name from projects p, com_admins pm where pm.id=p.pm_id and p.status = 1";

                $title ="Active Projects";

                break;

            case  "2":

                $sql="select p.*, pm.f_name, pm.l_name from projects p, com_admins pm where pm.id=p.pm_id and p.status = 0";

                $title ="Projects on Hold";

                break; 

            case "3": 

                $sql="select p.*, pm.f_name, pm.l_name from projects p, com_admins pm where pm.id=p.pm_id ";

                $title="Projects";

                break;

                break; 

            case "4": 

                $sql="select p.*, pm.f_name, pm.l_name from projects p, com_admins pm where pm.id=p.pm_id and p.status='2'";

                $title="Completed Projects";

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

                $projects[] = $row;

            }

        }



    }

    else

    {

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

                                    <th style="  text-align: center; ">Project Title</th>

                                    <th style="  text-align: center; ">Project Manager</th>

                                    <th style="  text-align: center; ">Start Date</th>

                                    <th style="  text-align: center; ">Incentive</th>

                                    <th style="  text-align: center; ">Action</th>

                                </tr>

                            </thead>

                            <tbody> 

 

                    

                                <?php 

                                        if (isset($projects)) 

                                        {

                                            $i = 1;

                                            foreach ($projects as $detail) 

                                            {     

                                ?> 

                                <tr> 

                                    <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 

                                    <td style="  text-align: center; " id="title<?=$i?>"><?=$detail['title'];?></td> 

                                    <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['f_name'];?> <?=$detail['l_name'];?></td>

                                    <td style="  text-align: center; " id="start_date<?=$i?>"><?=$detail['start_date'];?></td>

                                    <td style="  text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive'];?></td>

                                    <td>

                                        <form method="post">

                                        <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>" onclick="return confirm('Are You Sure You want to Delete <?=$detail['title']?> ?')">

                                                    <i class="fa fa-trash-o"></i> Delete

                                        </button>

                                        

                                    <?php

                                        if($detail['status']==1)

                                        {

                                    ?>

                                            <button  class="btn btn-warning" type="submit" name="hold" value="<?=$detail['id']?>">

                                                <i class="fa fa-ban ">Hold</i>

                                            </button>

                                            <button  class="btn btn-secondary" type="submit" name="completed" value="<?=$detail['id']?>">

                                                <i class="fa fa-check-square ">&nbspComplete</i>

                                            </button>

                                    <?php

                                        }

                                        else if($detail['status']==0)

                                        {

                                    ?>

                                            <button  class="btn btn-success" type="submit" name="active" value="<?=$detail['id']?>">

                                                <i class="fa fa-check">Active</i>

                                            </button>

                                            <button  class="btn btn-secondary" type="submit" name="completed" value="<?=$detail['id']?>">

                                                <i class="fa fa-check-square ">&nbspComplete</i>

                                            </button>

                                    <?php

                                        }

                                        else if($detail['status']==2)

                                        {

                                    ?>

                                            <button  class="btn btn-success" type="submit" name="active" value="<?=$detail['id']?>">

                                                <i class="fa fa-check">Active</i>

                                            </button>

                                            <button  class="btn btn-warning" type="submit" name="hold" value="<?=$detail['id']?>">

                                                <i class="fa fa-ban ">Hold</i>

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







