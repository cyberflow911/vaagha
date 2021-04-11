<?php
    require_once '../lib/core.php';
    
    if(isset($_POST['managerid']))
    {
        $mid = $_POST['managerid'];
        $i=1;
        $pms = "'".implode($mid,"','")."'";

        $sql = "select u.*, p.title as p_title, p.project_reference as p_ref, b.p_tandc_date as tncdate, c.f_name as pmf_name, c.l_name as pml_name  from users u, projects p, bank_Details b, com_admins c where u.pm_id in ($pms) and p.pm_id=u.pm_id and c.id=u.pm_id and u.p_id=p.id and u.pay_status=4 and u.id=b.u_id order by u.email_date";
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
        $i++;
        echo json_encode($res);
        
    }

    if(isset($_POST['projectid']))
    {

        $project = $_POST['projectid'];
        $pjs = "'".implode($project,"','")."'";
        $sql = "select u.*, p.title as p_title, p.project_reference as p_ref, b.p_tandc_date as tncdate, c.f_name as pmf_name, c.l_name as pml_name  from users u, projects p,bank_Details b, com_admins c where u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id and u.pay_status=4 and u.id=b.u_id order by u.email_date";
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

    if(isset($_POST['manager'])&&isset($_POST['project']))
    {
         
        $pmid = $_POST['manager'];
        $project = $_POST['project'];
        $pms = "'".implode($pmid,"','")."'";
        $pjs = "'".implode($project,"','")."'";
           
        $sql = "select u.*, p.title as p_title, p.project_reference as p_ref, b.p_tandc_date as tncdate, c.f_name as pmf_name, c.l_name as pml_name  from users u, bank_Details b, projects p, com_admins c where u.pm_id in ($pms) and u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and u.pay_status=4 and u.id=b.u_id order by u.email_date";
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
    else
    {
        echo $conn->error;
    }
?>