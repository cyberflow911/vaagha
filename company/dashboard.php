<?php
    require_once 'header.php';
    require_once 'navbar.php';
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
    $sql="select pm.f_name, p.*, c.com_name from companies c, com_admins pm, projects p where pm.type=2 and p.pm_id=pm.id and p.cm_id=c.id and c.id='$COMPANY_ID' order by p.id desc limit 10;";
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
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
    </section>

    <section class="content">
        <?php
            if(isset($resSubject))
            {
        ?>
                <div class="alert alert-success"><strong>Success!</strong> your request successfully updated.</div> 
        <?php
            }
            else if(isset($errorSubject))
            {
        ?>
                <div class="alert alert-danger"><strong>Error! </strong><?=$errorSubject?></div> 
        <?php
                
            }
        ?>
        <div class="row">
            <div class="col-md-5">
            <!-- Info Boxes Style 2 -->
                <div class="info-box mb-3 bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-building"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Company Admins</span>
                        <span class="info-box-number"><?=$ca_count?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <a href="project?token=3" style="background-color: white;">
                    <div class="info-box mb-3 bg-green">
                        <span class="info-box-icon"><i class="fa fa-tasks"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Projects</span>
                            <span class="info-box-number"><?=$p_count?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
            </div>
            <div class="col-md-5" style="margin-left: 40px;" >
                <!-- /.info-box -->
                <a href="projectmanager?token=3" style="background-color: white;">
                    <div class="info-box mb-3 bg-red">
                        <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>
                        <div class="info-box-content" style="color: white;">
                            <span class="info-box-text">Project Managers</span>
                            <span class="info-box-number"><?=$pm_count?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
                <a href="users?token=3" style="background-color: white;">
                    <div class="info-box mb-3 bg-blue">
                        <span class="info-box-icon"><i class="fa fa-user-circle"></i></span>
                        <div class="info-box-content" style="color: white;">
                            <span class="info-box-text" >Users</span>
                            <span class="info-box-number"><?=$u_count?></span>
                        </div>
                        <!-- /.info-box-content -->   
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-transparent" style="background-color: #343a40;">
                        <h3 class="card-title" style="color: white;">Company's Latest Projects</h3>
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
                                        <th style="text-align: center;">Incentive</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
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
                                                    <?=$data['f_name']?>
                                                    </td>
                                                    <td style="padding: 12px;">
                                                    <?=$data['incentive']?>
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
                        <div class="card-footer clearfix">
                            <a href="project?token=3" class="btn btn-sm btn-info float-right">View All Projects</a>
                        </div>
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