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
                    get_property($id);
                } else {
                    echo generateJSON('error', 500, "Facilitator ID is required.", null);
                }
            } else {
                echo generateJSON('error', 500, "Authentication Failed.", null);
            }
            break;
        } else {
            echo generateJSON('error', 502, "Access Token Required.", null);
        }



    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        echo generateJSON('error', 500, "Request Method Not Allowed.", null);
        break;
}
function get_property($id = 0) {
    global $dbcon;
    $query = "SELECT * FROM properties p "
            . "INNER JOIN property_details pd "
            . "ON p.property_id = pd.property_id";
    if ($id != 0) {
        $query.=" WHERE p.id='" . $id . "' LIMIT 1";
    }
    $result = mysqli_query($dbcon, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $response = $row;
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
