<?php
session_start();
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
    header("Location: logincombined.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['food-type']) && isset($_GET['cuisine-type'])) {
    $foodType = $_GET['food-type'];
    $cuisineType = $_GET['cuisine-type'];

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection Failed: " . $connection->connect_error);
    }

    $sql = "SELECT * FROM recipes WHERE FoodType = ? AND Cuisine = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $foodType, $cuisineType);
    $stmt->execute();
    $result = $stmt->get_result();

    $recipes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    }

    $stmt->close();
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="SearchResultsStyle.css?v=1.0">

    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .recipe-feed {
            text-align: center;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Search Results</h2>
        <div class="recipe-feed" id="recipe-feed">
            <?php if (empty($recipes)): ?>
                <p>No recipes found for the selected criteria.</p>
            <?php else: ?>
                <?php foreach ($recipes as $recipe): ?>
                    <div class="recipe-card">
                        <h3><?php echo htmlspecialchars($recipe['Title']); ?></h3>
                        <p>Food Type: <?php echo htmlspecialchars($recipe['FoodType']); ?>, Cuisine: <?php echo htmlspecialchars($recipe['Cuisine']); ?></p>
                        <p><?php echo htmlspecialchars($recipe['Description']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button onclick="goBack()">Back to Homepage</button>
    </div>

    <script>
        function goBack() {
            window.location.href = 'homepagecombined.php';
        }
    </script>
</body>

</html>
