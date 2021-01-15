<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        if(isset($_POST['add']))
        {
            $reg_num = $_POST['rn'];
            $com_name = $_POST['nm'];
            $address = $_POST['adr'];
            $post = $_POST['pst'];
            $vat = $_POST['vt'];
            $sql="insert into companies(reg_num, com_name, address, post, vat, status) values($reg_num, '$com_name', '$address', '$post', '$vat', 1)";
            if($conn->query($sql))
            {
                $resSubject=true;
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

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

        if(isset($_POST['block']))
        {
            $id=$_POST['block'];
            $sql="update companies set status=0 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
        if(isset($_POST['unblock']))
        {
            $id=$_POST['unblock'];
            $sql="update companies set status=1 where id=$id";
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

    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token = $_GET['token'];
        switch ($token) {
            case '1':
                $sql="select * from companies where status = 1";
                $title ="Unblocked Companies";
                break;
            case  "2":
                $sql="select * from companies where status = 0";
                $title ="Blocked Companies";
                break; 
            case "3": 
                $sql="select * from companies";
                $title="Companies";
                break;
            default:
                $title="INVALID REQUEST";
                break;
        }
        
        $result =  $conn->query($sql);
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $companies[] = $row;
            }
        }

    }
    else{
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
        <h1>
           <?=$title?>  
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></button> 
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
                             <th>Registration Number</th>
                             <th>Company Name</th>
                             <th>Address</th>
                             <th>Post</th>
                             <th>Vat</th>
                             <th>Registeration Date</th> 
                             <th>Action</th>
                        </tr>
                    </thead>
                     <tbody> 
                     <?php
                            if (isset($companies)) 
                            {
                                $i = 1;
                                foreach ($companies as $detail) 
                                { 
                     ?>
                                    <tr> 
                                     
                                        <td  id="serialNo<?=$i?>"><?=$i?></td> 
                                        <td  id="reg_num<?=$i?>"><?=$detail['reg_num'];?></td> 
                                        <td  id="com_name<?=$i?>"><?=$detail['com_name'];?></td>  
                                        <td  id="address<?=$i?>"><?=$detail['address'];?></td>
                                        <td  id="post<?=$i?>"><?=$detail['post'];?></td>
                                        <td  id="vat<?=$i?>"><?=$detail['vat'];?></td>
                                        <td  id="time_stamp<?=$i?>">
                                            <?php
                                                $date=date_create($detail['time_stamp']);
                                                echo date_format($date,"M d Y");
                                            ?>
                                        </td>    
                                           
                                        <td style="width:30%">
                                           
                                            <form method="post">
                                            <a href="viewadmin?token=<?=$detail['id']?>" class="btn btn-primary"><i class="fa fa-eye">View</i></a>
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Add A Company</q></h4>
        </div>
        <form method="post">
           <div class="modal-body">
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Company Name</label><br>   
                            <input type="text"  id="nm" name="nm" class="form-control" required>  
                        </div> 
                   </div>
                   <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Registration Number</label><br>   
                            <input type="text"  id="rn" name="rn" class="form-control"  required>  
                        </div> 
                   </div>
                </div>  
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Address</label><br>   
                            <input type="text"  id="adr" name="adr" class="form-control"  required>  
                        </div> 
                   </div>
                   <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Post Code</label><br>   
                            <input type="text"  id="pst" name="pst" class="form-control"  required>  
                        </div> 
                   </div>
                </div>
                <div class="row">
                   <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Vat</label><br>   
                            <input type="text"  id="vt" name="vt" class="form-control"  required>  
                        </div> 
                   </div>
                </div>
            </div>  
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" name="add" class="btn btn-primary" value="">Add</button>
            </div>
        </form>
    </div>          
</div>
            <!-- /.modal-content -->

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->       
  <div class="control-sidebar-bg"></div>

  
 
<?php
 require_once 'js-links.php';?> 


