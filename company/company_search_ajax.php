<?php



    // curl -XGET -u c9e35900-7433-4a1d-a67e-0e2d6bb90ab0:








 

 
    if(isset($_POST['companyName']))

    {

        $com_name = $_POST['companyName'];

        $url = "https://api.company-information.service.gov.uk/search/companies?q=$com_name";

        $curl = curl_init();

        $headers = array(

            'Content-Type: application/json',

            'Authorization: Basic '.base64_encode("c9e35900-7433-4a1d-a67e-0e2d6bb90ab0".':' ),

            // 'Authorization: Basic c9e35900-7433-4a1d-a67e-0e2d6bb90ab0:'

            );

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = curl_exec($curl);

        curl_close($curl);

        echo rtrim($data,"1");



    }

    

    if(isset($_POST['companyNumber']))

    {

        $com_number = $_POST['companyNumber'];

        $url = "https://api.company-information.service.gov.uk/company/$com_number";

        $curl = curl_init();

        $headers = array(

            'Content-Type: application/json',

            'Authorization: Basic '.base64_encode("c9e35900-7433-4a1d-a67e-0e2d6bb90ab0".':' ),

            // 'Authorization: Basic c9e35900-7433-4a1d-a67e-0e2d6bb90ab0:'

            );

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = curl_exec($curl);

        curl_close($curl);

        echo rtrim($data,"1"); 

    }

    

?>