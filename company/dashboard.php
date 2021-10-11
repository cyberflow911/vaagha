<?php

    require_once 'header.php';

    require_once 'left-navbar.php';

 

    

    $id=$_SESSION['id'];

    $sql="SELECT count(id) as count from com_admins where c_id='$COMPANY_ID' and type=1";

    if($result=$conn->query($sql))

    {

        if($result->num_rows>0)

        {

            $row=$result->fetch_assoc(); 

            $ca_count=$row['count']; 

        }

    }

    $sql="SELECT count(id) as count from com_admins where c_id='$COMPANY_ID' and type=2";

    if($result=$conn->query($sql))

    {

        if($result->num_rows>0)

        {

            $row=$result->fetch_assoc(); 

            $pm_count=$row['count']; 

        }

    }

    $sql="SELECT count(id) as count from projects where cm_id='$COMPANY_ID'";

    if($result=$conn->query($sql))

    {

        if($result->num_rows>0)

        {

            $row=$result->fetch_assoc(); 

            $p_count=$row['count']; 

        }

    }

    $sql="SELECT count(id) as count from users where com_id='$COMPANY_ID'";

    if($result=$conn->query($sql))

    {

        if($result->num_rows>0)

        {

            $row=$result->fetch_assoc(); 

            $u_count=$row['count']; 

        }

    }

    $sql="SELECT count(u.id) as count from users u, projects p where u.p_id=p.id and u.pay_status=3  and p.termandcondition=1 and u.com_id='$COMPANY_ID' and p.signortick=1";

    if($result=$conn->query($sql))

    {

        if($result->num_rows>0)

        {

            $row=$result->fetch_assoc(); 

            $tnc_count=$row['count']; 

        }

    }

    $sql="SELECT count(id) as count from users where pay_status=4 and com_id='$COMPANY_ID'";

    if($result=$conn->query($sql))

    {

        if($result->num_rows>0)

        {

            $row=$result->fetch_assoc(); 

            $pp_count=$row['count']; 

        }

    }

    $sql="SELECT count(id) as count from users where pay_status=5 and com_id='$COMPANY_ID'";

    if($result=$conn->query($sql))

    {

        if($result->num_rows>0)

        {

            $row=$result->fetch_assoc(); 

            $paid_count=$row['count']; 

        }

    }

    $sql="select p.* from projects p where p.cm_id='$COMPANY_ID' order by p.id desc limit 10";

    if($result =  $conn->query($sql));

    {

        if($result->num_rows)

        {

            while($row = $result->fetch_assoc())

            {

                $pdetails[] = $row;

            }

        }

    }



?>



<style>

    .box-body{

	overflow: auto!important;

}

</style>

<!-- Content Wrapper. Contains page content -->

<div class="wrapper">

    <div class="page-wrapper">

        <div class="page-content-wrapper">

            <div class="page-content">

                <div class="row">

                    <div class="col-6 col-lg-12 col-xl-6">

                        <div class="card-deck flex-column flex-lg-row">

                            <div class="card radius-15 bg-info" style="border-radius: 20px;">

                                <a href="project?token=3">
                                    <div class="card-body text-center">

                                        <div class="widgets-icons mx-auto rounded-circle bg-white"><i class='bx bx-list-ul'></i>

                                        </div>

                                        <h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$p_count?></h4>

                                        <p class="mb-0 text-white">Total Projects</p>

                                    </div>
                                </a>

                            </div>

                            <div class="card radius-15 bg-wall" style="border-radius: 20px;">

                                <a href="projectmanager?token=3">
                                    <div class="card-body text-center">

                                        <div class="widgets-icons mx-auto bg-white rounded-circle"><i class='fadeIn animated bx bx-user-plus'></i>

                                        </div>

                                        <h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$pm_count?></h4>

                                        <p class="mb-0 text-white">Total Project Managers</p>

                                    </div>
                                </a>

                            </div>

                            <div class="card radius-15 bg-rose" style="border-radius: 20px;">

                                <a href="users?token=3">
                                    <div class="card-body text-center">

                                        <div class="widgets-icons mx-auto bg-white rounded-circle"><i class='lni lni-users'></i>

                                        </div>

                                        <h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$u_count?></h4>

                                        <p class="mb-0 text-white">Total Users</p>

                                    </div>
                                </a>

                            </div>

                        </div>

                    

                    </div>

                    <div class="col-6 col-lg-12 col-xl-6">

                        <div class="card-deck flex-column flex-lg-row">

                            <div class="card radius-15 bg-danger" style="border-radius: 20px;">

                                <a href="pending_tandc">   
                                    <div class="card-body text-center">

                                        <div class="widgets-icons mx-auto rounded-circle bg-white"><i class='fadeIn animated bx bx-file-blank'></i>

                                        </div>

                                        <h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$tnc_count?></h4>

                                        <p class="mb-0 text-white">Pending T&Cs</p>

                                    </div>
                                </a>

                            </div>

                            <div class="card radius-15 bg-primary" style="border-radius: 20px;">

                                <a href="pending_payments">
                                    <div class="card-body text-center">

                                        <div class="widgets-icons mx-auto bg-white rounded-circle"><i class='fadeIn animated bx bx-credit-card' style="color: black;"></i>

                                        </div>

                                        <h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$pp_count?></h4>

                                        <p class="mb-0 text-white">Pending Payments</p>

                                    </div>
                                </a>

                            </div>

                            <div class="card radius-15 bg-success" style="border-radius: 20px;">

                                <a href="paid_users">
                                    <div class="card-body text-center">

                                        <div class="widgets-icons mx-auto bg-white rounded-circle"><i class='bx bx-check-double'></i>

                                        </div>

                                        <h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$paid_count?></h4>

                                        <p class="mb-0 text-white">Paid Users</p>

                                    </div>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card radius-15">

                    <div class="card-header border-bottom-0" style=" background-color: #343a40;">

                        <div class="d-flex align-items-center">

                            <div>

                                <h5 class="mb-0" style="font-size: 18px; color: white;">Company's Latest Projects</h5>

                            </div>

                            <div class="ml-auto">

                                <a href="project?token=3" class="btn btn-white radius-15">View More</a>

                            </div>

                        </div>

                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table mb-0">

                                <thead>

                                    <tr>

                                        <th>S.no</th>

                                        <th>Title</th>

                                        <th>Incentive</th>

                                        <th>Start Date</th>

                                        <th>Groups</th>

                                        <th>Status</th>

                                    </tr>

                                </thead>

                                <tbody>

                                <?php

                                    if(isset($pdetails))

                                    {

                                        $i=1;

                                        foreach($pdetails as $data)

                                        {

                                ?>

                                            <tr>

                                                <td>

                                                    <?=$i?>

                                                </td>

                                                <td><?=$data['title']?></td>

                                                <td><?=$data['incentive']?></td>

                                                <td><?=$data['start_date']?></td>

                                                <td><?=$data['group_num']?></td>

                                                <td>

                                                <?php

                                                    if($data['status']==0)

                                                    {

                                                        ?>

                                                        <span class="badge badge-danger">Hold</span>

                                                        <?php

                                                    }

                                                    else if($data['status']==1)

                                                    {

                                                        ?>

                                                        <span class="badge badge-warning">Active</span>

                                                        <?php

                                                    }

                                                    else if($data['status']==2)

                                                    {

                                                        ?>

                                                        <span class="badge badge-success">Completed</span>

                                                        <?php

                                                    }

                                                ?>

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

</div>



<div class="control-sidebar-bg"></div>

<?php

require_once 'js-links.php';

?>