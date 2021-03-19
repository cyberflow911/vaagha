<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['delete']))
        {
            $id=$_POST['delete'];
            $sql = "delete from group_details where id=$id";
            
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
        $token = $_GET['token'];
        $sql="select g.* from group_details g where g.p_id='$token'";
        $result =  $conn->query($sql);
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $gid=$row['id'];
                $groups[$gid] = $row;
                
                $sql="select count(gu.id) as count from group_users gu where g_id='$gid' and status=1";
                $res =  $conn->query($sql);
                if($res->num_rows)
                {
                    $row1 = $res->fetch_assoc();
                        $groups[$gid]['count']=$row1['count'];
                }
                $sql="select count(gu.id) as count from group_users gu where g_id='$gid' and status=3";
                $res =  $conn->query($sql);
                if($res->num_rows)
                {
                    $row1 = $res->fetch_assoc();
                        $groups[$gid]['incount']=$row1['count'];
                }
            }
        }

        $sql="select * from projects where id='$token'";
        if($result =  $conn->query($sql))
        {    
            if($result->num_rows)
            {
                $row = $result->fetch_assoc();
                    $project = $row;
            }
        }
    }
    else
    {
        $title="INVALID REQUEST";
    }

    
?>

<style>
    .box-body{
	overflow: auto!important;
}
</style>
<div class="page-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Project Details</div>
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
            <div class="card radius-15">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                        <?php
                            if (isset($project)) 
                            {
                        ?>
                        
                                <tr> 
                                    <th style="  text-align: center; background-color: #212529; color: white;" >Title</th>
                                    <th style="  text-align: center; background-color: #808080; color: white;" id="title<?=$i?>"><?=$project['title'];?></th>  
                                </tr>
                                <tr> 
                                    <th style="  text-align: center; background-color: #212529; color: white; " >Description</th>
                                    <th style="  text-align: center; background-color: #808080; color: white;" id="description"><?=$project['description'];?></th>  
                                </tr>
                                <tr> 
                                    <th style="  text-align: center; background-color: #212529; color: white;" >Incentive</th>
                                    <th style="  text-align: center; background-color: #808080; color: white; " id="incentive"><?=$project['incentive'];?></th>  
                                </tr>
                        <?php
                            }
                        ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <h2>Groups</h2>
                <br>
                <div class="box">
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead style="background-color: #212529; color: white;">
                                <tr>
                                    <th style="  text-align: center; ">S.No.</th>
                                    <th style="  text-align: center; ">Group Name</th>
                                    <th style="  text-align: center; ">Recruiter</th>
                                    <th style="  text-align: center; ">Incentive</th>
                                    <th style="  text-align: center; ">Total Users</th>
                                    <th style="  text-align: center; ">Active Users</th>
                                    <th style="  text-align: center; ">Invited Users</th>
                                    <th style="  text-align: center; ">Action</th>
                                </tr>
                            </thead>
                            <tbody> 
        
                            
                            <?php 
                                    if (isset($groups)) 
                                    {
                                        $i = 1;
                                        foreach ($groups as $detail) 
                                        {     
                            ?> 
                                            <tr> 
                                                <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                                <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['name'];?></td>
                                                <td style="  text-align: center; " id="recruiter<?=$i?>"><?=$detail['recruiter'];?></td>
                                                <td style="  text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive'];?></td>
                                                <td style="  text-align: center; " id="user_count<?=$i?>"><?=$detail['user_count'];?></td>
                                                <td style="  text-align: center; " id="c_user<?=$i?>"><?=$detail['count']?></td>
                                                <td style="  text-align: center; " id="in_user<?=$i?>"><?=$detail['incount']?></td>
                                                <td>
                                                <form method="post">
                                                    <a href="viewgroup?token=<?=$detail['id']?>" class="btn btn-primary"> <i class="fa fa-eye">View</i> </a>
                                                    <a href="groupedit?token=<?=$detail['id']?>" class="btn btn-success" > <i class="fa fa-edit">Edit</i> </a>
                                                    <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                                        <i class="fa fa-trash-o"></i> Delete
                                                    </button>
                                                    
                                                    
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
</div>
      
<div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>



