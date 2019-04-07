<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: ../index.php");
    exit();
}
include '../includes/functions.php';
?>

<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Facility Manager</title>
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
                            <form class="navbar-form navbar-right" role="search">
                                <div class="form-group ">
                                    <input type="text" class="form-control" placeholder="Search..">
                                    <!-- <span class="input-group-btn"> -->
                                    <!-- <button class="btn btn-default" type="button">
                                      <span class="glyphicon glyphicon-search"></span> -->
                                    <!-- </button>
                                  </span>         -->
                                </div>
                            </form>
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
                            </ul></li>

                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">

            <div class="row">
                <div class="col-sm-4">
                    <div class="well text-center">
                         <?php
                    $r_id = $_GET['id'];
                    $q_t = "SELECT picture FROM fund_pic where `request_id`=" . "$r_id";
                    require_once '../includes/mysqli_connect.php';
                    $check5 = mysqli_query($dbcon, $q_t);
                    $row = mysqli_fetch_assoc($check5);
                    $pic = $row['picture'];
                     ?>
                        <img class="img-thumbnail" style="width: 300px; height: 300px;" src="<?php echo $pic ;?>" alt="Fund Image">
                    </div>
                </div>
                
                <div class="col-sm-8">
                     <div class="table-responsive">          
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Amount(#)</th>
                        </tr>
                    </thead>
                    <?php
                    $r_id = $_GET['id'];
                    $q_re = "SELECT * FROM fund_details where `request_id`=" . "$r_id";
                    require_once '../includes/mysqli_connect.php';
                    $check = mysqli_query($dbcon, $q_re);
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($check)) {
                        $cc_id = $count++;
                        $name = $row['name'];
                        $quantity = $row['quantity'];
                        $amount = $row['amount'];
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $cc_id ?></td>
                                <td><?php echo $name ?></td>
                                <td><?php echo $quantity ?></td>
                                <td><?php echo $amount ?></td>
                            </tr>
                        </tbody>
                        <?php
                    }
                    ?>
                </table>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        <label for="pwd">Response <b style="color: red">*</b></label>
                        <div class="radio">
                            <label><input type="radio" name="optradio" value="1">Accept Fund</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio"  name="optradio" value="2">Reject Fund</label>
                        </div>
                    </div>
                    <input type="text" hidden="hidden" name="r_id" value=" <?php echo $r_id?>"/>
                    <div class="form-group">
                        <label for="pwd">Comment <b style="color: red">*</b></label>
                        <textarea type="text" required="required" name="comment" class="form-control" id="service"></textarea>
                    </div>
                    <div class="form-group">
                        <!--<a type="submit" href="viewfunds.php?id=<?php // echo $r_id ?>" name='respond' class="btn btn-primary btn-block">Submit</a>-->
                        <button type="submit" role="button" name='respond' class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
                </div>
            </div>
           
        </div><script src="../lib/jquery/jquery.min.js"></script>
    </body>

</html>