<?php
  require_once 'header.php';
  require_once 'navbar.php';
  require_once 'left-navbar.php';
  $sql="select id,name from products";
  $result=$conn->query($sql);
    while($row=$result->fetch_assoc())
    {
        $prods[]=$row;
    }
?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Download Data
      </h1>
   </section>
   <br>
   <section class="content">
	<?php
         if(isset($success))
            {
                 ?>
                <div class="alert alert-success"><strong>Success! </strong> your request successfully updated.</div> 
            <?php
            }
            else if(isset($error))
            {
                ?>
        <div class="alert alert-danger"><strong>Error! </strong>Due to Some Reasons.</div> 
        <?php
                
            }
        ?>
       <form action="get-mass-data.php" id="get_data" method="post">
            <div class="box">
                <div class="box-head">
                    <h3 style="margin-left:20px;">Orders Data</h3>
                </div>
                <div class="box-body" style="margin-top:30px;">
                    <div class="row container">

                            <div class="form-group row">
                                <label class="col-md-2 control-label" style="text-align: right">Select Page</label>
                                <div class="col-md-8">
                                        <select class="form-control" name="data_table" id="data_table" required >
                                            <option value="all">All Products</option>
                                            <?php
                                            if(isset($prods))
                                            {
                                                foreach($prods as $prod)
                                                {
                                                ?>
                                                <option value="p<?=$prod['id']?>"><?=$prod['name']?></option>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                </div>
                                
                                
                            </div>
                            <div class="form-group row" id="fromdate" >
                                <label class="col-md-2 control-label" style="text-align: right">From</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" id="fdate" name="fdate">
                                </div>
                                </div>
                                <div class="form-group row" id="todate">
                                <label class="col-md-2 control-label" style="text-align: right">To</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" id="ldate" name="ldate">
                                </div>
                                </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label" style="text-align: right">File Type</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="data_type" required>
                                        <option value="csv">CSV</option>
                                    </select>
                                </div>
                            </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <br>
                            <button type="submit" name="details" id="details" class="btn btn-primary pull-right" value="<?=$page['id'];?>">Download</button>
                        </div>
                
                  </div>
                    </div>
         </div>
      
            </div>
        </form>
        
        <form action="get-mass-data.php" id="get_data" method="post">
        <!-- Default box -->
            <div class="box">
                <div class="box-head">
                    <h3 style="margin-left:20px;">Other Data</h3></h3>
                </div>
                <div class="box-body" style="margin-top:30px;">
                    <div class="row container">

                            <div class="form-group row">
                                <label class="col-md-2 control-label" style="text-align: right">Select Page</label>
                                <div class="col-md-8">
                                        <select class="form-control" name="data_table" required>
                                            <option value="categories">Categories</option>
                                            <option value="products">Products</option>
                                            <option value="customers">Customers</option>
                                            <option value="local_customers">Local Customers</option>
                                            <option value="queries">Queries</option>
                                            <option value="taxes">Taxes</option>
                                        </select>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label" style="text-align: right">File Type</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="data_type" required>
                                        <option value="csv">CSV</option>
                                        <!--<option value="pdf">PDF</option>-->
										<option value="txt">TEXT</option>
										<option value="xml">XML</option>
                                    </select>
                                </div>
                            </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <br>
                            <button type="submit" name="details" id="details" class="btn btn-primary pull-right" value="<?=$page['id'];?>">Download</button>
                        </div>
                    <!-- /.form-group -->
                  </div>
                    </div>
         </div>
         <!-- /.box-footer-->

            </div>
        </form>
   </section>
</div>
<?php
   require_once 'js-links.php';
?>
<script>

// $('#data_table').change(function() {
//     var val= $(this).val() ;
//     if(val=="all")
//     {
//         $("#fromdate").hide();
//         $("#todate").hide();
//     }
//     else
//     {
//         $("#fromdate").show();
//         $("#todate").show();
//     }
// });

</script>