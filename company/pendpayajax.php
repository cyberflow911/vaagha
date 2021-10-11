<?php

    require_once '../lib/core.php';

    $date=date("Y-m-d");

    

    if(isset($_POST['managerid']))

    {

        $mid = $_POST['managerid'];

        $pms = "'".implode($mid,"','")."'";



        $sql = "select u.*, p.title as p_title, p.project_reference as p_ref, b.sort_code, b.account_num, b.p_tandc_date as tncdate, c.f_name as pmf_name, c.l_name as pml_name  from users u, bank_details b, projects p, com_admins c where u.pm_id in ($pms) and u.p_id=p.id and u.pm_id=c.id and u.pay_status=4 and u.id=b.u_id order by u.email_date";

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

            $sfirst=substr($data['sort_code'],0,2);

            $ssecond=substr($data['sort_code'],2,2);

            $sthird=substr($data['sort_code'],4,2);  

            $str='<tr> 

            <td style="  text-align: center; " id="f_name'.$i.'">'.$data['f_name'].' '.$data['l_name'].'</td> 

            <td style="  text-align: center; " id="email'.$i.'">'.$data['email'].'</td> 

            <td style="  text-align: center; " id="p_ref'.$i.'">'.$data['p_ref'].'</td>

            <td style="  text-align: center; " id="receiver'.$i.'">PERSON</td>

            <td style="  text-align: center; " id="source'.$i.'">SOURCE</td>

            <td style="  text-align: center; " id="incentive'.$i.'">'.$data['incentive'].'</td>

            <td style="  text-align: center; " id="source_currency'.$i.'">GBP</td>

            <td style="  text-align: center; " id="target_currency'.$i.'">GBP</td>

            <td style="  text-align: center; " id="sort_code'.$i.'">'.$sfirst.'-'.$ssecond.'-'.$sthird.'</td>

            <td style="  text-align: center; " id="acc_num'.$i.'">'.$data['account_num'].'</td>
            <td style="  text-align: center; " id="errorcode'.$i.'"></td>
            <td style="  text-align: center; " id="errormsg'.$i.'"> </td></tr>';

            $output['str'].=$str;

            $i++;

        }

        echo json_encode($output);

        

    }



    if(isset($_POST['projectid']))

    {



        $project = $_POST['projectid'];

        $pjs = "'".implode($project,"','")."'";

        $sql = "select u.*, p.title as p_title, p.project_reference as p_ref, b.sort_code, b.account_num, b.p_tandc_date as tncdate, c.f_name as pmf_name, c.l_name as pml_name  from users u, bank_details b, projects p, com_admins c where  u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and u.pay_status=4 and u.id=b.u_id order by u.email_date";

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

            $sfirst=substr($data['sort_code'],0,2);

            $ssecond=substr($data['sort_code'],2,2);

            $sthird=substr($data['sort_code'],4,2);  

            $str='<tr> 

            <td style="  text-align: center; " id="f_name'.$i.'">'.$data['f_name'].' '.$data['l_name'].'</td> 

            <td style="  text-align: center; " id="email'.$i.'">'.$data['email'].'</td> 

            <td style="  text-align: center; " id="p_ref'.$i.'">'.$data['p_ref'].'</td>

            <td style="  text-align: center; " id="receiver'.$i.'">PERSON</td>

            <td style="  text-align: center; " id="source'.$i.'">SOURCE</td>

            <td style="  text-align: center; " id="incentive'.$i.'">'.$data['incentive'].'</td>

            <td style="  text-align: center; " id="source_currency'.$i.'">GBP</td>

            <td style="  text-align: center; " id="target_currency'.$i.'">GBP</td>

            <td style="  text-align: center; " id="sort_code'.$i.'">'.$sfirst.'-'.$ssecond.'-'.$sthird.'</td>

            <td style="  text-align: center; " id="acc_num'.$i.'">'.$data['account_num'].'</td>
            <td style="  text-align: center; " id="errorcode'.$i.'"></td>
            <td style="  text-align: center; " id="errormsg'.$i.'"> </td></tr>';

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

           

        $sql = "select u.*, p.title as p_title, p.project_reference as p_ref, b.sort_code, b.account_num, b.p_tandc_date as tncdate, c.f_name as pmf_name, c.l_name as pml_name  from users u, bank_details b, projects p, com_admins c where u.pm_id in ($pms) and u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and u.pay_status=4 and u.id=b.u_id order by u.email_date";
        
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

            $sfirst=substr($data['sort_code'],0,2);

            $ssecond=substr($data['sort_code'],2,2);

            $sthird=substr($data['sort_code'],4,2);  

            $str='<tr> 

            <td style="  text-align: center; " id="f_name'.$i.'">'.$data['f_name'].' '.$data['l_name'].'</td> 

            <td style="  text-align: center; " id="email'.$i.'">'.$data['email'].'</td> 

            <td style="  text-align: center; " id="p_ref'.$i.'">'.$data['p_ref'].'</td>

            <td style="  text-align: center; " id="receiver'.$i.'">PERSON</td>

            <td style="  text-align: center; " id="source'.$i.'">SOURCE</td>

            <td style="  text-align: center; " id="incentive'.$i.'">'.$data['incentive'].'</td>

            <td style="  text-align: center; " id="source_currency'.$i.'">GBP</td>

            <td style="  text-align: center; " id="target_currency'.$i.'">GBP</td>

            <td style="  text-align: center; " id="sort_code'.$i.'">'.$sfirst.'-'.$ssecond.'-'.$sthird.'</td>

            <td style="  text-align: center; " id="acc_num'.$i.'">'.$data['account_num'].'</td>
            <td style="  text-align: center; " id="errorcode'.$i.'"></td>
            <td style="  text-align: center; " id="errormsg'.$i.'"> </td></tr>';

            $output['str'].=$str;

            $i++;

        }
        echo json_encode($output);

    }

?>