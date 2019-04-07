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
                    get_milestone($id);
                } else {
                    echo generateJSON('error', 500, "A Property ID is required.", null);
                }
            } else {
                echo generateJSON('error', 500, "Authentication Failed.", null);
            }
        } else {
            echo generateJSON('error', 502, "Access Token Required.", null);
        }

        break;
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

function get_milestone($id) {
    $property_id = $id;
    global $dbcon;
    $query = "SELECT * FROM milestones WHERE property_id = '$property_id'";
    $response = array();
    $result = mysqli_query($dbcon, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = $row;
    }
    header('Content-Type: application/json');
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

function insert_milestone() {
    global $dbcon;
//    $data = $_POST;
    $propErr = $descErr = $picErr = '';
    $errors = array();
    if (empty($data['property_id'])) {
        $propErr = "Property ID is required";
        array_push($errors, $propErr);
    } else {
        $property_id = $data["property_id"];
    }
    if (empty($data['description'])) {
        $descErr = "Milestone Description is required";
        array_push($errors, $descErr);
    } else {
        $description = $data["description"];
    }
    if (empty($data['picture'])) {
        $picErr = "Picture is required";
        array_push($errors, $picErr);
    } else {
        $picture = $data["picture"];
    }

    if (empty($errors)) {
        $query = "INSERT INTO milestones (`id`,`property_id`,`description`,`picture`)"
                . "VALUES ('','$property_id','$description','$picture')";
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

