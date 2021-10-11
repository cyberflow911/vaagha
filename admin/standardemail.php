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
<div class="page-wrapper">
	<div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Standard Email Templates</div>
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
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
                    </div>
                </div>
            </div>
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
      
            <div class="card radius-15">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #212529; color: white;">
                                <tr style="background-color: #212529; color: white;">
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
                                            <a href="emailaddedit?token=<?=$detail['id']?>" class="btn btn-success"><i class="fa fa-eye">Edit</i></a>
                                                
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


