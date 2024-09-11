<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: logincombined.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection Failed: " . $connection->connect_error);
}

if (!isset($_GET['RecipeID'])) {
    die("Recipe ID not specified.");
}

$recipe_id = $_GET['RecipeID'];
$sql = "SELECT * FROM recipes WHERE RecipeID = $recipe_id";
$result = $connection->query($sql);

if ($result->num_rows == 0) {
    die("Recipe not found.");
}

$recipe = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $food_type = $_POST['food_type'];
    $cuisine = $_POST['cuisine'];
    $description = $_POST['description'];

    $update_sql = "UPDATE recipes SET 
        Title = '$title', 
        FoodType = '$food_type', 
        Cuisine = '$cuisine', 
        Description = '$description' 
        WHERE RecipeID = $recipe_id";

    if ($connection->query($update_sql) === TRUE) {
        header("Location:mypostcombined.php ");
        exit();
    } else {
        echo "Error updating record: " . $connection->error;
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="EditRecipeStyle.css">
</head>
<body>
    <div class="container">
        <h2>Edit Recipe</h2>
        <form action="editrecipe.php?RecipeID=<?php echo $recipe_id; ?>" method="post">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($recipe['Title']); ?>" required>

            <label for="food_type">Food Type</label>
            <input type="text" id="food_type" name="food_type" value="<?php echo htmlspecialchars($recipe['FoodType']); ?>" required>

            <label for="cuisine">Cuisine</label>
            <input type="text" id="cuisine" name="cuisine" value="<?php echo htmlspecialchars($recipe['Cuisine']); ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($recipe['Description']); ?></textarea>

            <button type="submit">Update Recipe</button>
        </form>
        <div class="back-button">
            <a href="mypostcombined.php" class="button">Back to My Posts</a>
        </div>
    </div>
</body>
</html>
