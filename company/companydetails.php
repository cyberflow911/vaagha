
<?php
    require_once 'header.php';
    require_once 'left-navbar.php';
 
    
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {

        if(isset($_POST['add']))
        {
            $f_name = $_POST['fn'];
            $l_name = $_POST['ln'];
            $email = $_POST['em'];
            $password = md5($_POST['pss']);
            if(isset($_GET['token']))
            {   
                $token=$_GET['token'];
            }
            $sql="insert into com_admins(c_id, f_name, l_name, email, password, status) values('$token', '$f_name', '$l_name', '$email', '$password', '1')";
            if($conn->query($sql))
            {
                $resSubject=true;
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

        if(isset($_POST['delete2']))
        {
            $id=$_POST['delete'];
            $sql="delete from projects where id=$id";
            if($conn->query($sql))
            {
                $resSubject=true;   
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
        if(isset($_POST['delete3']))
        {
            $id=$_POST['delete'];
            $sql="delete from com_admins where id=$id";
            if($conn->query($sql))
            {
                $resSubject=true;   
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

        if(isset($_POST['block3']))
        {
            $id=$_POST['block3'];
            $sql="update com_admins set status=0 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
        if(isset($_POST['block4']))
        {
            $id=$_POST['block4'];
            $sql="update users set status=0 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

        if(isset($_POST['unblock3']))
        {
            $id=$_POST['unblock3'];
            $sql="update com_admins set status=1 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
        if(isset($_POST['unblock4']))
        {
            $id=$_POST['unblock4'];
            $sql="update users set status=1 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

        if(isset($_POST['hold']))
        {
            $id=$_POST['hold'];
            $sql="update projects set status=0 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

        if(isset($_POST['active']))
        {
            $id=$_POST['active'];
            $sql="update projects set status=1 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

    }
    
    $sql="select *  from com_admins where c_id='$COMPANY_ID' and id!='$id' and type=1";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $adminname[] = $row;
        }      
    }

    
    $sql="select c.* from companies c, com_admins a where c.id=a.c_id and a.id='$id'";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        $row = $result->fetch_assoc();
            $comdata = $row;     
    }
    
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

    $sql="select * from projects where cm_id='$COMPANY_ID'";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $projects[] = $row;
        }      
    }

    $sql="select * from com_admins where c_id='$COMPANY_ID' and type=2";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $projectmanager[] = $row;
        }      
    }
    
    $sql="select * from users where com_id='$COMPANY_ID'";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $users[] = $row;
        }      
    }
?>
<div class="page-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Company Details</div>
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
        ?>
            
            <div class="row">
                <div class="col-md-4 "  >
                    <div class="card card-widget widget-user-2 shadow-sm">
                        <div class="widget-user-header bg-yellow" style="display:flex;flex:1;flex-direction:'row'">
                            <div class="widget-user-image " style="flex:0.2"> 
                                <div class="profileImage" style="margin-top:5px;width: 60px; height: 48; font-size: 35px; ">
                                    <?php
                                        $F_NAME=$comdata['com_name'];
                                        $fname=$F_NAME[0];
                                        echo ucfirst($fname[0]);
                                    ?>
                                </div>
                            </div>
                            <div>
                                <h3 class="widget-user-username" style="margin-left:10px !important"><?=$comdata['com_name']?></h3>
                                <h5 class="widget-user-desc"  style="margin-left:10px !important"><?=$comdata['address']?>-<?=$comdata['post']?></h5>
                            </div>
                        </div>
                        <div class="card-footer p-0" style="background-color: white; ">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                    Registration Number<span class="float-right badge bg-blue"><?=$comdata['reg_num']?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                    Vat <span class="float-right badge bg-green"><?=$comdata['vat']?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <h1>
                Projects
            </h1>
            <div class="card radius-15">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #212529; color: white;">
                                <tr>
                                    <th scope="col" style="text-align: center;">S.No.</th>
                                    <th scope="col" style="text-align: center;">Title</th>
                                    <th scope="col" style="text-align: center;">Description</th>
                                    <th scope="col" style="text-align: center;">Start Date</th>
                                    <th scope="col" style="text-align: center;">Incentive</th>
                                    <th scope="col" style="text-align: center;">Action</th>
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
                                                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><?=$i?></td> 
                                                <td style="  text-align: center; " id="title<?=$i?>"><?=$detail['title'];?></td> 
                                                <td style="  text-align: center; " id="description<?=$i?>"><?=$detail['description'];?></td> 
                                                <td style="  text-align: center; " id="start_date<?=$i?>"><?=$detail['start_date'];?></td>
                                                <td style="  text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive'];?></td>
                                                <td>
                                                <form method="post">
                                                    <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                                        <i class="fa fa-trash-o"></i> Delete
                                                    </button>
                                                    <?php
                                                    if($detail['status']==1)
                                                    {
                                                        ?>
                                                        <button  class="btn btn-warning" type="submit" name="hold" value="<?=$detail['id']?>">
                                                            <i class="fa fa-ban">Hold</i>
                                                        </button>
                                                        <?php
                                                    }
                                                    else if($detail['status']==0)
                                                    {
                                                        ?>
                                                        <button  class="btn btn-success" type="submit" name="active" value="<?=$detail['id']?>">
                                                            <i class="fa fa-check">Active</i>
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
            <h1>
                Project Managers
            </h1>
            <div class="card radius-15">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #212529; color: white;">
                                <tr>
                                    <th scope="col" style="text-align: center;">S.No.</th>
                                    <th scope="col" style="text-align: center;">Name</th>
                                    <th scope="col" style="text-align: center;">Email</th>
                                    <th scope="col" style="text-align: center;">Date</th>
                                    <th scope="col" style="text-align: center;">Action</th>
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
                                                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><?=$i?></td> 
                                                <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['f_name'];?></td> 
                                                <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                                                <td style="  text-align: center; " id="date<?=$i?>"><?php $date=date_create($detail['time_stamp']);
                                                echo date_format($date,"M d Y"); ?></td>
                                                
                                                <td>
                                                <form method="post">
                                                <button  class="btn btn-danger" type="submit" name="delete3" value="<?=$detail['id']?>"><i class="fa fa-trash-o"></i> Delete
                                                </button>
                                                <?php
                                                if($detail['status']==1)
                                                {
                                                    ?>
                                                    <button  class="btn btn-warning" type="submit" name="block3" value="<?=$detail['id']?>">
                                                        <i class="fa fa-ban">Block</i>
                                                    </button>
                                                    <?php
                                                }
                                                else if($detail['status']==0)
                                                {
                                                    ?>
                                                    <button  class="btn btn-success" type="submit" name="unblock3" value="<?=$detail['id']?>">
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
            <h1>
                Users
            </h1>
            <div class="card radius-15">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #212529; color: white;">
                                <tr>
                                    <th scope="col" style="text-align: center;">S.No.</th>
                                    <th scope="col" style="text-align: center;">Name</th>
                                    <th scope="col" style="text-align: center;">Email</th>
                                    <th scope="col" style="text-align: center;">Phone Number</th>
                                    <th scope="col" style="text-align: center;">Address</th>
                                    <th scope="col" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody> 
        
                            
                            <?php 
                                    if (isset($users)) 
                                    {
                                        $i = 1;
                                        foreach ($users as $detail) 
                                        {     
                            ?> 
                                            <tr> 
                                                <td style=" text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                                <td style=" text-align: center; " id="name<?=$i?>"><?=$detail['name'];?></td> 
                                                <td style=" text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td>  
                                                <td style=" text-align: center; " id="m_num<?=$i?>"><?=$detail['m_num'];?></td>
                                                <td style=" text-align: center; " id="address<?=$i?>"><?=$detail['address'];?></td> 
                                                <td>
                                                <form method="post">
                                                <button  class="btn btn-danger" type="submit" name="delete4" value="<?=$detail['id']?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>
                                <?php
                                if($detail['status']==1)
                                {
                                    ?>
                                    <button  class="btn btn-warning" type="submit" name="block4" value="<?=$detail['id']?>">
                                        <i class="fa fa-ban">Block</i>
                                    </button>
                                    <?php
                                }
                                else if($detail['status']==0)
                                {
                                    ?>
                                    <button  class="btn btn-success" type="submit" name="unblock4" value="<?=$detail['id']?>">
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
            <h1>
                Other Company Admins
            </h1>
            <div class="card radius-15">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #212529; color: white;">
                                <tr>
                                    <th scope="col" style="text-align: center;">S.No.</th>
                                    <th scope="col" style="text-align: center;">First Name</th>
                                    <th scope="col" style="text-align: center;">Last Name</th>
                                    <th scope="col" style="text-align: center;">Email</th>
                                </tr>
                            </thead>
                            <tbody> 
        
                            
                            <?php 
                                    if (isset($adminname)) 
                                    {
                                        $i = 1;
                                        foreach ($adminname as $detail) 
                                        {     
                            ?> 
                                            <tr> 
                                            <td style=" text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                            <td style=" text-align: center; " id="f_name<?=$i?>"><?=$detail['f_name'];?></td> 
                                            <td style=" text-align: center; " id="l_name<?=$i?>"><?=$detail['l_name'];?></td> 
                                            <td style=" text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td>
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