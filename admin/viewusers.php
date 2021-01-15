<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
    
    if(isset($_POST['delete']))
    {
        $id=$_POST['delete'];
        $sql = "delete from users where id=$id";    
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
    

    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token=$_GET['token'];
        $sql="select pm.name as pmname, u.*, p.title, p.description, p.start_date, p.incentive, c.com_name from projects p, users u, companies c, projectmanager pm where u.pm_id=pm.id and u.id='$token' and u.p_id=p.id and u.com_id=c.id";
        if($result =  $conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $userprojects[] = $row;
                }
            }
        }
        $sql="select * from users where id='$token'";
        if($result =  $conn->query($sql))
        {
            if($result->num_rows)
            {
               $users = $result->fetch_assoc();
            }
        }
    }

?>
    
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           User Details 
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
                </div>
            </li>
        </ol>
    </section>

    <!-- Main content -->
      <br>
    <section class="content">
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
      
      <?php
            if(isset($users))
            {
        ?>
            
                <div class="row">
                    <div class="col-md-4 "  >
                    <!-- Widget: user widget style 2 -->
                        <div class="card card-widget widget-user-2 shadow-sm">
              <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src=".\uploades\medium\4421609810300.jpg" alt="User Avatar">
                                </div>
                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username"><?=$users['name']?></h3>
                                <h5 class="widget-user-desc"><?=$users['email']?></h5>
                            </div>
                            <div class="card-footer p-0" style="background-color: white; ">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Mobile Number<span class="float-right badge bg-blue"><?=$users['m_num']?></span>
                                     </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link">
                                        Zip Code <span class="float-right badge bg-DeepSkyBlue"></span>
                                        </a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                        Address <span class="float-right badge bg-green"><?=$users['address']?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                        Date of Joining<span class="float-right badge bg-red">
                                            <?php $date=date_create($users['time_stamp']);
                                                echo date_format($date,"M d Y"); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <!-- /.widget-user -->
                    </div>
                </div>
        <?php
            }
        ?>
        <br>
        <section class="content-header">
                <h1>
                    User's Project Details
                </h1>
                
            </section>
            <br>
            <div class="box">
              <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead  style="background-color: #212529; color: white;">
                        <tr>
                             <th>Serial Number</th>
                             <th>Project Title</th>
                             <th>Description</th>
                             <th>Start Date</th>
                             <th>Incentive</th>
                             <th>Project Manager</th>
                             <th>Company</th> 
                             <th>Action</th>
                        </tr>
                    </thead>
                     <tbody> 
                     <?php
                            if (isset($userprojects)) 
                            {
                                $i = 1;
                                foreach ($userprojects as $detail) 
                                { 
                     ?>
                                    <tr> 
                                     
                                        <td  id="serialNo<?=$i?>"><?=$i?></td> 
                                        <td  id="title<?=$i?>"><?=$detail['title'];?></td> 
                                        <td  id="description<?=$i?>"><?=$detail['description'];?></td>  
                                        <td  id="start_date?=$i?>"><?=$detail['start_date'];?></td>
                                        <td  id="incentive<?=$i?>"><?=$detail['incentive'];?></td>
                                        <td  id="pmname<?=$i?>"><?=$detail['pmname'];?></td>
                                        <td  id="com_name<?=$i?>"><?=$detail['com_name'];?></td>
                                        
                                        
                                           
                                        <td style="width:30%">
                                           
                                            <form method="post">
                                                <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
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
             <!-- /.box-footer-->
            </div>    
      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->       
       <div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>

