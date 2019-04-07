<?php
include './includes/functions.php';
?> 
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Facility Management Application</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Monitor and manage workdone on a construction project" />
        <meta name="keywords" content="construction, building, management, facility, manager" />
        <meta name="author" content="" />
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

        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <style type="text/css">
            .errorText {color: red;}
        </style>
        <link href="js/bootstrap.min.js" />

        <link rel="stylesheet"  href="css/style.css" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="lib/jquery/jquery.min.js"></script>
        <script src="js/sweetalert.min.js"></script>
        <!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
    </head>
    <body>
        <section id="welcome">

            <div class="welcome-container">

                <div class="row">

                    <div class="action-text col-md-6">

                        <h1>Welcome to Facility Manager App</h1>
                        <p class="word">Facility Manager is construction management tool that helps monitor and track construction works or projects been handled by a particular Facility Manager</p>

                    </div>

                    <div id="action" class="col-md-6">
                        <ul class="nav nav-pills nav-justified">

                            <li class="active">
                                <a data-toggle="pill" href="#login">Sign In</a> 
                            </li>

                            <li>
                                <a data-toggle="pill" href="#register">Register</a>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <div id="login" class="tab-pane fade in active">
                                <h5>Provide Login details</h5>
                                <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="ema" type="email" required="required" class="form-control" name="email" placeholder="Email">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="pswd" type="password" required="required" class="form-control" name="password" placeholder="Password">
                                    </div>

                                    <div>
                                        <!--<button ri></button>-->
                                        <button type="submit" name="login" class="btn btn-default btn-block">Log In</button>
                                        <!--<a role="button" href="./views/dashboard.html"  type="submit" class="btn btn-default btn-block">Submit</a>-->
                                    </div>

                                    <a class="pass" href="forgotpass.php">Forgot password?</a>

                                </form>
                            </div>
                            <div id="register" class="tab-pane fade">
                                <h6>Provide Sign up details</h6>
                                <form method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-group">
                                        <label for="name">Company Name</label><span class="errorText">*</span>
                                        <input type="text" name="company_name" required="required"
                                               value="<?php if (isset($company_name)) echo $company_name; ?>" class="form-control" id="name">
                                        <small class="errorText"><?php if (isset($errors['company_name'])) echo $errors['company_name']; ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Address:</label><span class="errorText">*</span>
                                        <input type="email" required="required"value="<?php if (isset($email)) echo $email; ?>" name="email" class="form-control" id="email">
                                        <span id="email_val" style="color:red"></span>
                                        <small class="errorText"><?php if (isset($errors['email'])) echo $errors['email']; ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="pwd">Password:</label><span class="errorText">*</span>
                                        <input type="password" required="required"name="password" class="form-control" id="pass">
                                        <small class="errorText"><?php if (isset($errors['password'])) echo $errors['password']; ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="pwd">Confirm Password:</label><span class="errorText">*</span>
                                        <input type="password"required="required" name="confirm_password" class="form-control" 
                                               id="c_pass">
                                        <span id="pass_val" style="color:red"></span>
                                        <small class="errorText"><?php if (isset($errors['confirm_password'])) echo $errors['confirm_password']; ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone:</label><span class="errorText">*</span>
                                        <input type="number" required="required" name="phone"
                                               value="<?php if (isset($phone)) echo $phone; ?>" maxlength="11" class="form-control" id="phone">
                                        <small class="errorText"><?php if (isset($errors['phone'])) echo $errors['phone']; ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="location">Location:</label><span class="errorText">*</span>
                                        <input type="text"required="required" name="location"
                                               value="<?php if (isset($location)) echo $location; ?>"class="form-control" id="location">
                                        <small class="errorText"><?php if (isset($errors['location'])) echo $errors['location']; ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="rc">RC Number:</label><span class="errorText">*</span>
                                        <input type="text" required="required" value="<?php if (isset($rc_num)) echo $rc_num; ?>"name="rc_num" class="form-control" id="rc_num">
                                        <span id="rc_val" style="color:red"></span>
                                        <small class="errorText"><?php if (isset($errors['rc_num'])) echo $errors['rc_num']; ?></small>
                                    </div>
                                    <button type="submit" name="register" class="btn btn-default btn-block">Register</button>
                                    <!--<a role="button" name="register"  type="submit" class="btn btn-default btn-block">Register</a>-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
                jQuery(function ($) {
                $("#email").keyup(function () { 
                    var email = $("#email").val();
                    var datastring ='email=' + email; 
                    $.ajax({
                        type: "POST", // type
                        url: "includes/check_email.php", // request file the 'check_email.php'
                        data: datastring, // post the data
                        success: function (responseText) { 
                            if (responseText == 1) {
                                $("#email_val").html(" Email already exist.");
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
                $("#rc_num").keyup(function () { 
                    var rc_num = $("#rc_num").val();
                    var datastring ='rc_num=' + rc_num; 
                    $.ajax({
                        type: "POST", // type
                        url: "includes/check_rc.php", // request file the 'check_email.php'
                        data: datastring, // post the data
                        success: function (responseText) { 
                            if (responseText == 1) {
                                $("#rc_val").html(" RC number already exist.");
                            } else {
                                $("#rc_val").html("");
                            }
                        } // end success
                    }); // ajax end
                    /************** end: email exist function and etc. **************/
                }); // click end
            }); // jquery end
        </script>
        <script>
                jQuery(function ($) {
                $("#c_pass").keyup(function () { 
                    var pass = $("#pass").val();
                    var c_pass = $("#c_pass").val();
                    
                    if(pass == c_pass){
                        $("#pass_val").html("");
                    }else{
                        $("#pass_val").html("Passwords do not match");
                    }
                    
                }); // click end
            }); // jquery end
        </script>
        
    </body>
</html>