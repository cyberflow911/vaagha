<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'left-navbar.php';

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['delete']))
        {
            $id=$_POST['delete'];
            $sql = "delete from group_users where id=$id";
            
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
            $sql = "update group_users set status=2 where id=$id";
            
            if($conn->query($sql))
            {
                $resMember=true;   
            }
            else
            {
                $errorMember=$conn->error;
            }
        }  
        if(isset($_POST['unblock']))
        {
            $id=$_POST['unblock'];
            $sql = "update group_users set status=1 where id=$id";
            
            if($conn->query($sql))
            {
                $resMember=true;   
            }
            else
            {
                $errorMember=$conn->error;
            }
        }  
    }



if(isset($_GET['token'])&&!empty($_GET['token']))
{
    $token=$_GET['token'];
    $sql="select * from group_details where id='$token'";
    if($result=$conn->query($sql))
    {
        if($result->num_rows)
        {
            $row=$result->fetch_assoc();
            $group=$row;
        }
    }
    $sql="select g.*, u.name, u.email from group_users g, users u where g.g_id='$token' and g.u_id=u.id";
    if($result=$conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            {
                $users[] = $row;
            }
        }
    }
}

       
?>


</style>
<div class="content-wrapper">
<section class="content-header">
        <h1>
            Group Details
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
       
        
        <div class="box">
            <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
                    <tbody>
                    <?php
                        if (isset($group)) 
                        {
                    ?>
                    
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Name</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="name<?=$i?>"><?=$group['name'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white; " >Recruiter</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="recruiter"><?=$group['recruiter'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Incentive</th>
                                <th style="  text-align: center; background-color: #808080; color: white; " id="incentive"><?=$group['incentive'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Total Users</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="user_count"><?=$group['user_count'];?></th>  
                            </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>

            </div>
            <!-- /.box-footer-->
        </div>
        <br>
        <h2>Users</h2>
        <br>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <a href="groupuseradd?token=<?=$token?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                </div>
            </li>
        </ol>
        <div class="box">
              <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead style="background-color: #212529; color: white;">
                        <tr>
                             <th>S.No.</th>
                             <th>Name</th>
                             <th>Email</th>
                            <th>Action</th>
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
                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                         <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['name'];?></td> 
                                         <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                                         <td>
                                        <form method="post">
                                            <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </button>
                                        <?php
                                            if($detail['status']==1)
                                            { 
                                        ?>
                                                <button  class="btn btn-warning" type="submit" name="block" value="<?=$detail['id']?>">
                                                    <i class="fa fa-ban"></i> Block
                                                </button>  
                                        <?php
                                            }
                                            else if($detail['status']==2)
                                            {
                                        ?>
                                                <button  class="btn btn-info" type="submit" name="unblock" value="<?=$detail['id']?>">
                                                    <i class="fa fa-check"></i> Unblock
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
        
    </section>
  </div>
  <div class="control-sidebar-bg"></div>
    
  <?php
    require_once 'js-links.php';
  ?>
