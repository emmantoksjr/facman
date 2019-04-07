<?php

include("../../includes/mysqli_connect.php");

$data = json_decode(file_get_contents('php://input'));
$access_key = $data->{'access_code'};
if (isset($access_key)) {
    $verify = auth($access_key);
    if ($verify == 1) {
        insert_request();
    } else {
        echo generateJSON('error', 320, "Authentication Failed.", null);
    }
} else {
    echo generateJSON('error', 502, "Access Token Required.", null);
}

function insert_request() {
    $data = json_decode(file_get_contents('php://input'));
    global $dbcon;
    $request_method = $_SERVER["REQUEST_METHOD"];
    if ($request_method == 'POST') {
        $errors = array();
        if (empty($data->{'request_id'})) {
            $errors['request_id'] = "Request ID is required";
        } else {
            $request_id = $data->{"request_id"};
        }
        if (empty($data->{"company_id"})) {
            $errors['company_id'] = "company iD is required";
        } else {
            $company_id = $data->{"company_id"};
        }
        if (empty($data->{"facilitator_id"})) {
            $facilitator_idErr = "Facilitator ID is required";
        } else {
            $facilitator_id = $data->{"facilitator_id"};
        }
        if (empty($data->{"property_id"})) {
            $errors['property_id'] = "Property ID is required";
        } else {
            $property_id = $data->{"property_id"};
        }
        if (empty($data->{"contractor_id"})) {
            $errors['contractor_id'] = "Contractor ID is required";
        } else {
            $contractor_id = $data->{"contractor_id"};
        }
        if (empty($data->{"picture"})) {
            $errors['picture'] = "Picture Part is required";
        } else {
            $picture = $data->{"picture"};
        }
       
        if (empty($errors)) {
            $funds = array();
            $funds = $data->{'funds'};
            foreach ($funds as $values) {
                $name = $values->{'name'};
                $quantity = $values->{'quantity'};
                $amount = $values->{'amount'};
                $query = "INSERT INTO fund_details (`id`,`request_id`,`name`,`quantity`,`amount`,`company_id`,`facilitator_id`,`property_id`,`contractor_id`,`date`)"
                        . "VALUES ('','$request_id','$name','$quantity','$amount','$company_id','$facilitator_id','$property_id','$contractor_id',now())";
                $query2 = "INSERT INTO fund_pic (`id`,`request_id`,`picture`)"
                        . "VALUES('','$request_id','$picture')";
                $insert2 = mysqli_query($dbcon, $query2);
                $insert = mysqli_query($dbcon, $query);
            }
            if ($insert && $insert2) {
                $responses = "Fund Request Added Successfully.";
                $response = generateJSON('success', 200, null, $responses);
                echo $response;
            } else {
                $responses = "Fund Request Failed.";
                $response = generateJSON('error', 500, $responses, null);
                echo $response;
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
