    <?php
    require_once("mysqli_connect.php"); // require the db connection
    /* catch the post data from ajax */
    $email = $_POST['email'];
    $query = mysqli_query($dbcon,"SELECT id FROM company_profile WHERE `email` = '$email'");
    $query1 = mysqli_query($dbcon,"SELECT id FROM facilitators WHERE `email` = '$email'");
    if(mysqli_num_rows($query) == 1 || mysqli_num_rows($query1) == 1) { // if return 1, email exist.
        echo '1';
    } else { // else not, insert to the table
        
}