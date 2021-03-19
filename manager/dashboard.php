<?php
require_once 'header.php';
require_once 'left-navbar.php';
 
    //fetching userss
    $sql="SELECT count(id) as count from users where pm_id='$MANAGER_ID'";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $u_count=$row['count']; 
        }
 
    } 
    //fetching projects
    $sql="SELECT count(id) as count from projects where pm_id='$MANAGER_ID'";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $p_count=$row['count']; 
        }
 
    }
    $sql="SELECT count(g.id) as count from projects p, group_details g where p.pm_id='$MANAGER_ID' and p.id=g.p_id";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $g_count=$row['count']; 
        }
 
    }

    $sql="select user_pic, name, m_num from users where status=1 and pm_id='$MANAGER_ID' limit 8;";
    if($result =  $conn->query($sql));
    {
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $users[] = $row;
            }
        }
    }

    $sql="select  p.*, c.com_name from companies c, projects p where p.pm_id='$MANAGER_ID' and p.cm_id=c.id order by p.id desc limit 10;";
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

<div class="wrapper">
    <div class="page-wrapper">
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="card radius-15 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="mb-0 font-weight-bold">Projects</p>
                                        <h2 class="mb-0"><?=$p_count?></h2>
                                    </div>
                                    <div class="ml-auto align-self-end">
                                        <p class="mb-0 font-14 text-primary"><i class='bx bxs-up-arrow-circle'></i>  <span></span>
                                        </p>
                                    </div>
                                </div>
                                <div id="chart1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card radius-15 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="mb-0 font-weight-bold">Users</p>
                                        <h2 class="mb-0"><?=$u_count?></h2>
                                    </div>
                                    <div class="ml-auto align-self-end">
                                        <p class="mb-0 font-14 text-success"><i class='bx bxs-up-arrow-circle'></i>  <span></span>
                                        </p>
                                    </div>
                                </div>
                                <div id="chart2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card radius-15 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="mb-0 font-weight-bold">Groups</p>
                                        <h2 class="mb-0"><?=$g_count?></h2>
                                    </div>
                                    <div class="ml-auto align-self-end">
                                        <p class="mb-0 font-14 text-danger"><i class='bx bxs-down-arrow-circle'></i>  <span></span>
                                        </p>
                                    </div>
                                </div>
                                <div id="chart3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card radius-15">
                    <div class="card-header border-bottom-0" style=" background-color: #343a40;">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-0" style="font-size: 18px; color: white;">Recent Projects</h5>
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