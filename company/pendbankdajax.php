<?php

    require_once '../lib/core.php';

    $date=date("Y-m-d");

    if(isset($_POST['managerid']))

    {

        $mid = $_POST['managerid'];

        $pms = "'".implode($mid,"','")."'";



        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, c.l_name as pml_name , p.termandcondition as tnc from users u, projects p, com_admins c where u.pm_id in ($pms) and p.pm_id=u.pm_id and c.id=u.pm_id and u.p_id=p.id and u.pay_status=1 order by u.email_date";

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

            $date1 = $data['email_date'];

                                            

            $dateDiff = dateDiffInDays($date1, $date);

            if($dateDiff==0)

            {

                $dateDiff="Today";

            }

            $str='<tr> 

            <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value='.$data['id'].'></td> 

            <td style="  text-align: center; " id="name<?=$i?>">'.$data['f_name'].'</td> 

            <td style="  text-align: center; " id="name<?=$i?>">'.$data['l_name'].'</td> 

            <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 

            <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>

            <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>

            <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>

            <td style="  text-align: center; " id="email_date<?=$i?>">'.$data['email_date'].'</td>

            <td style="  text-align: center; " id="days<?=$i?>">'.$dateDiff.'</td>

            <td><a class="btn btn-primary" target="_blank" href="bankdetails?uid='.$data['id'].'">Fill Bank Details</a></td> </tr>';

            $output['str'].=$str;

            $i++;

        }



        echo json_encode($output);

        

    }



    if(isset($_POST['projectid']))

    {

        $project = $_POST['projectid'];

        $pjs = "'".implode($project,"','")."'";

        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, c.l_name as pml_name , p.termandcondition as tnc from users u, projects p, com_admins c where u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id and u.pay_status=1 order by u.email_date";

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

            $date1 = $data['email_date'];

                                            

            $dateDiff = dateDiffInDays($date1, $date);

            if($dateDiff==0)

            {

                $dateDiff="Today";

            }

            $str='<tr> 

            <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value='.$data['id'].'></td> 

            <td style="  text-align: center; " id="name<?=$i?>">'.$data['f_name'].'</td> 

            <td style="  text-align: center; " id="name<?=$i?>">'.$data['l_name'].'</td> 

            <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 

            <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>

            <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>

            <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>

            <td style="  text-align: center; " id="email_date<?=$i?>">'.$data['email_date'].'</td>

            <td style="  text-align: center; " id="days<?=$i?>">'.$dateDiff.'</td>

            <td><a class="btn btn-primary" target="_blank" href="bankdetails?uid='.$data['id'].'">Fill Bank Details</a></td> </tr>';

            $output['str'].=$str;

            $i++;

        }



        echo json_encode($output);

    }



    if(isset($_POST['manager'])&&isset($_POST['project']))

    {

         

        $pmid = $_POST['manager'];

        $project = $_POST['project'];

        $pms = "'".implode($pmid,"','")."'";

        $pjs = "'".implode($project,"','")."'";

           

        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, c.l_name as pml_name, p.termandcondition as tnc  from users u, projects p, com_admins c where u.pm_id in ($pms) and u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and u.pay_status=1 order by u.email_date";

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

            $date1 = $data['email_date'];

                                            

            $dateDiff = dateDiffInDays($date1, $date);

            if($dateDiff==0)

            {

                $dateDiff="Today";

            }

            $str='<tr> 

            <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value='.$data['id'].'></td> 

            <td style="  text-align: center; " id="name<?=$i?>">'.$data['f_name'].'</td> 

            <td style="  text-align: center; " id="name<?=$i?>">'.$data['l_name'].'</td> 

            <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 

            <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>

            <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>

            <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>

            <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>

            <td style="  text-align: center; " id="email_date<?=$i?>">'.$data['email_date'].'</td>

            <td style="  text-align: center; " id="days<?=$i?>">'.$dateDiff.'</td>

            <td><a class="btn btn-primary" target="_blank" href="bankdetails?uid='.$data['id'].'">Fill Bank Details</a></td> </tr>';

            $output['str'].=$str;

            $i++;

        }



        echo json_encode($output);

    }

    else

    {

        echo $conn->error;

    }

?>