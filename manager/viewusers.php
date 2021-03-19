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
        $sql="select u.*, p.title, p.description, p.start_date, p.incentive from projects p, users u where u.pm_id='$MANAGER_ID' and u.id='$token' and u.p_id=p.id";
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
    
<div class="page-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Group Details</div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>
                            </li>
                        </ol>
                    </nav>
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
            if(isset($users))
            {
        ?>
            
            <div class="row">
                <div class="col-md-4 "  >
                    <div class="card card-widget widget-user-2 shadow-sm">
                        <div class="widget-user-header bg-yellow">
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2" src=".\uploads\medium\7061609903739.jpg" alt="User Avatar">
                            </div>
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
            </div> 
        </div>
    </div>
</div>       
<div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>

