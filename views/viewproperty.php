<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: ../index.php");
    exit();
}
require '../includes/mysqli_connect.php';
$prop_id = $_GET['prop_id'];
$qu = "SELECT id FROM property_details WHERE property_id = '$prop_id'";
$re = mysqli_query($dbcon, $qu);
$ans=  mysqli_fetch_assoc($re);
$id = $ans['id'];

$query = "SELECT CONCAT(t.title, ' ', pd.last_name) AS last_name, pd.first_name,pd.location, pd.service, b.type FROM property_details pd JOIN title t
       ON pd.title = t.id
       JOIN building_type b ON pd.type_id = b.id
     WHERE property_id = '$prop_id'";
$result = mysqli_query($dbcon, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $last_name = $row['last_name'];
    $first_name = $row['first_name'];
    $address = $row['location'];
    $service = $row['service'];
    $type = $row['type'];
}
?>
<html>
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Property</title>
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
                                    </ul></li>
                            
                          </ul>
                  </div>
                </div>
              </nav>

        <div class="container">

            <div class="row">
                <div class="col-sm-5">
                    <div class="panel panel-primary">
                            <div class="panel-heading">Property Details</div>
                            <div class="panel-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">Last Name</h4>
                                        <p class="list-group-item-text"><?php echo $last_name ?></p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">First Name</h4>
                                        <p class="list-group-item-text"><?php echo $first_name ?></p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">Address</h4>
                                        <p class="list-group-item-text"><?php echo $address ?></p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">Service</h4>
                                        <p class="list-group-item-text"><?php echo $service ?></p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">Type</h4>
                                        <p class="list-group-item-text"><?php echo $type ?></p>
                                    </a>
                                </div>
                            </div>
                    </div>
                </div>
                
                
                    <div class="col-sm-7">
                   
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Milestones
                            </div>
                            <div class="panel-body">
                                <div style="overflow-x:auto;">
                                    <table>
                                        <tr>
                                            <?php 
                                            $img_q = "SELECT picture FROM milestones WHERE property_id = '$id'";
                                            $img_r = mysqli_query($dbcon, $img_q);
                                            while ($img_row = mysqli_fetch_assoc($img_r)){
                                                $pic = $img_row['picture'];
                                                ?>
                                            <td><a href="<?php echo $pic?>"><img style="width: 200px;
    height: 200px;
    border: 3px solid lightgray;
    padding: 2px;" src="<?php echo $pic?>"></a> </td>
                                          <?php
                                            }
                                            ?>
                                            
                                             </tr>
                                 
                                    </table>    
                
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            <div class="row">
                    <div class="col-sm-4 col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Contractors
                            </div>
                            <div class="panel-body">
                                <div class="list-group">
                            <?php
                            $query2 = "SELECT id, CONCAT(first_name, ' ',last_name) AS name, profession FROM contractors WHERE property_id = '$id'";
                            $result2 = mysqli_query($dbcon, $query2);
                            while ($row = mysqli_fetch_assoc($result2)) {
                                $c_id= $row['id'];
                                $name = $row['name'];
                                $prof = $row['profession'];
                                ?>                           
                                    <a href="<?php echo 'viewcontractor.php?id='.$c_id?>" class="list-group-item">
                                        <h4 class="list-group-item-heading"><?php echo $name ?></h4>
                                        <p class="list-group-item-text"><?php echo $prof ?></p>
                                    </a>
                                     <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                       <div class="col-sm-4 col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Facility Manager
                            </div>
                            <div class="panel-body">
                                <div class="list-group">
                                    <?php
                                    $company_id = $_SESSION['company_id'];
                             $query3 = "SELECT facilitator_id FROM properties WHERE property_id='$prop_id'";
                             $result3 = mysqli_query($dbcon, $query3);
                             $row3 = mysqli_fetch_assoc($result3);
                             $f_id = $row3['facilitator_id'];       
                                    
                                    
                                    
                            $query4 = "SELECT id, CONCAT(first_name, ' ',last_name) AS name, email, phone FROM facilitators "
                                    . "WHERE id = '$f_id' ";
//                            var_dump($query4);
                            $result4 = mysqli_query($dbcon, $query4);
                            while ($row = mysqli_fetch_assoc($result4)) {
//                                var_dump($row);
                                $f_id= $row['id'];
                                $f_name = $row['name'];
                                $f_email = $row['email'];
                                $f_phone = $row['phone'];
                                ?>   
                                    <a href="<?php echo 'viewfacility.php?id='.$f_id?>" class="list-group-item">
                                        <h4 class="list-group-item-heading"><?php echo $f_name?></h4>
                                        <p class="list-group-item-text"><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;<?php echo $f_email?></p>
                                        <p class="list-group-item-text"><span class="glyphicon glyphicon-phone-alt"></span>&nbsp;&nbsp;<?php echo $f_phone?></p>
                                    </a>
                                     <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8 col-lg-4">
                        <div class="panel panel-primary">
                        <div class="panel-heading">Funds</div>
                            <div class="panel-body">
                               <?php 
                        $fq = "SELECT DISTINCT request_id FROM fund_details WHERE property_id = '$id' AND treated = '0'";
                        $fqe = mysqli_query($dbcon, $fq);
                        while ($row = mysqli_fetch_assoc($fqe)){
                            $req_id = $row['request_id'];
                       ?>
                            <div class="list-group">
                                   <a href="viewfunds.php?id='<?php echo $req_id ?>'" class="list-group-item">
                                    <?php   echo"#". $req_id ?>
                                   </a>
                               </div>
                                  <?php  
                            }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            
            
                </div>
              


    <script src="../lib/jquery/jquery.min.js"></script>
</body>

</html>
