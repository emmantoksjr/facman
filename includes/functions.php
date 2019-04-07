<?php
include 'mysqli_connect.php';
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['forgotpass'])){
    
    $errors = array();
    if(empty($_POST['email'])){
        $errors['email'] = "Email is Required";
    }else{
        $email =$_POST["email"];
    }
    
    if(empty($errors)){
        $q = "SELECT id FROM company_profile WHERE email = '$email'";
        $r = mysqli_query($dbcon, $q);
        $n = mysqli_num_rows($r);
        if($n == 1){
            header("refresh:0; url=changepass.php?email=$email");
        }else{
           $errors['email'] = "The email is not registered"; 
        }
    }else{
        $errors['email'] = "Invalid email Address";
    }
}


if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['up_pass'])){
        $errors = array();
        $email = $_GET['email'];
    if (!empty($_POST['password'])) {
        if (!empty($_POST['c_password'])){
            if ($_POST['password'] != $_POST['c_password']) {
            $errors['c_password'] = 'your password did not match';
        } else {
            $password = test_input($_POST['password']);
            $password = (md5($password));
        }
        }else{
             $errors['password'] = 'you did not enter confirm password.';
        }
        
    } else {
        $errors['password'] = 'you did not enter any password.';
    }
    
    
    if(empty($errors)){
        $update = "UPDATE company_profile SET password = '$password' WHERE email = '$email'";
        if(mysqli_query($dbcon, $update)){
            echo '<script>
                    alert("Password Successfully Updated");
                    </script>';
            header("refresh:0; url=index.php");
        }else{
          echo '<script>
                    alert("Password Successfully Updated");
                    </script>';
            header("refresh:0; url=index.php");
        }
    }else{
        $errors['password'] = "Password Error";
    }
    
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['respond'])) {
//    die(var_dump($_POST));
    $errors = array();
    if(empty($_POST['r_id'])){
        $errors['r_id'] = "R_ID is needed";
    }else{
        $r_id = test_input($_POST["r_id"]);
    }
    if (empty($_POST['optradio'])) {
        $errors['optradio'] = "Accept or Reject Fund is required";
    } else {
        $opt = $_POST["optradio"];
    }
    if (empty($_POST['comment'])) {
        $errors['comment'] = "Comment is required";
    } else {
        $comment = $_POST["comment"];
    }

    if (empty($errors)) {
        require'../includes/mysqli_connect.php';
        $insert = "INSERT INTO fund_reply (id,request_id,response_id,comment)"
                . "VALUES ('',$r_id,'$opt','$comment')";
        $update = "UPDATE fund_details SET treated = '1' WHERE request_id = $r_id";
        mysqli_query($dbcon, $update);
            
            $subject = 'FUND RESPONSE';
            
            $c_q ="SELECT fd.request_id, fd.facilitator_id,fd.company_id, CONCAT(c.first_name,' ',c.last_name) AS name,"
                    . " fr.comment, r.response FROM fund_details fd JOIN contractors c "
                    . "on fd.contractor_id = c.id JOIN fund_reply fr on fd.request_id = fr.request_id "
                    . "JOIN response r on fr.response_id = r.id WHERE fd.request_id = $r_id" ;
            $c_m = mysqli_query($dbcon, $c_q);
//            
            $c_b = mysqli_fetch_assoc($c_m);
            $comment = $c_b['comment'];
            $response = $c_b['response'];
            $re_id = $c_b['request_id'];
            $r_name = $c_b['name'];
            $facilitator_id = $c_b['facilitator_id'];
            $company_id = $c_b['company_id'];
            
            $em_q = "SELECT email FROM facilitators WHERE id='$facilitator_id' AND company_id='$company_id'";
            $em_w = mysqli_query($dbcon, $em_q);
            $em_e = mysqli_fetch_assoc($em_w);
            $to = $em_e['email'];
            
            $em_q1 = "SELECT email FROM company_profile WHERE id='$company_id'";
            $em_w1 = mysqli_query($dbcon, $em_q1);
            $em_e1 = mysqli_fetch_assoc($em_w1);
            $company_email = $em_e1['email'];
            
            
// Message
            $message = "<html>
<head>
  <title>FUND RESPONSE</title>
</head>
<body>
  <p>The request with ID $re_id for contractor $r_name has been $response with comment below:<br/>
      $comment
     </p>
  
</body>
</html>
";
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "To:$to";
            $headers[] = "From:$company_email";
           mail($to, $subject, $message, implode("\r\n", $headers));
        
        
        if (mysqli_query($dbcon, $insert)) {
            echo '<script>
                    alert("Response has been set. An email has been sent to the facility manager!!.");
                    </script>';
            header("refresh:0; url=dashboard.php");
        } else {
            echo '<script>
                    alert("Error Updating response!!");
                    </script>';
            header("refresh:0; url=dashboard.php");
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
    require ('mysqli_connect.php');
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
    if (!empty($email && $password)) {
        $q = "SELECT id AS company_id, company_name, email, phone,location,rc_num,logo FROM company_profile WHERE (email='$email' AND password='$password')";
        $result = mysqli_query($dbcon, $q);
        if (@mysqli_num_rows($result) == 1) {
            session_start();
            $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
            header('Location: ./views/dashboard.php');
            exit();
            mysqli_free_result($result);
            mysqli_close($dbcon);
        }
        else{
            echo '<script>alert("Wrong Login credentials");</script>';
        }
        mysqli_close($dbcon);
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {
    $errors = array();

    if (empty($_POST['company_name'])) {
        $errors['company_name'] = "Company Name is required";       
    } else {
        $company_name = test_input($_POST["company_name"]);
    }

    if (empty($_POST["email"])) {
        $errors['email'] = "Email is required";
    } else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        } else {
            $email = test_input($_POST["email"]);
        }
    }
    if (empty($_POST["phone"])) {
        $errors['phone'] = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
    }

    if (!empty($_POST['password'])) {
        if (!empty($_POST['confirm_password'])){
            if ($_POST['password'] != $_POST['confirm_password']) {
            $errors['confirm_password'] = 'your password did not match';
        } else {
            $password = test_input($_POST['password']);
            $password = (md5($password));
        }
        }else{
             $errors['password'] = 'you did not enter confirm password.';
        }
        
    } else {
        $errors['password'] = 'you did not enter any password.';
    }

    if (empty($_POST["location"])) {
        $errors['location'] = "Location of the company is required";
    } else {
        $location = test_input($_POST["location"]);
    }
    if (empty($_POST["rc_num"])) {
        $errors['rc_num'] = "RC number of the company is required";
    } else {
        $rc_num = $_POST['rc_num'];
    }
    
    
    if (empty($errors)) {
        include 'mysqli_connect.php';
        $check = "SELECT id FROM company_profile WHERE email = '$email'";
        $r_check = "SELECT id FROM company_profile WHERE rc_num = '$rc_num'";  

        $q = " INSERT INTO company_profile( `id`, `company_name`, `email`, `password`, `phone`, `location`, `rc_num`,`date`)
              VALUES ('', '$company_name','$email','$password','$phone', '$location', '$rc_num',now());";
          $check1 = mysqli_query($dbcon, $check);
          $r_check1= mysqli_query($dbcon, $r_check);
          $numrows = mysqli_num_rows($check1);
          $r_numrows = mysqli_num_rows($r_check1);
           if ($numrows == 0) {
           if($r_numrows > 0){
        echo '<script>
                    alert("RC number already Registered!!. Kindly Correct to Continue");
                    </script>';
//        header("refresh:0; url=./index.php");

}  else {
        $result = mysqli_query($dbcon, $q);
        if ($result) {
            echo '<script>
                    alert("Congratulations! Your company has been registered successfully");
                    </script>';
            header("refresh:0; url=./index.php");
            exit;
        }else{
            echo '<script>
                    alert("Error adding data to the database");
                    </script>';
        }
    }  
    } else{
        echo '<script>
                    alert("Company already Registered!!. Kindly Login to continue");
                    </script>';
//        header("refresh:0; url=./index.php");
    }
    } else {
        echo "<script>alert('All mandatory Field were not properly Filled!!. ');</script>";
        }
    mysqli_close($dbcon);
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add_property'])) {
    if (empty($_POST['first_name'])) {
        $errors['first_name'] = "First Name is required";
    } else {
        $first_name = test_input(strtoupper($_POST["first_name"]));
    }
    if (empty($_POST['last_name'])) {
        $errors['last_name'] = "Last Name is required";
    } else {
        $last_name = test_input(strtoupper($_POST["last_name"]));
    }

    if (empty($_POST["email"])) {
        $errors['email'] = "Email is required";
    } else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        } else {
            $email = test_input($_POST["email"]);
        }
    }
    if (empty($_POST["phone"])) {
        $errors['phone'] = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
    }
    if (empty($_POST["location"])) {
        $errors['location'] = "Property location is required";
    } else {
        $location = test_input($_POST["location"]);
    }
    $building_year = $_POST['building_year'];
    $type = $_POST['type'];
    $service = $_POST['service'];
    $facilitator = $_POST['facilitator'];
    $title = $_POST['title'];
    if (empty($errors)) {
        require'mysqli_connect.php';
        $property_id = property_gen($last_name);
        $company_id = $_SESSION['company_id'];
        $q = "
            INSERT INTO properties(`id`,`property_id`,`facilitator_id`,`company_id`)
            values ('','$property_id','$facilitator','$company_id')";

        $q2 = "INSERT INTO property_details(`id`,`property_id`,`title`,`first_name`,`last_name`,`email`,`phone`,`location`,`building_year`,
            `type_id`,`service`,`date`)
            VALUES('','$property_id','$title','$first_name','$last_name', '$email', '$phone','$location','$building_year','$type','$service',now())";
        $result = mysqli_query($dbcon, $q);
        $result2 = mysqli_query($dbcon, $q2);
        if ($result && $result2) {
$em_q = "SElECT email FROM facilitators WHERE id='$facilitator' AND company_id= '$company_id'";
            $em_c = mysqli_query($dbcon, $em_q);
            $em_r = mysqli_fetch_assoc($em_c);
            $f_em = $em_r['email'];
            $company_email = $_SESSION['email'];
            $to = $f_em;
            $subject = 'PROPERTY ASSIGNMENT';

// Message
            $message = '<html>
<head>
  <title>PROPERTY ASSIGNMENT</title>
</head>
<body>
  <p>A property has been assigned to you.<br />
  Please kindly check the mobile app for more details</p>
  
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
            $headers[] = "To:$to";
            $headers[] = "From:$company_email";
// Mail it
            mail($to, $subject, $message, implode("\r\n", $headers));
            
                    echo'<script>
                    alert("Congratulations! Property has been added successfully and a notification has been sent to the facility manager");
                    </script>';
            header("refresh:0; url=addproperty.php");
            exit;
        } else {
            echo '
                alert("All Mandatory fields were not properly filled!!");';
        }
    }
    mysqli_close($dbcon);
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add_facility'])) {
    $errors = array();
    if (empty($_POST['first_name'])) {
        $errors['first_name'] = "First Name is required";
    } else {
        $first_name = test_input(strtoupper($_POST["first_name"]));
    }
    if (empty($_POST['last_name'])) {
        $errors['last_name'] = "Last Name is required";
    } else {
        $last_name = test_input(strtoupper($_POST["last_name"]));
    }

    if (empty($_POST["email"])) {
        $errors['email'] = "Email is required";
    } else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        } else {
            $email = test_input($_POST["email"]);
        }
    }
    if (empty($_POST["phone"])) {
        $errors['phone'] = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
    }
    if (empty($_POST["password"])) {
        $errors['password'] = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        $password = (md5($password));
    }
    $company_id = $_SESSION['company_id'];
    if (empty($errors)) {
        require'mysqli_connect.php';
        $q = "INSERT INTO facilitators(`id`,`company_id`,`first_name`,`last_name`,`email`,`phone`,`password`,`date`)
            VALUES ('','$company_id','$first_name','$last_name','$email','$phone','$password',now())";
        $result = mysqli_query($dbcon, $q);
        if ($result) {
            echo'<script>
                    alert("Congratulations! Facility Manager has been added successfully");
                   </script>';
            header("refresh:0; url=addfacility.php");
            exit;
        } else {
            echo '<script>
                alert("System Error!! kindly try again");</script>';
        }
    }
    mysqli_close($dbcon);
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit'])) {
    $company_nameErr = $emailErr = $locationErr = $phoneErr = $logoErr = '';
    $errors = array();
    $id = $_GET['id'];
    if (empty($_POST['company_name'])) {
        $company_nameErr = "Company Name is required";
        array_push($errors, $company_nameErr);
    } else {
        $company_name = test_input($_POST["company_name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        array_push($errors, $emailErr);
    } else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = 'Invalid email format';
            array_push($errors, $emailErr);
        } else {
            $email = test_input($_POST["email"]);
        }
    }
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
        array_push($errors, $phoneErr);
    } else {
        $phone = test_input($_POST["phone"]);
    }

    if (empty($_POST["location"])) {
        $locationErr = "Location of the company is required";
        array_push($errors, $locationErr);
    } else {
        $location = test_input($_POST["location"]);
    }
    
    if (empty($errors)) {
        require'mysqli_connect.php';
       $file = $_FILES['file']["name"];
        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES['file']['name']);
        // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Valid file extensions
         $extensions_arr = array("jpg","jpeg","png","gif");
          if( in_array($imageFileType,$extensions_arr) ){
            $query = "UPDATE company_profile SET logo = '$file' WHERE id=$id";
          mysqli_query($dbcon,$query);
          move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$file);
 }

        $q = "UPDATE company_profile SET company_name = '$company_name', email = '$email', phone = '$phone', location = '$location' WHERE id = '$id'";
        if (mysqli_query($dbcon, $q)) {
        echo '<script>
                    alert("Company Details Updated Successfully!!.");
                    </script>';
        header("refresh:0; url=../views/profile.php");
    } else {
        echo '<script>
                    alert("Error Updating Company details!!");
                    </script>';
    }
    } else {
        echo '<script>
          alert("Error Updating Company details!!");
         </script>';
    }
    
    mysqli_close($dbcon);
}
function strip_name($last_name) {
    strtoupper($last_name);
    $newArray = str_split($last_name, 3);
    $acronym = $newArray[0];
    return $acronym;
}
function property_gen($last_name) {
    strtoupper($last_name);
    $property_id = strip_name($last_name) . gen_num();
    return $property_id;
}
function gen_num() {
    $number = mt_rand(001, 9999);

    if ($number < 100) {
        $number = str_pad($number, 2, '0');
    }
    return $number;
}
function select_title() {
    require('mysqli_connect.php');
    $query = "SELECT * FROM title";
    $titles = mysqli_query($dbcon, $query);
    while ($row = mysqli_fetch_assoc($titles)) {
        $id = $row['id'];
        $title = $row['title'];
        echo "<option value='$id'>$title</option>";
    }
}
function select_facilitator() {

    require('mysqli_connect.php');
$company_id = $_SESSION['company_id'];
    $query = "SELECT id, CONCAT(first_name,' ',last_name) AS name FROM facilitators WHERE company_id = '$company_id'";

    $facilitators = mysqli_query($dbcon, $query);
    while ($row = mysqli_fetch_assoc($facilitators)) {
        $id = $row['id'];
        $name = $row['name'];
        echo "<option value='$id'>$name</option>";
    }
}
function select_type() {

    require('mysqli_connect.php');

    $gender = "SELECT * FROM building_type";

    $building_type = mysqli_query($dbcon, $gender);
    while ($row = mysqli_fetch_assoc($building_type)) {
        $id = $row['id'];
        $type = $row['type'];
        echo "<option value='$id'>$type</option>";
    }
}

