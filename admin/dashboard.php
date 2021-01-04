<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'left-navbar.php';

//  $sql="select commission from profiles where u_id=$id";
//    $res=$conn->query($sql);
//    $row = $res->fetch_assoc();

//$sql="SELECT count(*) as count from bookings,user_profiles where user_profiles.u_id=bookings.cust_id and lower(bookings.status)='confirm' and bookings.vendor_id=$id order by bookings.id desc";
//    $res=$conn->query($sql);
//    $ab = $res->fetch_assoc();
//
//$sql="select IFNULL(sum(order_amount),0) as sum from orders where u_id=$id and id in (select o_id from payment_log where status='Sucess') or id in (select o_id from wallet_uses where cash_status='Sucess')";
//    $res=$conn->query($sql);
//    $abc = $res->fetch_assoc();
//
//$sql="select IFNULL(sum(s_amount), 0) as sum from sales where u_id=$id ";
//    $res=$conn->query($sql);
//    $abcd = $res->fetch_assoc();
//    
//    
//    //FETCH PENDING ORDERS
//      $sql="SELECT count(*) as count  from bookings where lower(bookings.status)='placed' and bookings.vendor_id=$id order by bookings.id desc limit 5";


    $sql="SELECT count(id) as count from users";
    if($result=$conn->query($sql)){
        if($result->num_rows>0){
            while($row=$result->fetch_assoc())
            {
                $usersCount=$row['count'];
            }
        }
//        print_r($pending_orders);
    }
    
    
    $sql="SELECT count(id) as count from qna";
    if($result=$conn->query($sql)){
        if($result->num_rows>0){
            while($row=$result->fetch_assoc())
            {
                $qCount=$row['count'];
            }
        }
//        print_r($pending_orders);
    }
    $sql="SELECT count(id) as count from qna where answer=''";
    if($result=$conn->query($sql)){
        if($result->num_rows>0){
            while($row=$result->fetch_assoc())
            {
                $NqCount=$row['count'];
            }
        }
//        print_r($pending_orders);
    }
      $sql="SELECT count(id) as count from qna where answer!=''";
    if($result=$conn->query($sql)){
        if($result->num_rows>0){
            while($row=$result->fetch_assoc())
            {
                $AqCount=$row['count'];
            }
        }
 
    }
    
 
       
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Users</span>
              <span class="info-box-number"><?=$usersCount?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Queries</span>
              <span class="info-box-number"><?=$qCount;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text" style="font-size:13px">Pending Queries</span>
              <span class="info-box-number"><?=$NqCount?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text" style="font-size:13px">Answered Queries</span>
              <span class="info-box-number"><?=$AqCount?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pending Bookings
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           
            <!-- /.box-header -->
            
            <div class="box-body">
              
                <?php
                        $i = 1;
                        if(isset($get_bookings))
                        {

                        
                            foreach ($get_bookings as $booking) 
                            {   
                                if(isset($checkOrder))
                                {
                            ?>
                <table id="example1" class="table table-bordered table-hover" style="border:1.5px solid black;margin-top:30px">
                 <tbody>
                           
                                <tr>
                                        <th>S.No</th>
                                    <td><?=$i?></td>
                                </tr>  
                                <tr>
                                     <th>Order ID</th>
                                    <td><?=$booking['id']?></td>
                                </tr> 
                               <tr> 
                                     <th>Customer Name</th>
                                <td><?=$booking['cust_name']?></td>
                                </tr> 
                               <tr> 
                                       <th>Contact No</th>
                                <td><?=$booking['contact_no']?></td>
                                </tr> 
                               <tr> 
                                   <th>Date Added</th>
                                 <td><?=date('d-M-y h:i A', strtotime($booking['time_statmpts']))?></td>
                                </tr> 
                               <tr> 
                                         <th>Status</th>
                                <td><?=ucwords($booking['status'])?></td>
                                </tr> 
                               <tr> 
                                     <th>Action</th>
                                <td>
                                    
                                   <div class="dropdown">
                                        <a href="view.php?a=<?=$booking['id'];?>"><button class="btn btn-primary"><i class="fa fa-eye"></i></button></a>
                                    </div>
                                </td>
                            </tr>
                             </tbody>
              </table>
                        <?php
                        $i++;
                        }
                    }
                }else
                    {
                ?>
                  
                        
                            <p>No Data Available</p>
                    
                <?php
                    }
                ?>
               
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
      
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Recap Report</h3>
                
            <div class="card card-primary card-outline">
               
              <div class="card-body">
                <div id="bar-chart" style="height: 300px;"></div>
              </div>
              <!-- /.card-body-->
            </div>
            </div>
            <!-- /.box-header -->
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
        
        
    <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Yearly Recap Report</h3>
                
            <div class="card card-primary card-outline">
<!--
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Bar Chart
                </h3>

                 
              </div>
