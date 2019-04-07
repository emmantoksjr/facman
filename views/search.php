<?php
session_start();
if (!isset($_SESSION['company_id']))
{ header("Location: ../index.php");
exit();
}?>
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
                                    </ul></li>
                            
                          </ul>
                  </div>
                </div>
              </nav>

              <div class="container" style="margin-left: 250px">
                  <div class="row">
                      
                      <div style="margin-left: 10px" class="col-sm-9 well">

                            <div class="panel panel-default" >
                                <div class="panel-heading">Search Result

                                </div>
                            </div>
                            <div class="row">
                                <?php 
                             
                                require_once '../includes/mysqli_connect.php';
                                $company_id = $_SESSION['company_id'];
                                $search = $_GET['search'];
                                $fetch_properties = "SELECT pd.property_id, pd.location FROM property_details pd "
                                              . "INNER JOIN properties p ON pd.property_id = p.property_id "
                                              . "WHERE pd.property_id like '%$search%' AND company_id='$company_id'";
//                                      die(var_dump($fetch_properties));
                            $properties = mysqli_query($dbcon,$fetch_properties);
                            while($row = mysqli_fetch_assoc($properties)){
                              $prop_id=  $row['property_id'];
                              $prop_location = $row['location'];
                           ?>
                                <div class="col-sm-4">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading"><?php echo $prop_id?></div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <img src="../img/prop.png" height="65" width="65">
                                                </div>

                                                <div class="col-sm-8">
                                                    <p class="text-wrap"><?php echo $prop_location?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer"><a role="button" href="viewproperty.php?prop_id=<?php echo $prop_id ?>" class="btn btn-default btn-block">View Property</a></div>
                                    </div>
                                </div>
                                <?php
                                      }
                          ?>
                            </div>

                      </div>
                  </div>
              </div>



    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../js/sweetalert.min.js"></script>
</body>

</html>