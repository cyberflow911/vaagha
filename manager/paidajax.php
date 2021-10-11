<?php
    require_once '../lib/core.php';

    if(isset($_POST['projectid']))
    {
        $project = $_POST['projectid'];
        $pjs = "'".implode($project,"','")."'";
        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, c.l_name as pml_name , p.termandcondition as tnc from users u, projects p, com_admins c where u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id and u.pay_status=5";
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
        $output['str']=" ";
        $i=1;
        foreach($res as $data)
        {
            $date1 = $data['tncdate'];
                                            
            $dateDiff = dateDiffInDays($date1, $date);
            if($dateDiff==0)
            {
                $dateDiff="Today";
            }
            $str='<tr> 
            <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value='.$data['id'].'></td> 
            <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
            <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
            <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
            <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
            <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
            <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
            <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['pay_reference'].'</td>
            <td style="  text-align: center; " id="paid_date<?=$i?>">'.$data['paid_date'].'</td> </tr>';
            $output['str'].=$str;
            $i++;
        }
        echo json_encode($output);
    }

?>