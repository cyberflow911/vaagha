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
        $sql="select g.*from group_details g where g.p_id='$token'";
        $result =  $conn->query($sql);
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $groups[] = $row;
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-weight: 900;">
            Project Details
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
            <div class="box">
            <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
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
            <!-- /.box-footer-->
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



