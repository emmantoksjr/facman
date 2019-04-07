<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: ../index.php");
    exit();
}

//include '../includes/functions.php';
$company_id = $_SESSION['company_id'];
$q_manager = "SELECT id FROM properties where `company_id`='$company_id'";
$q_facilitators = "SELECT id FROM facilitators where `company_id`='$company_id'";
require_once '../includes/mysqli_connect.php';
$check = mysqli_query($dbcon, $q_manager);
$numrows = mysqli_num_rows($check);
$check2 = mysqli_query($dbcon, $q_facilitators);
$numrows2 = mysqli_num_rows($check2);
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Facility Manager</title>
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

        <div class="container">

            <div class="row">
                <div class="col-sm-2 col-md-3 col-lg-3">
                    <div class="well text-center">
                        <img src="../img/admin.png" class="img-circle" height="80" width="80" alt="Avatar">
                        <h4 class="text-wrap"><?php echo $_SESSION['company_name'] ?></h4>
                        <p><?php echo $_SESSION['location'] ?></p>
                        <!--<p>Lagos state</p>-->
                        <a role="button" href="profile.php" class="btn btn-primary btn-block">View Profile</a>
                    </div>
                    <div class="well">
                        <ul class="list-group">
                            <li class="list-group-item">Facility Manager <span class="badge"><?php echo $numrows2 ?></span></li>
                            <li class="list-group-item">Properties <span class="badge"><?php echo $numrows ?></span></li> 
                        </ul>
                    </div>
                </div>   

                <div class="col-sm-10 col-md-9 col-lg-9 well">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Facility Manager</b>

                            <a href="addfacility.php" style="float: right; margin-bottom: 5px;" role="button" class="btn btn-primary btn-sm">Add Facility Manager</a>

                        </div>      
                    </div>

                    <div class="row">
                        <?php
                        require_once '../includes/mysqli_connect.php';

                        $fetch_facilitators = "SELECT id, CONCAT (first_name, ' ', last_name) AS name, email, phone FROM facilitators WHERE company_id = '$company_id'";
                        $facilitators = mysqli_query($dbcon, $fetch_facilitators);
                        while ($row = mysqli_fetch_assoc($facilitators)) {
                            $id = $row['id'];
                            $fname = $row['name'];
                            $femail = $row['email'];
                            $fphone = $row['phone'];
                            ?>
                            <div class="col-sm-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading"></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <img src="../img/factman.png"  height="50" width="70">
                                            </div>
                                            <div class="col-sm-9">
                                                <!--<input id="f" hidden="" value='<?php echo $id?>'>-->
                                                <p class="text-wrap"><?php echo $fname ?></p>
                                                <p class="text-wrap"><?php echo $femail ?></p>
                                                <p class="text-wrap"> <?php echo $fphone ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <!--<button class="btn btn-default btn-block">View Facility Manager</button>-->
                                        <a href="viewfacility.php?id=<?php echo $id ?>" class="btn btn-default btn-block">View Facility Manager</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Facility Manager Details</h4>
                            </div>
                            <div class="modal-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">First Name</h4>
                                        <p class="list-group-item-text"></p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">Last Name</h4>
                                        <p class="list-group-item-text"></p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">Phone</h4>
                                        <p class="list-group-item-text"></p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">Email</h4>
                                        <p class="list-group-item-text"></p>
                                    </a>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="../lib/jquery/jquery.min.js"></script>
        <script src="../js/sweetalert.min.js"></script>
    </body>

</html>