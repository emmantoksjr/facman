<?php
include("../../includes/mysqli_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input')); 
            
            $email = $data->{'email'};
        if (isset($email)) {
            $verify = auth($email);
            if ($verify == 1) {
                $responses = "Facilitator Authentication Successful";
                $response = generateJSON('success', 200, null, $responses);
                echo $response;
            } else {
                echo generateJSON('error', 500, "Authentication Failed.", null);
            }
        } else {
            echo generateJSON('error', 502, "Email Address is Required.", null);
        }
        break;
    default:
        echo generateJSON('error', 500, "Request Method Not Allowed.", null);
        break;
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
function auth($email) {
    global $dbcon;
    $q = "select id from facilitators where email='$email'";
    $check = mysqli_query($dbcon, $q);
    $numrows = mysqli_num_rows($check);

    if ($numrows == 1) {
        return 1;
    } else {
        return 2;
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
