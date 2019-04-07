    <?php
    require_once("mysqli_connect.php"); // require the db connection
    /* catch the post data from ajax */
    $rc_num = $_POST['rc_num'];
    $query = mysqli_query($dbcon,"SELECT id FROM company_profile WHERE `rc_num` = '$rc_num'");
    if(mysqli_num_rows($query) == 1) { // if return 1, phone exist.
        echo '1';
    } else { // else not, insert to the table
        
}