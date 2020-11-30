<?php 

    include("config/db_connect.php");

    // detect POST request - from input name=delete
    if(isset($_POST["delete"])) {

        // escape malitious code
        $id_to_delete = mysqli_real_escape_string($connection, $_POST["id_to_delete"]);

        // make sql - only delete the record who's id is equal to the variable created above
        $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";
        
        // check it works
        if(mysqli_query($connection, $sql)) {
            // success
            header("Location: index.php");
        } else {
            // failure
            echo "Query error: " . mysqli_error();
        }

    } // end of POST if


    // check GET request id parameter (if it's in the URL)
    if(isset($_GET["id"])) {

        // prevent malicious code being typed into the URL into our database
        $id = mysqli_real_escape_string($connection, $_GET["id"]);

        // make sql - grab everything specfic to each id
        $sql = "SELECT * FROM pizzas WHERE id = $id";

        // get the query result
        $result = mysqli_query($connection, $sql);

        // fetch result in array format (one single result as opposed to all on index.php)
        $pizza = mysqli_fetch_assoc($result);

        // free result from memory
        mysqli_free_result($result);

        // close database connection
        mysqli_close($connection);
    } // end of GET if


    include("includes/header.php"); 

?>

<h1>Details</h1>

<div>
    <?php if($pizza) {;?>

        <h2 class="capitalize"><?php echo htmlspecialchars($pizza["title"]); ?></h2>
        <p>Created by: <?php echo htmlspecialchars($pizza["name"]); ?></p>
        <p><?php echo date($pizza["created_at"]); ?></p>
        <h5>Ingredients</h5>
        <p><?php echo htmlspecialchars($pizza["ingredients"]); ?></p>

        <!-- delete form/button -->
        <form action="details.php" method="POST">
            <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id'];?>">
            <input type="submit" name="delete" value="Delete" class="btn brand submit-delete">
        </form>


    <?php } else { ?> <!-- if a pizza doesnt exist e.g. user typed in a random number into URL -->

        <h2>Error: No such pizza exists!</h2>

    <?php } ;?> <!-- end of $pizza ifelse-->
</div>


<?php include("includes/footer.php"); ?>