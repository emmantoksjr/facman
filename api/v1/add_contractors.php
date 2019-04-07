<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }

include("../../includes/mysqli_connect.php");

        $data = json_decode(file_get_contents('php://input')); 
          
            $access_key = $data->{'access_code'};
        if (isset($access_key)) {
            $verify = auth($access_key);
          //var_dump($verify);
            if ($verify == 1) {
                insert_contractor();
            } else {
                  //echo"THis iss";
                echo generateJSON('error', 320, "Authentication Failed.", null);
            }
        } else {
            echo generateJSON('error', 502, "Access Token Required.", null);
        }
       

function insert_contractor() {
    $data = json_decode(file_get_contents('php://input')); 
//var_dump($data); 
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
                $query = "INSERT INTO contractors (`id`,`first_name`,`last_name`,`property_id`,`phone`,`bank_name`,`account_name`,`account_number`,`profession`,`picture`,`date`)"
                        . "VALUES ('','$first_name','$last_name','$property_id','$phone','$bank_name','$account_name','$account_number','$profession','$picture',now())";
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
            $response = generateJSON('error', 504, $responses, null);
            echo $response;
        }
    }
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

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
