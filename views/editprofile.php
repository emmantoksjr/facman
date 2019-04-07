<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: ../index.php");
    exit();
}
$id = $_SESSION['company_id'];
$q_edit = "SELECT * FROM company_profile where `id`='$id'";
require_once '../includes/mysqli_connect.php';
$check = mysqli_query($dbcon, $q_edit);
while($row = mysqli_fetch_assoc($check)){
    $company_name = $row['company_name'];
    $email = $row['email'];
    $location = $row['location'];
    $cphone = $row['phone'];
    
}
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dashboard</title>
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

        <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <link href="../js/bootstrap.min.js" />

        <link rel="stylesheet"  href="../css/style.css" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>


    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="dashboard.php">Logo</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">


                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Facilty Manager
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="addfacility.php">Add Facility Manager</a></li>
                                <li><a href="facilitymanager.php">Facility Managers</a></li>
                            </ul></li>
                        <li><a href="#"><span class="glyphicon glyphicon-bell"></span> Notifications</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                                <li><a href="../includes/sign_out.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="add-property" class="container">
            <div class="well">
                <?php 
                    $c_id = $_SESSION['company_id'];
                ?>
                <form method="POST" action="../includes/functions.php?id=<?php echo $c_id?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="pwd">Company Name</label>
                        <input type="text" name='company_name' value="<?php echo $company_name?>" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Company Address</label>
                        <input type="text" name='location'value="<?php echo $location?>" class="form-control" id="address">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Email Address</label>
                        <input type="email" name="email" value="<?php echo $email?>" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Select image</label>
                        <input type="file" name='file' class="form-control" id="image">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Phone number</label>
                        <input type="text" name="phone" value="<?php echo $cphone ?>"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="11" class="form-control" id="phone">
                    </div>
                    <div class="form-group">
                        <button name='edit' class="btn btn-primary btn-block">Edit Profile</button>
                        <!--<a href="" role="button" name='edit' class="btn btn-primary btn-block">Edit Profile</a>-->
                    </div>
                </form>
            </div>
        </div>
        <footer>
            <h5 class="text-center"> Powered by <a href="raoatech.com">Raoatech Electromech Limited</a></h5>
        </footer>

        <script src="../lib/jquery/jquery.min.js"></script>
    </body>

</html>