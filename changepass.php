<?php 
include 'includes/functions.php';
?>
<html>
   <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="js/bootstrap.min.js" />

    <link rel="stylesheet"  href="css/style.css" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
       
    
</head>

<body>
      <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                <a class="navbar-brand" href="index.php">FacMan</a>
                </div>
            </div>
        </nav>

    <div  id="add-property" class="container">
        <div class="well">
            <form method="POST">
                <div class="form-group">
                        <label for="password"> New Password </label>
                        <input type="passwod" name="password"
                                value="<?php if(isset($password))echo $password; ?>"class="form-control" id="email">
                        <small style="color:red"><?php if(isset($errors['password']))echo $errors['password']; ?></small>
                </div>
                
                  <div class="form-group">
                        <label for="password"> Confirm Password </label>
                        <input type="password" name="c_password" class="form-control" id="email">
                        <small style="color:red"><?php if(isset($errors['c_password']))echo $errors['c_password']; ?></small>
                </div>
                <div class="form-group">
                    <button type="submit" name="up_pass" class="btn btn-default btn-block">Submit</button>
                        <!--<a href="changepass.html" role="button" class="btn btn-primary btn-block">Submit</a>-->
                    </div>
            </form>
        </div>
    </div>
        
    
    

<script src="lib/jquery/jquery.min.js"></script>    
</body>

</html>