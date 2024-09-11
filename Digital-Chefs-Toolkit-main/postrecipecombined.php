<?php
session_start();
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
    header("Location: logincombined.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "project";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection Failed: " . $connection->connect_error);
    }

    $title = $connection->real_escape_string($_POST['title']);
    $foodType = $connection->real_escape_string($_POST['foodType']);
    $cuisine = $connection->real_escape_string($_POST['cuisine']);
    $description = $connection->real_escape_string($_POST['description']);
    $userID = $_SESSION['user_id'];

    $sql = "INSERT INTO recipes (Title, FoodType, Cuisine, Description, UserID) VALUES ('$title', '$foodType', '$cuisine', '$description', '$userID')";

    if ($connection->query($sql) === TRUE) {
        header("Location: homepagecombined.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }

    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Recipe</title>
    <link rel="stylesheet" href="PostRecipeStyle.css?v=1.1">

</head>
<body>
    <div class="container">
        <h1>Post a New Recipe</h1>
        <form method="POST" action="">
            <div class="formgroup">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="formgroup">
                <label for="foodType">Food Type:</label>
                <select id="foodType" name="foodType" required>
                    <option value="appetizers">Appetizers</option>
                    <option value="main-courses">Main Courses</option>
                    <option value="side-dishes">Side Dishes</option>
                    <option value="curry-item">Curry Item</option>
                    <option value="salads">Salads</option>
                    <option value="soups">Soups</option>
                    <option value="sandwiches">Sandwiches</option>
                    <option value="snacks">Snacks</option>
                    <option value="vegetarian-options">Vegetarian Options</option>
                    <option value="organic-items">Organic Items</option>
                    <option value="healthy-options">Healthy Options</option>
                    <option value="desserts">Desserts</option>
                    <option value="baking">Baking</option>
                    <option value="dairy-items">Dairy Items</option>
                    <option value="gluten-free">Gluten Free</option>
                    <option value="roasting">Roasting</option>
                    <option value="frying">Frying</option>
                    <option value="grilling">Grilling</option>
                    <option value="barbecuing">Barbecuing</option>
                    <option value="smoking">Smoking</option>
                    <option value="boiling">Boiling</option>
                    <option value="steaming">Steaming</option>
                    <option value="braising">Braising</option>
                    <option value="frozen-foods">Frozen Foods</option>
                </select>
            </div>
            <div class="formgroup">
                <label for="cuisine">Cuisine:</label>
                <select id="cuisine" name="cuisine" required>
                    <option value="italian">Italian</option>
                    <option value="french">French</option>
                    <option value="chinese">Chinese</option>
                    <option value="japanese">Japanese</option>
                    <option value="mexican">Mexican</option>
                    <option value="thai">Thai</option>
                    <option value="spanish">Spanish</option>
                    <option value="greek">Greek</option>
                    <option value="turkish">Turkish</option>
                    <option value="lebanese">Lebanese</option>
                    <option value="korean">Korean</option>
                    <option value="vietnamese">Vietnamese</option>
                    <option value="moroccan">Moroccan</option>
                    <option value="brazilian">Brazilian</option>
                    <option value="ethiopian">Ethiopian</option>
                    <option value="russian">Russian</option>
                    <option value="german">German</option>
                    <option value="british">British</option>
                    <option value="american">American</option>
                    <option value="caribbean">Caribbean</option>
                    <option value="indonesian">Indonesian</option>
                    <option value="malaysian">Malaysian</option>
                    <option value="pakistani">Pakistani</option>
                    <option value="persian">Persian</option>
                    <option value="egyptian">Egyptian</option>
                    <option value="african">African</option>
                    <option value="australian">Australian</option>
                    <option value="argentine">Argentine</option>
                    <option value="chilean">Chilean</option>
                </select>
            </div>
            <div class="formgroup">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <button type="submit">Upload Recipe</button>
        </form>
    </div>
</body>
</html>
