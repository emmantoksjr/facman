<?php
include("../../includes/mysqli_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input')); 
            $access_key = $data->{'access_code'};
        if (isset($access_key)) {
            $verify = auth($access_key);
            if ($verify == 1) {
            insert_milestone();
            
            }else{
                echo generateJSON('error', 500, "Authentication Failed.", null);
            }
        } else {
            echo generateJSON('error', 502, "Access Token Required.", null);
        }

        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        echo generateJSON('error', 500, "Request Method Not Allowed.", null);
        break;
}
function insert_milestone() {
    global $dbcon;
    $data = json_decode(file_get_contents('php://input')); 
    $propErr = $descErr = $picErr = '';
    $errors = array();
    if (empty($data->{'property_id'})) {
        $propErr = "Property ID is required";
        array_push($errors, $propErr);
    } else {
        $property_id = $data->{"property_id"};
    }
    if (empty($data->{'description'})) {
        $descErr = "Milestone Description is required";
        array_push($errors, $descErr);
    } else {
        $description = $data->{"description"};
    }
    if (empty($data->{'picture'})) {
        $picErr = "Picture is required";
        array_push($errors, $picErr);
    } else {
        $picture = $data->{"picture"};
    }

    if (empty($errors)) {
        $query = "INSERT INTO milestones (`id`,`property_id`,`description`,`picture`,`date`)"
                . "VALUES ('','$property_id','$description','$picture',now())";
        if (mysqli_query($dbcon, $query)) {
            $responses = "Milestone Added Successfully.";
            $response = generateJSON('success', 200, null, $responses);
            echo $response;
        } else {
            $responses = "Milestone Addition Failed.";
            $response = generateJSON('error', 500, $responses, null);
            echo $response;
        }
    } else {
        $responses = "All fields were not properly field.";
        $response = generateJSON('error', 500, $responses, null);
        echo $response;
    }
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
