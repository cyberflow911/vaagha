<?php
    require_once 'header.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['add']))
        {
            $reg_num=$_POST['reg_num'];
            $com_name=$_POST['com_name'];
            $address=$_POST['address'];
            $tr_address=$_POST['traddress'];
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
            $tr_address=$_POST['traddress'];
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

<div class="page-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Company Details</div>
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
            <br>
            <form method="post">
                <div class="row">
                    
                    <div class="col-md-5"> 
                        <div class="form-group">
                            <label>Company Reg. Number</label><br>   
                            <input type="text" style="font-size: 16px;" id="reg_num" name="reg_num" class="form-control" value="<?=$com_data['reg_num']?>" required>  
                        </div> 
                    </div>
                    <div class="col-md-5"> 
                        <div class="form-group">
                            <label>Company Name</label><br> 
                            <input type="text" style="font-size: 16px;" id="com_name" name="com_name" class="form-control" value="<?=$com_data['com_name']?>" required>  
                        </div> 
                    </div>

                </div>  
                
                <div class="row">
                    <div class="col-md-10"> 
                        <div class="form-group">
                            <label style="margin-left:5px">Registered Address</label><br> 
                            <textarea id="traddress" name="traddress" class="form-control" rows="3" style="resize: none;width: 100%;border:none; font-size: 16px;" required><?=$com_data['tr_address']?></textarea>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5"> 
                        <div class="form-group">
                            <label>Post Code</label><br> 
                            <input type="text"  id="post" style="font-size: 16px;" name="post" class="form-control" value="<?=$com_data['post']?>" required>  
                        </div> 
                    </div> 
                </div>
                <div class="row">
                    <div class="col-xs-4">
                    <input type="checkbox" id="traddresscheck" name="traddresscheck">
                    <label for="traddresscheck">Same as registered address</label>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-10"> 
                        <div class="form-group">
                            <label style="margin-left:5px">Communication Address</label><br> 
                            <textarea id="address" name="address" class="form-control" rows="3" style="resize: none;width: 100%;border:none; font-size: 16px;" required><?=$com_data['address']?></textarea>
                        </div> 
                    </div>
                </div>
                
                <br>
                <div class="row">
                    <div class="col-md-5"> 
                        <div class="form-group">
                            <label>Post Code</label><br> 
                            <input type="text"  id="cpost" style="font-size: 16px;" name="cpost" class="form-control" value="<?=$com_data['cpost']?>" required>  
                        </div> 
                    </div>
                
                    <div class="col-md-5"> 
                        <div class="form-group">
                            <label>VAT</label><br> 
                            <input type="text" name="vat" style="font-size: 16px;" oninput="check(this)" id="vat" value="<?=$com_data['vat']?>" class="form-control">
                        </div> 
                    </div> 
                </div> <br>
                
    
                    <?php
                            if(isset($com_data))
                            {
                    ?>
                                    <button type="submit" name="edit" class="btn btn-primary" style="margin-top:10; padding: 10px; font-size: 14px;" value="">Edit</button>
                        <?php
                            }
                            else
                            {
                        ?>
                                    
                                    <button type="submit" name="add" class="btn btn-primary" style="margin-top:10; padding: 10px; font-size: 14px;" value="">Add</button>
                    <?php
                            }
                    ?> 
            </form>
        </div>
    </div>
</div>

<div class="control-sidebar-bg"></div>
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

        function check(input) {
        if (input.value.length >12) {
            input.setCustomValidity('The number of character must be smaller or equals to 12.');
        } else {
            // input is fine -- reset the error message
            input.setCustomValidity('');
        }
        }
    });
</script>



