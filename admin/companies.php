<?php
    require_once 'header.php';
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
        if(isset($_POST['accept']))
        {
            $id=$_POST['accept'];
            
            $sql="update companies set status=1 where id=$id";
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
            case "4": 
                $sql="select * from companies where status=2";
                $title="Pending Companies";
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
<div class="page-wrapper">
	<div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3"><?=$title?></div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ml-auto">
                    <div class="btn-group">
                    <a href="companyaddedit" class="btn btn-primary"><i class="fa fa-plus"></i></a> 
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
                    </div>
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
					<!--end breadcrumb-->
            <div class="card radius-15">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #212529; color: white;">
                                <tr>
                                    <th>Serial Number</th>
                                    <th>Registration Number</th>
                                    <th>Company Name</th>
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
                                                        <a href="companyaddedit?token=<?=$detail['id']?>" class="btn btn-success"><i class="fa fa-edit">Edit</i></a>
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
                                                                else if($detail['status']==2)   
                                                                {
                                                            ?>
                                                                    <button  class="btn btn-success" type="submit" name="accept" value="<?=$detail['id']?>">
                                                                                <i class="fa fa-check">Accept</i>
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
</div>
      
  <div class="control-sidebar-bg"></div>

  
 
<?php
 require_once 'js-links.php';?> 


