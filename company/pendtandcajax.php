
<?php
    require_once '../lib/core.php';
    
    if(isset($_POST['managerid']))
    {
        $mid = $_POST['managerid'];
        $i=1;
        $pms = "'".implode($mid,"','")."'";

        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, c.l_name as pml_name , p.termandcondition as tnc from users u, projects p, com_admins c where u.pm_id in ($pms) and p.pm_id=u.pm_id and c.id=u.pm_id and u.p_id=p.id and u.pay_status=3  and p.termandcondition=1 and p.signortick=1 order by u.email_date";
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
        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, c.l_name as pml_name , p.termandcondition as tnc from users u, projects p, com_admins c where u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id and u.pay_status=3  and p.termandcondition=1 and p.signortick=1 order by u.email_date";
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
           
        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, c.l_name as pml_name, p.termandcondition as tnc  from users u, projects p, com_admins c where u.pm_id in ($pms) and u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and u.pay_status=3 and p.termandcondition=1 and p.signortick=1 order by u.email_date";
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