<?php 
include("../../includes/mysqli_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];
if($request_method == 'POST'){ 
    $data = json_decode(file_get_contents('php://input'));  
    global $dbcon;   
    $email = $data->{'email'};
    $password = $data->{'password'};
    $password = md5($password);
    if (!empty($email && $password)) {
        $q = "SELECT id, company_id, CONCAT (first_name,' ',last_name) AS name, phone, email FROM facilitators WHERE (email='$email' AND password='$password')";
        $result = mysqli_query($dbcon, $q);
        if (@mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
            $response = $row;
            }
            $name = $response['name'];
            $id = $response['id'];
            $response['access_code'] = secret_gen($name);
            $secret_key = secret_gen($name);
            $q2 = "UPDATE facilitators SET secret_key = '$secret_key'WHERE id = '$id'";
            if(mysqli_query($dbcon,$q2)){
                 echo generateJSON('success', 200, null,$response);
            }else{
                $responses = 'Error generating Client secret.';
                $response  =  generateJSON('error', 500,$responses, null);
                 echo $response;
            }
        }
        else{
            $responses = 'Wrong Login Credentials.';
        $response  =  generateJSON('error', 500,$responses, null);
        echo $response;
        }
        mysqli_close($dbcon);
    }else{
        $responses = 'Insert Name and Password to Login';
        $response  =  generateJSON('error', 500,$responses, null);
        echo $response;
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
function secret_gen($last_name) {
    $client_secret = md5($last_name);
    return $client_secret;
}
