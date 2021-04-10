
<?php
    require_once '../lib/core.php';
    
    if(isset($_POST['projectid']))
    {
        $project = $_POST['projectid'];
        $pjs = "'".implode($project,"','")."'";
        $sql = "select u.*, p.title as p_title, p.termandcondition as tnc from users u, projects p where u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=p.pm_id and u.pay_status=3  and p.termandcondition=1 and p.signortick=1";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $res[]=$row;
                }
            }
        }
        echo json_encode($res);
    }
?>