    <?php
    require_once("mysqli_connect.php"); // require the db connection
    /* catch the post data from ajax */
    $phone = $_POST['phone'];
    $query = mysqli_query($dbcon,"SELECT id FROM facilitators WHERE `phone` = '$phone'");
    if(mysqli_num_rows($query) == 1) { // if return 1, phone exist.
        echo '1';
    } else { // else not, insert to the table
        
}