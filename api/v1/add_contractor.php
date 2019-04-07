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
                insert_contractor();
            } else {
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

function insert_contractor() {
    $data = json_decode(file_get_contents('php://input'));  
    global $dbcon;
    $request_method = $_SERVER["REQUEST_METHOD"];
    if ($request_method == 'POST') {
        $nameErr = $emailErr = $phoneErr = $locationErr = $propErr = $bankErr = $acctnameErr = $acctnumErr = $proffErr = $picErr = '';
        $errors = array();
        if (empty($data->{'first_name'}) || empty($data->{'last_name'})) {
            $nameErr = "Name is required";
            array_push($errors, $nameErr);
        } else {
            $first_name = test_input(strtoupper($data->{"first_name"}));
            $last_name = test_input(strtoupper($data->{"last_name"}));
        }
        if (empty($data->{"phone"})) {
            $phoneErr = "Phone number is required";
            array_push($errors, $phoneErr);
        } else {
            $phone = test_input($data->{"phone"});
        }
        if (empty($data->{"property_id"})) {
            $propErr = "Property is required";
            array_push($errors, $propErr);
        } else {
            $property_id = test_input($data->{"property_id"});
        }
        if (empty($data->{"bank_name"})) {
            $bankErr = "Bank name is required";
            array_push($errors, $bankErr);
        } else {
            $bank_name = test_input($data->{"bank_name"});
        }
        if (empty($data->{"account_name"})) {
            $acctnameErr = "Account name is required";
            array_push($errors, $acctnameErr);
        } else {
            $account_name = test_input($data->{"account_name"});
        }
        if (empty($data->{"account_number"})) {
            $acctnumErr = "Account Number is required";
            array_push($errors, $acctnumErr);
        } else {
            $account_number = test_input($data->{"account_number"});
        }
        if (empty($data->{"profession"})) {
            $proffErr = "Contactor profession is required";
            array_push($errors, $proffErr);
        } else {
            $profession = test_input($data->{"profession"});
        }
        if (empty($data->{"picture"})) {
            $picErr = "Picture Part is Required.";
            array_push($errors, $picErr);
        } else {
            $picture = $data->{"picture"};
        }
        if (empty($errors)) {
            $q2 = "Select id FROM contractors WHERE phone='$phone' AND account_number = '$account_number'";
            $check = mysqli_query($dbcon, $q2);
            $num = mysqli_num_rows($check);
            if ($num == 1) {
                $responses = "Contractor Already Exist.";
                $response = generateJSON('error', 400, $responses, null);
                echo $response;
            } else {
                $query = "INSERT INTO contractors (`id`,`first_name`,`last_name`,`property_id`,`phone`,`bank_name`,`account_name`,`account_number`,`profession`,`picture`)"
                        . "VALUES ('','$first_name','$last_name','$property_id','$phone','$bank_name','$account_name','$account_number','$profession','$picture')";
                if (mysqli_query($dbcon, $query)) {
                    $responses = "Contractor Added Successfully.";
                    $response = generateJSON('success', 200, null, $responses);
                    echo $response;
                } else {
                    $responses = "Contractor Addition Failed.";
                    $response = generateJSON('error', 500, $responses, null);
                    echo $response;
                }
            }
        } else {
            $responses = "All fields were not properly field.";
            $response = generateJSON('error', 500, $responses, null);
            echo $response;
        }
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

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
