<?php
    require_once '../lib/core.php';
    
    if(isset($_POST['projectid']))
    {
        $project = $_POST['projectid'];
        $pjs = "'".implode($project,"','")."'";
        $sql = "select u.*, p.title as p_title, p.project_reference as p_ref, b.p_tandc_date as tncdate, c.f_name as pmf_name, c.l_name as pml_name  from users u, projects p,bank_details b, com_admins c where u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id and u.pay_status=4 and u.id=b.u_id";
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