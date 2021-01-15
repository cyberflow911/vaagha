<?php
require_once 'header.php';
require_once 'navbar.php';
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- overview section -->

    <section class="content">
        <!-- Info boxes -->
        <!-- user overiew section starts -->
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?=$p_count?></h3>

                            <p>Projects</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-tasks"></i>
                        </div>
                        <a href="projects?token=3" class="small-box-footer">More info <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-md-5">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?=$u_count?></h3>

                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-circle"></i>
                        </div>
                        <a href="users?token=3" class="small-box-footer">More info <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-md-12">
                        <div class="card">
                            <div class="card-header border-transparent" style="background-color: #343a40;">
                                <h3 class="card-title" style="color: white;">Latest Projects</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0" style="border-spacing: 2px;  font-size: 16px;">
                                        <thead style="font-weight: 800; background-color: #6c757d; color: white;">
                                            <tr>
                                                <th style="text-align: center;">S.no.</th>
                                                <th style="text-align: center;">Title</th>
                                                <th style="text-align: center;">Status</th>
                                                <th style="text-align: center;">Description</th>
                                                <th style="text-align: center;">Incentive</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align: center;">
                                            <tr>
                                            <?php
                                                if(isset($pdetails))
                                                {
                                                    $i=1;
                                                    foreach($pdetails as $data)
                                                    {
                                            ?>
                                                        <tr>
                                                            <td style="padding: 12px; color: #17a2b8;"><?=$i?></td>
                                                            <td style="padding: 12px;"><?=$data['title']?></td>
                                                            <td style="padding: 12px;">
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
                                                            <td style="padding: 12px;"> <div class="sparkbar" data-color="#f39c12" data-height="20">
                                                            <?=$data['description']?></div>
                                                            </td>
                                                            <td style="padding: 12px;"> <div class="sparkbar" data-color="#f39c12" data-height="20">
                                                            <?=$data['incentive']?></div>
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
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <a href="project?token=3" class="btn btn-sm btn-info float-right">View All Projects</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>
                </div> 
            </div>
            
        </div>
        <!-- /.row -->

    </section>
   
</div>

<div class="control-sidebar-bg"></div>
<?php
require_once 'js-links.php';
?>