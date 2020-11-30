<?php 

    include("config/db_connect.php");

    // initialise content to an empty string until submit button is pressed
    $name = $title = $ingredients = "";
    $errors = array("name" => "", "title" => "", "ingredients" => "");

    // if submit button is clicked
    if(isset($_POST["submit"])) {

        // if name is empty
        if(empty($_POST["name"])) {
            $errors["name"] = "A name is required <br/>";
        } else {
            $name = $_POST["name"];
            // if name isn't valid
            if(!preg_match("/^[a-zA-Z\s]+$/", $name)) {
                $errors["name"] = "Name must be letters and spaces only";
            }
        }

        // if title is empty
        if(empty($_POST["title"])) {
            $errors["title"] = "A title is required <br/>";
        } else {
            $title = $_POST["title"];
            // if title isn't valid
            if(!preg_match("/^[a-zA-Z\s]+$/", $title)) {
                $errors["title"] = "Title must be letters and spaces only";
            }
        }

        // if ingredients is empty
        if(empty($_POST["ingredients"])) {
            $errors["ingredients"] = "At least one ingredient is required <br/>";
        } else {
            $ingredients = $_POST["ingredients"];
            // if ingredients aren't valid
            if(!preg_match("/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/", $ingredients)) {
                $errors["ingredients"] = "Ingredients must be a comma seperated list";
            }
        }

        // Check for errors (if no errors = false, if errors = true(redirects to homepage))
        if(array_filter($errors)) {
            // echo "There are errors in the form";
        } else {
            // echo "The form is valid";

            // protect the data that's going into the database - $connection is from db_connect.php
            $name = mysqli_real_escape_string($connection, $_POST["name"]);
            $title = mysqli_real_escape_string($connection, $_POST["title"]);
            $ingredients = mysqli_real_escape_string($connection, $_POST["ingredients"]);

            // create sql - insert into (these columns) in the pizza table with (these values)
            $sql = "INSERT INTO pizzas(name,title,ingredients) VALUES('$name', '$title', '$ingredients')";

            // save submitted items to pizza database and check for errors
            if(mysqli_query($connection, $sql)) {
                // success - redirect to homepage
                header("location: index.php");
            } else {
                // error 
                echo "Query error: " . mysqli_error($connection);
            }
        }

    } // end of POST check


    include("includes/header.php");
?>

    <section class="add-container">
        <h1>Add a Pizza</h1>
        <form action="add.php" method="POST" class="white add-form">
<div class="form-item">
            <label>Your Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <div class="red-text">
                <?php echo $errors["name"]; ?>
            </div>
</div>
<div class="form-item">
            <label>Pizza Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
            <div class="red-text">
                <?php echo $errors["title"]; ?>
            </div>
</div>
<div class="form-item">

            <label>Ingredients (comma seperated):</label>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>">
            <div class="red-text">
                <?php echo $errors["ingredients"]; ?>
            </div>
</div>
            <div>
                <input type="submit" value="submit" name="submit" class="btn brand submit-delete">
            </div>
        </form>
    </section>


<?php include("includes/footer.php"); ?>