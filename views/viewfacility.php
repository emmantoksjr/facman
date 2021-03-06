<?php
$id = $_GET['id'];
include '../includes/mysqli_connect.php';
$q = "SELECT first_name,last_name,phone,email FROM facilitators WHERE id = '$id'";
$result = mysqli_query($dbcon, $q);
while ($row = mysqli_fetch_assoc($result)) {
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $phone = $row['phone'];
}
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Contractor</title>
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
                    <a class="navbar-brand" href="dashboard.php">FacMan</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li> 
                            
                        </li>
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
            <div class="panel panel-default">
                <div class="panel-heading">Contractor Details</div>
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">First Name</h4>
                            <p class="list-group-item-text"><?php echo $first_name ?></p>
                        </a>
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Last Name</h4>
                            <p class="list-group-item-text"><?php echo $last_name ?></p>

                            <a href="#" class="list-group-item">
                                <h4 class="list-group-item-heading">Email</h4>
                                <p class="list-group-item-text"><?php echo $email ?></p>
                            </a>
                            <a href="#" class="list-group-item">
                                <h4 class="list-group-item-heading">Phone Number</h4>
                                <p class="list-group-item-text"><?php echo $phone; ?></p>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../lib/jquery/jquery.min.js"></script>
</body>

</html>