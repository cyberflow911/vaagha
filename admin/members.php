<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['delete']))
        {
            $id=test_input($_POST['delete']);
            
            $sql="delete from gym_members where id=$id";
            if($conn->query($sql))
            {
                $resSubject=true;   
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
        
        if(isset($_POST['add']))
        {
            $name=test_input($_POST['memName']);
            $serial=test_input($_POST['serial']);
            $fname=test_input($_POST['memFName']);
            $addr=test_input($_POST['addr']);
            $mob=test_input($_POST['mob']);
            $email=test_input($_POST['email']);
            $pmont=test_input($_POST['mont']);
            $feeamt=test_input($_POST['fee']);
            
            $sql="insert into gym_members(email,name,mobile,serial_no,fathers_name,address,pkg_month,fee) values('$email','$name','$mob','$serial','$fname','$addr','$pmont','$feeamt')";
            if($conn->query($sql))
            {
                    $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
        
        if(isset($_POST['edit']))
        {
            $name=test_input($_POST['ememName']);
            $serial=test_input($_POST['eserial']);
            $fname=test_input($_POST['ememFName']);
            $addr=test_input($_POST['eaddr']);
            $mob=test_input($_POST['emob']);
            $email=test_input($_POST['eemail']);
            $pmont=test_input($_POST['emont']);
            $feeamt=test_input($_POST['efee']);
            $id=test_input($_POST['eid']);
            
            $sql="update gym_members set email='$email', serial_no='$serial',fathers_name='$fname',address='$addr',pkg_month='$pmont',fee='$feeamt',name='$name',mobile='$mob' where id=$id";
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
        
    $sql="select * from gym_members";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $memberList[] = $row;
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
            Subject List
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
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>Serial No</th>
                             <th>Name</th>
                             <th>Mobile</th>
                             <th>Email</th>
                             <th>Father Name</th>
                             <th>Addres</th>
                             <th>Package</th>
                             <th>Fee Paid</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                     <tbody> 
 
                    
                     <?php
                        
                            if (isset($memberList)) 
                            {
                                $i = 1;
                                foreach ($memberList as $detail) 
                                {    
                                
                     ?>
                        
                                     <tr> 
                                        <td style="  text-align: center; " id="serial<?=$i?>"><?=$detail['serial_no'];?></td>
                                        <td style="  text-align: center; " id="memName<?=$i?>"><?=$detail['name'];?></td> 
                                         <td style="  text-align: center; " id="mob<?=$i?>"><?=$detail['mobile'];?></td>  
                                         <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td>
                                         <td style="  text-align: center; " id="fat<?=$i?>"><?=$detail['fathers_name'];?></td>
                                         <td style="  text-align: center; " id="addr<?=$i?>"><?=$detail['address'];?></td> <td style="  text-align: center; " id="pkg<?=$i?>"><?=$detail['pkg_month'];?></td><td style="  text-align: center; " id="fee<?=$i?>"><?=$detail['fee'];?></td>  
                                           
                                        <td>
                                           
                                             <form method="post">
                                                <button name="confirm" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-edit"  onclick="setEditValues(<?=$detail['id'] ?>,<?=$i?>)" value="<?=$detail['id'] ?>">
                                                            <i class="fa fa-edit">Edit</i>
                                                </button>
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

                         
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Add Member</h4>
           </div>
           <form method="post">
           <div class="modal-body">
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Name</label><br>
                            <input type="text"  id="memName" name="memName" class="form-control">
                        </div> 
                   </div>
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Serial</label><br>
                            <input type="text"  id="serial" name="serial" class="form-control">
                        </div>
                    </div>
                </div>
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Father's Name</label><br>
                            <input type="text"  id="memFName" name="memFName" class="form-control">
                        </div> 
                   </div>
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Address</label><br>
                            <input type="text"  id="addr" name="addr" class="form-control">
                        </div>
                    </div>
                </div>
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Mobile </label><br>
                            <input type="text"  id="mob" name="mob" class="form-control">
                        </div> 
                   </div>
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Email</label><br>
                            <input type="text"  id="email" name="email" class="form-control">
                        </div>
                    </div>
                </div>
               <div class="row">
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Package Months</label><br>
                            <input type="text"  id="mont" name="mont" class="form-control">
                        </div>
                    </div> 
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Fee Amount Paid</label><br>
                            <input type="number"  id="fee" name="fee" class="form-control">
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
          </div>
    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Edit Member</h4>
           </div>
           <form method="post">
           <div class="modal-body">
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Name</label><br>
                            <input type="text"  id="ememName" name="ememName" class="form-control">
                        </div> 
                   </div>
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Serial</label><br>
                            <input type="text"  id="eserial" name="eserial" class="form-control">
                        </div>
                    </div>
                </div>
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Father's Name</label><br>
                            <input type="text"  id="ememFName" name="ememFName" class="form-control">
                        </div> 
                   </div>
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Address</label><br>
                            <input type="text"  id="eaddr" name="eaddr" class="form-control">
                        </div>
                    </div>
                </div>
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Mobile </label><br>
                            <input type="text"  id="emob" name="emob" class="form-control">
                        </div> 
                   </div>
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Member Email</label><br>
                            <input type="text"  id="eemail" name="eemail" class="form-control">
                        </div>
                    </div>
                </div>
               <div class="row">
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Package Months</label><br>
                            <input type="text"  id="emont" name="emont" class="form-control">
                        </div>
                    </div> 
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Fee Amount Paid</label><br>
                            <input type="number"  id="efee" name="efee" class="form-control">
                           <input type="hidden"  id="eid" name="eid" class="form-control">
                        </div> 
                   </div>
                </div>
            
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" name="edit" class="btn btn-primary" value="">Edit</button>
          </div>
             </form>
            </div>
             
        </div>
            <!-- /.modal-content -->
      </div>
          

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->       
  <div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>

<script>
    function setEditValues(id,count)
    {
        $("#eid").val(id);
        $("#ememName").val($("#memName"+count).html());
        $("#eserial").val($("#serial"+count).html());
        $("#eaddr").val($("#addr"+count).html());
        $("#emob").val($("#mob"+count).html());
        $("#eemail").val($("#email"+count).html());
        $("#emont").val($("#pkg"+count).html());
        $("#efee").val($("#fee"+count).html());
        $("#ememFName").val($("#fat"+count).html());

    }  
</script>
