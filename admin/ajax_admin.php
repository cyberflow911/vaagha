    <?php
    require_once '../lib/core.php';

    //Dashboard yearly Graph Data 
	if(isset($_POST['dashboard']))
    {
		  $sql="SELECT count(id) as sale,MONTH(time_stamp) as month FROM bookings  GROUP BY MONTH(time_stamp)";
		$result=$conn->query($sql);
		if($result->num_rows>0){
			while($row=$result->fetch_assoc())
			{
				$graphdata[]=$row;
				
			}
		}
        
		echo json_encode($graphdata);
	}

 //Dashboard monthly Graph Data 
if(isset($_POST['dashboardmonth']))
    {
            $month =date('m');
  		  $sql="SELECT count(id) as sale,DAY(time_stamp) as day FROM bookings where MONTH(time_stamp)='$month' GROUP BY DAY(time_stamp)";
		$result=$conn->query($sql);
		if($result->num_rows>0){
			while($row=$result->fetch_assoc())
			{
				$graphdata[]=$row;
				
			}
		}
        
		echo json_encode($graphdata);
	}
?>