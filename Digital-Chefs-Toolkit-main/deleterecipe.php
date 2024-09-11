<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: logincombined.php");
    exit();
}

if (!isset($_GET['RecipeID'])) {
    die("Recipe ID not specified.");
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection Failed: " . $connection->connect_error);
}

$recipe_id = $_GET['RecipeID'];
$user_id = $_SESSION['user_id'];

$check_sql = "SELECT * FROM recipes WHERE RecipeID = $recipe_id AND UserID = $user_id";
$check_result = $connection->query($check_sql);

if ($check_result->num_rows == 0) {
    die("You are not authorized to delete this recipe.");
}

$delete_sql = "DELETE FROM recipes WHERE RecipeID = $recipe_id";

if ($connection->query($delete_sql) === TRUE) {
    header("Location: mypostcombined.php");
    exit();
} else {
    echo "Error deleting record: " . $connection->error;
}

$connection->close();
?>