-->
              <div class="card-body">
                <div id="bar-chartyear" style="height: 300px;"></div>
              </div>
              <!-- /.card-body-->
            </div>
            </div>
            <!-- /.box-header -->
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</section>

 
      <!-- Content Header (Page header) -->
<!--
        <section class="content-header">
          <h1>
           Today's Recurring Orders
          </h1>
        </section>
-->

    <!-- Main content -->
    
<!--
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
        <div class="alert alert-danger"><strong>Error! </strong>Due to Some Reasons.<br/><?=$error?></div> 
        <?php
                
            }
        ?>
        
    <div class="box">
        <div class="box-body">
          
         
                    <?php
                        if(isset($orders))
                        {
                            $x=1;
							 
                            foreach($orders as $o)
                            {
								$warning="";
								$demand=$o['sunday']+$o['monday']+$o['tuesday']+$o['wednesday']+$o['thursday']+$o['friday']+$o['saturday'];
								if($order['w_money']<=($demand*0.6))
								{
									$warning="btn-danger";
								}
                                ?>
                          <table id="example2" class="table table-bordered">
                           
                          <tbody>
                                <tr class="<?=$warning?>">
                                     <th>S.No</th>
                                    <td><?=$x;?></td>
                              </tr> 
                               <tr> 
                                        <th>Customer</th>
                                    <td id="customer<?=$x?>"><?=$o['f_name']." ".$o['l_name'];?></td>
                              </tr> 
                               <tr> 
                                          <th>Product</th>
                                    <td id="product<?=$x?>"><?=$o['name'];?></td>
                              </tr> 
                               <tr> 
                                        <th>Product Price</th>
                                    <td id="price<?=$x?>"><?=$o['price'];?></td>
                              </tr> 
                               <tr> 
                                        <th>Demand</th>
                                    <td id="demand<?=$x?>"><?=$o['today_value'];?></td>
                              </tr>
                              <tr>
                                        
                              <th>Delivery Type</th>
                                    <td id="dtype<?=$x?>"><?=$o['type'];?></td>
                              </tr>
                              <tr>
                                        <th>Wallet Money</th>
                                    <td><b id="wallet<?=$x?>">₹ <?=$o['w_money'];?></b></td>
                              </tr>
                              <tr>
                                         <th>Action</th>
                                    <td>
										<input type="hidden" value="<?=$o['sunday']?>" id="sun<?=$x?>">
										<input type="hidden" value="<?=$o['monday']?>" id="mon<?=$x?>">
                                        <input type="hidden" value="<?=$o['status']?>" id="status<?=$x?>">
										<input type="hidden" value="<?=$o['tuesday']?>" id="tue<?=$x?>">
										<input type="hidden" value="<?=$o['wednesday']?>" id="wed<?=$x?>">
										<input type="hidden" value="<?=$o['thursday']?>" id="thu<?=$x?>">
										<input type="hidden" value="<?=$o['friday']?>" id="fri<?=$x?>">
										<input type="hidden" value="<?=$o['saturday']?>" id="sat<?=$x?>">
										<input type="hidden" value="<?=$o['user_id']?>" id="user<?=$x?>">
										<input type="hidden" value="<?=$o['product_id']?>" id="pid<?=$x?>">
                                        <input type="hidden" value="<?=$o['contact']?>" id="contact<?=$x?>">
										<input type="hidden" value="<?=date("d-m-Y",strtotime($o['start_date']));?>" id="start_date<?=$x?>">
									  <button title="" value="<?=$x;?>" class="btn btn-primary view_details" data-toggle="modal" data-target="#modal-default">
										  <i class="fa fa-eye"></i>
									   </button>
                                    </td>
								</tr>
                            </tbody>
               
                        </table>
                        <?php
                                
								$x++;
                            }
                        }else
                        {
                    ?>
                       
                                <p>No Data Available</p>
                        
                    <?php
                        }
                        ?>
             
        </div>
       
         /.box-footer
      </div>
      </section>
