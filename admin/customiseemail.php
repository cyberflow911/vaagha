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
            
            $sql="delete from companies where id=$id";
            if($conn->query($sql))
            {
                $resSubject=true;   
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
    }

    
    $sql="select * from email";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $email[] = $row;
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           <b>Customise Email Templates </b> 
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right"> 
                    <a href="emailaddedit" class="btn btn-primary"><i class="fa fa-plus"></i></a> 
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
                <div class="alert alert-success"><strong>Success! </strong> your request successfully updated. </div> 
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
                <table id="example2" class="table table-bordered table-hover">
                    <thead  style="background-color: #212529; color: white;">
                        <tr>
                             <th>Serial Number</th>
                             <th>Name</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                     <tbody> 
                     <?php
                            if (isset($email)) 
                            {
                                $i = 1;
                                foreach ($email as $detail) 
                                { 
                     ?>
                                    <tr> 
                                     
                                        <td  id="serialNo<?=$i?>"><?=$i?></td> 
                                        <td  id="name<?=$i?>"><?=$detail['name'];?></td>    
                                           
                                        <td style="width:30%">
                                           
                                            <form method="post">
                                            <a href="viewemail?token=<?=$detail['id']?>" class="btn btn-primary"><i class="fa fa-eye">View</i></a>
                                            <a href="emailaddedit?token=<?=$detail['id']?>" class="btn btn-success"><i class="fa fa-edit">Edit</i></a>
                                            <button type="submit" name="delete" class="btn btn-danger" value="<?=$detail['id']?>">Delete</button>
                                                
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
 require_once 'js-links.php';?> 


