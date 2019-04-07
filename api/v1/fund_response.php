<?php
include("../../includes/mysqli_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if (isset($_GET['access_code'])) {
            $access_key = $_GET['access_code'];
            $verify = auth($access_key);
            if ($verify == 1) {
                    fund_response();
            } else {
                echo generateJSON('error', 500, "Authentication Failed.", null);
                break;
            }
        } else {
            echo generateJSON('error', 502, "Access Token Required.", null);
            break;
        }

        break;
    default:
//         Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        echo generateJSON('error', 405, "Request Method Not Allowed.", null);
        break;
}
function fund_response() {
    $facilitator_id = $_GET['f_id'];
    $property_id = $_GET['p_id'];
    require '../../includes/mysqli_connect.php';
    $c_q ="SELECT fd.request_id, CONCAT(c.first_name,' ',c.last_name) AS name,"
                    . " fr.comment, r.response FROM fund_details fd JOIN contractors c "
                    . "on fd.contractor_id = c.id JOIN fund_reply fr on fd.request_id = fr.request_id "
                    . "JOIN response r on fr.response_id = r.id WHERE fd.property_id = '$property_id' "
                    . " AND fd.facilitator_id = '$facilitator_id' AND treated = '1'" ;
            $c_m = mysqli_query($dbcon, $c_q);
            while( $row = mysqli_fetch_assoc($c_m)){
                $response[] = $row;
            }
      if ($response == null){
                $response = [];
                 echo generateJSON('success', 200, null, $response);
            }else{
                 echo generateJSON('success', 200, null, $response);
            }
           
}
function generateJSON($status, $code, $message = null, $data = null) {
    $json_result = null;

    if ($status == 'error') {
        $json_result = json_encode([
            'status' => $status,
            'code' => $code,
            'message' => $message
        ]);
    } elseif ($status == 'success') {
        $json_result = json_encode([
            'status' => $status,
            'code' => $code,
            'data' => $data
        ]);
    } else {
        return null;
    }

    return $json_result;
}
function auth($access_key) {
    global $dbcon;
    $q = "select id from facilitators where secret_key='$access_key'";
    $check = mysqli_query($dbcon, $q);
    $numrows = mysqli_num_rows($check);
    if ($numrows == 1) {
        return 1;
    } else {
        return 2;
    }
}
