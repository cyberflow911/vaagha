<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['add']))
        {
            $reg_num=$_POST['reg_num'];
            $com_name=$_POST['com_name'];
            $address=$_POST['address'];
            $tr_address=$_POST['tr_address'];
            $post=$_POST['post'];
            $vat=$_POST['vat'];
            $sql="insert into companies(reg_num, com_name, address, tr_address, cpost, post, vat, status) values('$reg_num', '$com_name', '$address', '$tr_address', '$cpost', '$post', '$vat','2')";
            if($conn->query($sql))
            {
                $resMember = true;
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
    }
       
    if(isset($_GET['token'])&& !empty($_GET['token']))
    {
        $token=$_GET['token'];
        if(isset($_POST['edit']))
        {  
            $reg_num=$_POST['reg_num'];
            $com_name=$_POST['com_name'];
            $address=$_POST['address'];
            $tr_address=$_POST['tr_address'];
            $post=$_POST['post'];
            $cpost=$_POST['cpost'];
            $vat=$_POST['vat'];
            $sql="update companies set address='$address', reg_num='$reg_num', com_name='$com_name', vat='$vat', post='$post', cpost='$cpost', tr_address='$tr_address'  where id='$token'";
            if($conn->query($sql))
            {
                $resMember = true;
            }
            else
            {
                $errorMember=$conn->error;
            }
        } 

        $sql = "select * from companies where id='$token'";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $com_data = $result->fetch_assoc();  
            } 
        }
       
    }       
    
?>
<style>
    .box-body{
	overflow: auto!important;
}
</style>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
          Company Details
        </h1>
    </section>
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
        
                <form method="post">
                    <div class="row">
                        
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Company Reg. Number</label><br>   
                                <input type="text"  id="reg_num" name="reg_num" class="form-control" value="<?=$com_data['reg_num']?>" required>  
                            </div> 
                        </div>
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Company Name</label><br> 
                                <input type="text"  id="com_name" name="com_name" class="form-control" value="<?=$com_data['com_name']?>" required>  
                            </div> 
                        </div>

                    </div>  
                    
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label style="margin-left:5px">Registered Address</label><br> 
                                <textarea id="traddress" name="traddress" class="form-control" rows="3" style="resize: none;width: 100%;border:none;" required><?=$com_data['tr_address']?></textarea>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Post Code</label><br> 
                                <input type="text"  id="post" name="post" class="form-control" value="<?=$com_data['post']?>" required>  
                            </div> 
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label style="margin-left:5px">Communication Address</label><br> 
                                <textarea id="address" name="address" class="form-control" rows="3" style="resize: none;width: 100%;border:none;" required><?=$com_data['address']?></textarea>
                            </div> 
                        </div>
                    </div>
                    
                    <?php
                    if(!isset($com_data))
                    {
                    ?>
                    <div class="row">
                        <div class="col-xs-4">
                        <input type="checkbox" id="traddresscheck" name="traddresscheck">
  						<label for="traddresscheck">Same as registered address</label>
                        </div>
                    </div> 
                    <?php
                    }
                    ?>
                    <br>
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Post Code</label><br> 
                                <input type="text"  id="cpost" name="cpost" class="form-control" value="<?=$com_data['cpost']?>" required>  
                            </div> 
                        </div>
                    
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>VAT</label><br> 
                                <input type="text" name="vat" id="vat" value="<?=$com_data['vat']?>" class="form-control">
                            </div> 
                        </div> 
                    </div>
                    
        
                        <?php
                                if(isset($com_data))
                                {
                        ?>
                                        <button type="submit" name="edit" class="btn btn-primary" style="margin-top:10" value="">Edit</button>
                            <?php
                                }
                                else
                                {
                            ?>
                                        
                                        <button type="submit" name="add" class="btn btn-primary" style="margin-top:10" value="">Add</button>
                        <?php
                                }
                        ?> 
                </form>
         

    </section>
</div>
<?php
    require_once 'js-links.php';
?>

<script>
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function() {
            if ($(this).prop("checked") == true) {
                var address = $("#traddress").val();

                $("#address").html(address);
                $("#cpost").val($("#post").val())
            } else if ($(this).prop("checked") == false) {
                $("#address").html("");
                $("#cpost").val("");
            }
        });
    });
</script>



