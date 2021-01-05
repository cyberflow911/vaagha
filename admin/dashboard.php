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
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?=$total_companies?></h3>

                            <p>Companies</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-building"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
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
                <div class="col-lg-3   col-6">
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
            
        </div>
        <!-- /.row -->

    </section>
   
</div>

<div class="control-sidebar-bg"></div>
<?php
require_once 'js-links.php';
?>