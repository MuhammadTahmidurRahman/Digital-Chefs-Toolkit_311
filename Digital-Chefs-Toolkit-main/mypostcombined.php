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

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM recipes WHERE UserID = $user_id ORDER BY RecipeID DESC";
$result = $connection->query($sql);

$recipes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posts</title>
    <link rel="stylesheet" href="mypost.css?v=1.0">
</head>
<body>
    <div class="container">
        <h2>My Recipes</h2>
        <?php foreach ($recipes as $recipe): ?>
            <div class="recipe-card">
                <h3><?php echo htmlspecialchars($recipe['Title']); ?></h3>
                <p>Food Type: <?php echo htmlspecialchars($recipe['FoodType']); ?></p>
                <p>Cuisine: <?php echo htmlspecialchars($recipe['Cuisine']); ?></p>
                <p><?php echo htmlspecialchars($recipe['Description']); ?></p>
                <a href="editrecipe.php?RecipeID=<?php echo $recipe['RecipeID']; ?>" class="button">Edit</a>
                <a href="deleterecipe.php?RecipeID=<?php echo $recipe['RecipeID']; ?>" class="button delete-button" onclick="return confirm('Are you sure you want to delete this recipe?');">Delete</a>
            </div>
        <?php endforeach; ?>
        <div class="back-button">
            <a href="homepagecombined.php" class="button">Back to Homepage</a>
            
        </div>
    </div>
</body>
</html>
