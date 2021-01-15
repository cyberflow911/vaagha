<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'left-navbar.php';
 
    //fetching total registered  Companies
    $sql="SELECT count(id) as count from companies";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $total_companies=$row['count']; 
        }
 
    } 
    //fetching blocked comapnies
    $sql="SELECT count(id) as count from companies where status=0";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $blocked_companies=$row['count']; 
        }
 
    }
    //fetching unblocked comapnies
    $sql="SELECT count(id) as count from companies where status=1";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $unblocked_companies=$row['count']; 
        }
 
    }

    $sql="SELECT count(id) as count from projects where status='0'";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $hp_count=$row['count']; 
        }
    }
    $sql="SELECT count(id) as count from projects where status='1'";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $ap_count=$row['count']; 
        }
    }
    $sql="SELECT count(id) as count from projects";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $p_total=$row['count']; 
        }
    }
    $sql="SELECT count(id) as count from projects where status='2'";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $cp_total=$row['count']; 
        }
    }
    

    $sql="select user_pic, name, m_num from users where status=1 limit 8;";
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
    $sql="select logo, com_name from companies where status=1 limit 8;";
    if($result =  $conn->query($sql));
    {
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $companies[] = $row;
            }
        }
    }
    $sql="select pm.name, p.*, c.com_name from companies c, projectmanager pm, projects p where p.pm_id=pm.id and p.cm_id=c.id order by p.id desc limit 5;";
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
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?=$total_companies?></h3>

                            <p>Companies</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-building"></i>
                        </div>
                        <a href="companies?token=3" class="small-box-footer">More info <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <!-- small box -->

                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?=$unblocked_companies?></h3>

                            <p>Active Companies</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <a href="companies?token=1" class="small-box-footer">More info <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
    
                </div>
                <!-- ./col -->
                <div class="col-lg-4   col-6">
                    <!-- small box -->
                
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?=$blocked_companies?></h3>

                            <p>Blocked Companies</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-ban"></i>
                        </div>
                        <a href="companies?token=2" class="small-box-footer">More info <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
            
                </div>
                <!-- ./col -->

                <!-- ./col -->
            </div>
            

            <div class="row" style="margin-top: 20px;">
                <div class="col-md-5" style="margin-left:70px;">
                    <!-- USERS LIST -->
                    <div class="card">
                        <div class="card-header" style="background-color: #343a40;">
                            <h3 class="card-title" style="color: white;">Companies
                                
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="users-list clearfix">
                            <?php
                                if(isset($companies))
                                {
                                    foreach($companies as $data)
                                    {
                            ?>
                                        <li>
                                            <img src="dist/img/user1-128x128.jpg" alt="User Image">
                                            <a class="users-list-name" href="#"><?=$data['com_name']?></a>
                                            <span class="users-list-date"><?=$data['reg_num']?></span>
                                        </li>
                            <?php
                                    }
                                }
                            ?>
                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="users?token=3">View All Companies</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!--/.card -->
                </div>
                <div class="col-md-5" style="margin-left:50px;">
                    <!-- USERS LIST -->
                    <div class="card">
                        <div class="card-header" style="background-color:  #343a40;">
                            <h3 class="card-title" style="color: white;">Users
                                
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="users-list clearfix">
                            <?php
                                if(isset($users))
                                {
                                    foreach($users as $data)
                                    {
                            ?>
                                        <li>
                                            <img src="dist/img/user4-128x128.jpg" alt="User Image">
                                            <a class="users-list-name" href="#"><?=$data['name']?></a>
                                            <span class="users-list-date"><?=$data['m_num']?></span>
                                        </li>
                            <?php
                                    }
                                }
                            ?>
                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="users?token=3">View All Users</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!--/.card -->
                </div>

                
            </div>


            <!-- users -->
            <div class="row" style="margin-top: 40px;">
                <div class="col-md-4" >
                    <!-- Info Boxes Style 2 -->
                    <a href="projects?token=3">
                    <div class="info-box mb-3 bg-yellow">
                        <span class="info-box-icon"><i class="fa fa-tasks"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Projects</span>
                            <span class="info-box-number"><?=$p_total?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    </a>
                    <!-- /.info-box -->
                    <a href="projects?token=4">
                    <div class="info-box mb-3 bg-blue">
                        <span class="info-box-icon"><i class="fa fa-check-square"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Completed Projects</span>
                            <span class="info-box-number"><?=$cp_count?></span>
                        </div>
                    </div>
                    </a>
                    <a href="projects?token=1">
                    <div class="info-box mb-3 bg-green">
                        <span class="info-box-icon"><i class="fa fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Active Projects</span>
                            <span class="info-box-number"><?=$ap_count?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    </a>
                    <!-- /.info-box -->
                    <a href="projects?token=2">
                    <div class="info-box mb-3 bg-red">
                        <span class="info-box-icon"><i class="fa fa-ban"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Projects on Hold</span>
                            <span class="info-box-number"><?=$hp_count?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    </a>
                    <!-- /.info-box -->
                    
                    <!-- /.info-box -->
                </div>
                <div class="col-md-8">
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
                                            <th style="text-align: center;">Project Manager</th>
                                            <th style="text-align: center;">Company Name</th>
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
                                                        <td style="padding: 12px;">
                                                           <?=$data['name']?>
                                                        </td>
                                                        <td style="padding: 12px;"> <div class="sparkbar" data-color="#f39c12" data-height="20">
                                                           <?=$data['com_name']?></div>
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
                            <a href="projects?token=3" class="btn btn-sm btn-info float-right">View All Projects</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
            </div> 
        </div>
    </section>
</div>

<div class="control-sidebar-bg"></div>
<?php
require_once 'js-links.php';
?>