-->
</div>
      
    <!--Show Modal-->
		<div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Recurring Order Details</b></h4>
              </div> 
                <form method="post">
              <div class="modal-body">
                  <div class="row">
                         
                              <div class="col-md-6">
                                  <label>Customer :</label><input type="text" class="form-control" name="ename" id="c_name"required disabled>
                              </div>
							  <div class="col-md-6">
                                  <label>Wallet Money :</label><input type="text" class="form-control" name="w_money" id="w_money"required disabled>
                              </div>
							  <div class="col-md-6">
								<br/>
                                  <label>Product :</label><input type="text" class="form-control" name="ename" id="p_name"required disabled>
                              </div>
							  <div class="col-md-6">
                                  <br/><label>Product Price :</label>
								  <input type="text" class="form-control" id="p_price" required disabled>
								  <input type="hidden" name="pprice" id="pprice">
								  <input type="hidden" name="tdemand" id="tdemand">
                              </div>
							  <div class="col-md-6">
                                  <br/><label>Delivery Type :</label><input type="text" class="form-control" name="ename" id="d_type"required disabled>
                              </div>
							  <div class="col-md-6">
                                  <br/><label>Starting From :</label><input type="text" class="form-control" name="ename" id="starting"required disabled>
                              </div>
							  <div class="col-md-12">
                                  <br/><label>Demand (Today - <span id="total_demand"></span>):</label>
								  <table class="table table-bordered table-hover">
									<tr>
										<th>Sunday</th><td id="sun"></td>
										<th>Monday</th><td id="mon"></td>
										<th>Tuesday</th><td id="tue"></td>
										<th>Wednesday</th><td id="wed"></td>
									</tr>
									<tr>
										<th>Thursday</th><td id="thu"></td>
										<th>Friday</th><td id="fri"></td>
										<th>Saturday</th><td id="sat"></td>										
									</tr>
								  </table>
                              </div>
                              <div class="col-md-12">
                                  <label>Order Status:</label>
                                  <select class="form-control" name="order_status" id="order_status">
                                    <?php
                                        if(isset($statuses))
                                        {
                                            foreach($statuses as $s)
                                            {
                                    ?>
                                      <option value="<?=$s['status_name']?>"><?=$s['status_name']?></option>
                                      <?php
                                            }
                                        }
                                      ?>
                                  </select>        
                              </div>
                  </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<input type="hidden" name="user" id="user">
                <input type="hidden" id="contact" name="contact">
                <button type="submit" name="save" id="confirm" class="btn btn-primary">Save Changes</button>
              </div>
                </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
	   
  <div class="control-sidebar-bg"></div>
<?php
require_once 'js-links.php';
?>
<!-- ChartJS -->
<script src="plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="plugins/flot-old/jquery.flot.resize.min.js"></script>
<script>    
$(document).ready(function(){
   
    
      $.ajax({
        url : "ajax_admin.php",
        type : "POST",
        data : {
    		dashboard:'vendor'
    	},
        success : function(a){
            var graphValues=JSON.parse(a);
            
            var year18=[];
        
            $.each(graphValues,function(key,value)
           {
                year18.push([value.month,value.sale]);
               
                
            })
            
 
            
             var bar_data = {
                  data : year18,
                  bars: { show: true }
                }
                $.plot('#bar-chartyear', [bar_data], {
                  grid  : {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    tickColor  : '#f3f3f3'
                  },
                  series: {
                     bars: {
                      show: true, barWidth: 0.1, align: 'center',
                    },
                  },
                  colors: ['#3c8dbc'],
                  xaxis : {
                    ticks: [[1,'January'], [2,'February'], [3,'March'], [4,'April'], [5,'May'], [6,'June'], [7,'July'], [8,'August'], [9,'September'],[10,'Octobar'],[11,'Navember'],[12,'December']]
                  }
                })
            
            },
            error : function(data) {
    
            }
             
    });
    
      $.ajax({
        url : "ajax_admin.php",
        type : "POST",
        data : {
    		dashboardmonth:'vendor'
    	},
        success : function(a){
            var graphValues=JSON.parse(a);
            
            var month30=[];
            
            $.each(graphValues,function(key,value)
           {
                month30.push([value.day,value.sale]);
                
                
            })
            
 
            
             var bar_data = {
                  data : month30,
                  bars: { show: true }
                }


                $.plot('#bar-chart', [bar_data], {
                  grid  : {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    tickColor  : '#f3f3f3'
                  },
                  series: {
                     bars: {
                      show: true, barWidth: 0.1, align: 'center',
                    },
                  },
                  colors: ['#3c8dbc'],
                  
                })

            
            
            },
            error : function(data) {
    
            }
             
    });
    
    
    
    $(".view_details").click(function(){
		var i=$(this).val();
		$("#c_name").val($("#customer"+i).html());                 
		$("#p_name").val($("#product"+i).html());
		$("#p_price, #pprice").val($("#price"+i).html());
		$("#d_type").val($("#dtype"+i).html());
		$("#w_money").val($("#wallet"+i).html());
		$("#starting").val($("#start_date"+i).val());
		$("#total_demand").html($("#demand"+i).html());
		$("#tdemand").val($("#demand"+i).html());
		$("#sun").html($("#sun"+i).val());
		$("#mon").html($("#mon"+i).val());
		$("#tue").html($("#tue"+i).val());
		$("#wed").html($("#wed"+i).val());
		$("#thu").html($("#thu"+i).val());
		$("#fri").html($("#fri"+i).val());
		$("#sat").html($("#sat"+i).val());
		$("#user").val($("#user"+i).val());
        $("#contact").val($("#contact"+i).val());
		$("#order_status option[value="+$("#status"+i).val()+"]").attr('selected',true);		
        $("#confirm").val($("#pid"+i).val());		
	});
    
    

  
});
    
    
   

</script>