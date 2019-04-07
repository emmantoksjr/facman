<?php
session_start();
if (!isset($_SESSION['company_id']))
{ header("Location: ../index.php");
exit();
}include '../includes/functions.php';
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Add Facility Manager</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Monitor and manage workdone on a construction project" />
        <meta name="keywords" content="construction, building, management, facility, manager" />
        <meta name="author" content="" />

        <!-- Facebook and Twitter integration -->
        <meta property="og:title" content=""/>
        <meta property="og:image" content=""/>
        <meta property="og:url" content=""/>
        <meta property="og:site_name" content=""/>
        <meta property="og:description" content=""/>
        <meta name="twitter:title" content="" />
        <meta name="twitter:image" content="" />
        <meta name="twitter:url" content="" />
        <meta name="twitter:card" content="" />

        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

        <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <link href="../js/bootstrap.min.js" />

        <link rel="stylesheet"  href="../css/style.css" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
         <!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
    </head>
<body>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
            <a class="navbar-brand" href="dashboard.php">FacMan</a>
            </div>
        </div>
    </nav>

    <div id="add-property" class="container">
        <div class="well text-center">
            <h4><span class="back">
                    <a href="../views/facilitymanager.php" role="button" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                </span>Add Facility Manager</h4>
        </div>
        
        <div class="well">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                        <label for="fname">First Name <b style="color: red">*</b></label>
                        <input type="text"required="required"value="<?php if(isset($first_name))echo $first_name; ?>" name="first_name" class="form-control" id="fname">
                        <small style="color: red"><?php if(isset($errors['first_name']))echo $errors['first_name']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name <b style="color: red">*</b></label>
                        <input type="text"required="required"value="<?php if(isset($last_name))echo $last_name; ?>" name="last_name" class="form-control" id="lname">
                        <small style="color: red"><?php if(isset($errors['last_name']))echo $errors['last_name']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address<b style="color: red">*</b></label>
                        <input type="email"required="required" value="<?php if(isset($email))echo $email; ?>" name="email" class="form-control" id="email">
                        <span id="email_val" style="color:red"></span>
                        <small style="color: red"><?php if(isset($errors['email']))echo $errors['email']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number <b style="color: red">*</b></label>
                        <input type="number"required="required" value="<?php if(isset($phone))echo $phone; ?>"  name="phone" class="form-control" id="phone">
                         <span id="phone_val" style="color:red"></span>
                        <small style="color: red"><?php if(isset($errors['phone']))echo $errors['phone']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password<b style="color: red">*</b></label>
                        <input type="password"required="required" value="<?php if(isset($password))echo $password; ?>" name="password" class="form-control" id="password">
                        <small style="color: red"><?php if(isset($errors['password']))echo $errors['password']; ?></small>
                    </div>
                    <div class="form-group">
                         <button type="submit" name="add_facility" class="btn btn-primary btn-block">Add FACILITY MANAGER</button>
                    </div>
            </form>
        </div>
    </div>

<script src="../lib/jquery/jquery.min.js"></script>
<script src="../js/sweetalert.min.js"></script>
<script>
                jQuery(function ($) {
                $("#email").keyup(function () { 
                    var email = $("#email").val();
                    var datastring ='email=' + email; 
                    $.ajax({
                        type: "POST", // type
                        url: "../includes/check_email.php", // request file the 'check_email.php'
                        data: datastring, // post the data
                        success: function (responseText) { 
                            if (responseText == 1) {
                                $("#email_val").html(" Email is already Registered.");
                            } else {
                                $("#email_val").html("");
                            }
                        } // end success
                    }); // ajax end
                    /************** end: email exist function and etc. **************/
                }); // click end
            }); // jquery end
        </script>
<script>
                jQuery(function ($) {
                $("#phone").keyup(function () { 
                    var phone = $("#phone").val();
                    var datastring ='phone=' + phone; 
                    $.ajax({
                        type: "POST", // type
                        url: "../includes/check_phone.php", // request file the 'check_email.php'
                        data: datastring, // post the data
                        success: function (responseText) { 
                            if (responseText == 1) {
                                $("#phone_val").html("Phone number already registered");
                            } else {
                                $("#phone_val").html("");
                            }
                        } // end success
                    }); // ajax end
                    /************** end: email exist function and etc. **************/
                }); // click end
            }); // jquery end
        </script>
</body>

</html>