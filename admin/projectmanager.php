<?php

    require_once 'header.php';

    require_once 'left-navbar.php';

 

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

                $sql="select pm.*, c.com_name from com_admins pm, companies c where pm.type=2 and pm.c_id=c.id and pm.status=1";

                $title ="Unblocked Project Managers";

                break;

            case  "2":

                $sql="select pm.*, c.com_name from com_admins pm, companies c where pm.type=2 and pm.c_id=c.id and pm.status=0";

                $title ="Blocked Project Managers";

                break; 

            case "3": 

                $sql="select pm.*, c.com_name from com_admins pm, companies c where pm.type=2 and pm.c_id=c.id";;

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

</style>

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

                                    <th style="  text-align: center; ">Name</th>

                                    <th style="  text-align: center; ">Email</th>

                                    <th style="  text-align: center; ">Company Name</th>

                                    <th style="  text-align: center; ">Action</th>

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

                                    <tr> 

                                         

                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 

                                         <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['f_name'];?> <?=$detail['l_name'];?></td> 

                                         <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 

                                         <td style="  text-align: center; " id="com_name<?=$i?>"><?=$detail['com_name'];?></td>

                                         <td>

                                             <form method="post">

                                                <button onclick="return confirm('Are You Sure You want to Delete <?=$detail['f_name'];?> <?=$detail['l_name'];?> ?')" class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">  <i class="fa fa-trash-o"></i> Delete

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



