<?php
include("../../includes/mysqli_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'));
        $email = $data->{'email'};
        $password = $data->{'password'};
        if (isset($email) && isset($password)) {
                update_password();
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


function update_password() {
    global $dbcon;
         $data = json_decode(file_get_contents('php://input'));
         $password = $data->{'password'};
         $password = md5($password);
         $email = $data->{'email'};
         $update = "UPDATE facilitators SET password = '$password' WHERE email = '$email'";
         if (mysqli_query($dbcon, $update)) {
            $responses = "Facilitator Password Changed Successful";
            $response = generateJSON('success', 200, null, $responses);
            echo $response;
        } else {
            $responses = "Error changing password!!";
            $response = generateJSON('error', 500, $responses, null);
            echo $response;
        }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
