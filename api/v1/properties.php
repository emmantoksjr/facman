<?php
include("../../includes/mysqli_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if (isset($_GET['access_code'])) {
            $access_key = $_GET['access_code'];
            $verify = auth($access_key);
            if ($verify == 1) {
                if (!empty($_GET["id"])) {
                    $id = intval($_GET["id"]);
                    get_properties();
                } else {
                    echo generateJSON('error', 500, "Facilitator ID is required.", null);
                }
            } else {
                echo generateJSON('error', 500, "Authentication Failed.", null);
            }
            break;
        } else {
            echo generateJSON('error', 502, "Access Token Required.", null);
        }    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        echo generateJSON('error', 500, "Request Method Not Allowed.", null);
        break;
}

function get_properties() {
    global $dbcon; 
    $access_key = $_GET['access_code'];
    $q2 = "SELECT id FROM facilitators WHERE secret_key='$access_key'";
    $check = mysqli_query($dbcon, $q2);
    $re = mysqli_fetch_assoc($check);
    $facilitator_id = $re['id'];
    $query = "SELECT p.id, pd.property_id, p.facilitator_id,p.company_id, t.title, pd.first_name, pd.last_name, pd.email,pd.phone, pd.building_year, bt.type, pd.location,pd.service
                    FROM properties p 
                    INNER JOIN property_details pd
                    ON p.property_id = pd.property_id
                    JOIN title t 
                    ON t.id = pd.title
                    JOIN building_type bt 
                    ON bt.id = pd.type_id
                    WHERE p.facilitator_id = '$facilitator_id'";
    $result = mysqli_query($dbcon, $query);

    $response = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    echo generateJSON('success', 200, null, $response);
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
//    var_dump($check);
    $numrows = mysqli_num_rows($check);

    if ($numrows == 1) {
        return 1;
    } else {
        return 2;
    }
}
