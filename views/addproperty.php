<?php
session_start();
if (!isset($_SESSION['company_id']))
{ header("Location: ../index.php");
exit();
}
include '../includes/functions.php';
?>
<html>
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Dashboard</title>
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
                <a class="navbar-brand" href="dashboard.html">FacMan</a>
                </div>
            </div>
        </nav>

        <div id="add-property" class="container">
            <div class="well text-center">
                <h4 class="text-center">
                    <span class="back">
                        <a href="../views/dashboard.php" role="button" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                </span>Add property</h4>
            </div>
            <div class="well">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                            <label for="title">Title <b style="color: red">*</b></label>
                            <!-- <input type="email" class="form-control" id="email"> -->
                            <select name="title">
                               <?php select_title();?> 
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="pwd">First Name <b style="color: red">*</b></label>
                        <input type="text"
                               value="<?php if(isset($first_name))echo $first_name; ?>"name="first_name" required="required" class="form-control" id="fname">
                        <small style="color: red"><?php if(isset($errors['first_name']))echo $errors['first_name']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Last Name <b style="color: red">*</b></label>
                        <input type="text"
                               value="<?php if(isset($last_name))echo $last_name; ?>"name="last_name" required="required" class="form-control" id="lname">
                        <small style="color: red"><?php if(isset($errors['last_name']))echo $errors['last_name']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Email Address</label>
                        <input type="email"
                               value="<?php if(isset($email))echo $email; ?>"name="email" required="required" class="form-control" id="email">
                        <small style="color: red"><?php if(isset($errors['email']))echo $errors['email']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Phone number <b style="color: red">*</b></label>
                        <input type="number"
                               value="<?php if(isset($phone))echo $phone; ?>"name="phone" maxlength="11" class="form-control" id="phone">
                        <small style="color: red"><?php if(isset($errors['phone']))echo $errors['phone']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="pwd">location <b style="color: red">*</b></label>
                        <input type="text"
                               value="<?php if(isset($location))echo $location; ?>"name="location" required="required" class="form-control" id="phone">
                        <small style="color: red"><?php if(isset($errors['location']))echo $errors['location']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Year of building <b style="color: red">*</b></label>
                        <input type="number"
                               value="<?php if(isset($building_year))echo $building_year; ?>"name="building_year"required="required" class="form-control" id="year">
                        <small style="color: red"><?php if(isset($errors['building_year']))echo $errors['building_year']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="email">Type of building <b style="color: red">*</b></label>
                        <!-- <input type="email" class="form-control" id="email"> -->
                        <select name="type" value="<?php if(isset($type))echo $type; ?>">
                           <?php select_type(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Service <b style="color: red">*</b></label>
                        <textarea type="text"
                                  value="<?php if(isset($service))echo $service; ?>"name="service" required="required" class="form-control" id="service"></textarea>
                                  <small style="color: red"><?php if(isset($errors['service']))echo $errors['service']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Facility Manager<b style="color: red">*</b></label>
                        <select name="facilitator" value="<?php if(isset($facilitator))echo $facilitator; ?>">
                            <?php select_facilitator();?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="add_property" class="btn btn-primary btn-block">Add Property</button>                                   
                        <!--<a href="" role="button" class="btn btn-primary btn-block">Add property</a>-->
                    </div>
            </form>
            </div>
        </div>
<script src="../lib/jquery/jquery.min.js"></script>
<script src="../js/sweetalert.min.js"></script>
</body>
</html>