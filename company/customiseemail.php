<?php
    require_once 'header.php';
    require_once 'left-navbar.php';
 
    if(isset($_POST['delete']))
    {
        $id=$_POST['delete'];
        $sql="delete from customise_email where id='$id'";
        if($conn->query($sql))
        {
            $resMember=true;
        }
        else
        {
            $errorMember=$conn->error;
        }
    }

    $sql="select * from customise_email where com_id='$COMPANY_ID'";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $email_template[] = $row;
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
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Customise Email Template</div>
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
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #212529; color: white;">
                            <tr>
                            <th>Serial Number</th>
                             <th>Name</th>
                             <th>Action</th>
                            </tr>
                        </thead>
                        <tbody> 
 
                    
                     <?php 
                            if (isset($email_template)) 
                            {
                                $i = 1;
                                foreach ($email_template as $detail) 
                                {     
                     ?> 
                                     <tr> 
                                         <td  id="serialNo<?=$i?>"><?=$i?></td> 
                                        <td  id="name<?=$i?>"><?=$detail['name'];?></td>    
                                           
                                        <td style="width:30%">
                                            <a href="viewcustomiseemail?token=<?=$detail['id']?>" class="btn btn-primary"><i class="fa fa-eye">&nbspView</i></a>
                                            <a href="customemailedit?token=<?=$detail['id']?>" class="btn btn-success"><i class="fa fa-edit">&nbspEdit</i></a>
                                            <button class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>"><i class="fa fa-trash-o"></i> Delete</button>
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