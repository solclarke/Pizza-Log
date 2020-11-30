<?php 

    // connect to database - (host, username, password, database name)
    $connection = mysqli_connect("localhost", "username", "password", "database name");


    // check database connection
    if(!$connection) { // if the database isn't connected
        echo "Connection error: " . mysqli_connect_error();
    }

?>
