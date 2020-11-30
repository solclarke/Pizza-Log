<?php 
    
    include("config/db_connect.php");

    // query for all pizzas - pizzas is the table name in the ninja_pizza database
    $sql = "SELECT title, ingredients, id FROM pizzas ORDER BY created_at";

    // write query and get result
    $result = mysqli_query($connection, $sql);

    // fetch the resulting rows as an associated array
    $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);

    // close database connection
    mysqli_close($connection);


    // 
    include("includes/header.php");
?>

<h1 class="index-h1">Log your favourite pizzas or get creative with your own unique recipes!</h1>

<section class="index-container">

            <!--  cycle through the array -->
            <?php foreach($pizzas as $pizza) { ?>

                    <div class="pizzas white">
                    <img src="img/pizza.png" alt="pizza" class="pizza-img">
                        <div class="pizza-content">
                            <h2 class="capitalize"><?php echo htmlspecialchars($pizza["title"]);?></h2>
                            <!--  turn the string of ingredients into a list. each li starts after a comma -->
                            <ul>
                                <?php foreach(explode(",", $pizza["ingredients"]) as $ing) { ?>
                                    <li>
                                        <?php echo htmlspecialchars($ing); ?>
                                    </li>
                                <?php } ?> <!-- end of $pizza["ingredients"] foreach -->
                            </ul>
                        </div>
                        <div class="more-info">
                            <a class="brand-text" href="details.php?id=<?php echo $pizza['id']; ?>">more info</a>
                        </div>
                    </div>
                </div>

            <?php } ?> <!-- end of $pizza foreach -->
</section>

<?php include("includes/footer.php"); ?>