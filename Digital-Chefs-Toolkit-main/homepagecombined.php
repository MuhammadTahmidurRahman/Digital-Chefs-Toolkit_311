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

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection Failed: " . $connection->connect_error);
}

$sql = "SELECT * FROM recipes ORDER BY RecipeID DESC";
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
    <title>Food Sharing Platform</title>
    <link rel="stylesheet" href="HomepageStyle.css?v=1.1"> 
</head>

<body>
    <div class="container">
        <div class="left-column">
            <div class="search-box">
                <h2>Search Recipes</h2>
                <form action="searchresultscombined.php" method="get">
                    <h3>Food Type:</h3>
                    <select name="food-type" required>
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
                    </select><br><br>

                    <h3>Cuisine Type:</h3>
                    <select name="cuisine-type" required>
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
                    </select><br><br>

                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="feedback-link">
                <a href="Feedbackcombined.php">Give Feedback</a>
            </div>
        </div>

        <div class="center-column">
            <h2>Recipe Feed</h2>
            <div class="recipe-feed" id="recipe-feed">
                <?php foreach ($recipes as $recipe): ?>
                    <div class="recipe-card">
                        <div class="recipe-title">
                            <h3><?php echo htmlspecialchars($recipe['Title']); ?></h3>
                        </div>
                        <div class="recipe-details">
                            <div class="recipe-food-type">
                                <p><?php echo htmlspecialchars($recipe['FoodType']); ?></p>
                            </div>
                            <div class="recipe-cuisine">
                                <p><?php echo htmlspecialchars($recipe['Cuisine']); ?></p>
                            </div>
                        </div>
                        <div class="recipe-description">
                            <p><?php echo htmlspecialchars($recipe['Description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="right-column">
            <div class="user-profile">
                <h2>User Profile</h2>
                <p>Name: <span id="user-name"><?php echo $_SESSION['user_name']; ?></span></p>
                <p>Email: <span id="user-email"><?php echo $_SESSION['user_email']; ?></span></p>
                <button onclick="editProfile()">Edit Profile</button>
                <button onclick="viewMyPosts()">My Posts</button>
            </div>
            <div class="post-recipe">
                <button onclick="openPostRecipe()">+ Post Recipe</button>
            </div>
        </div>
    </div>

    <script>
        function editProfile() {
            window.location.href = 'editprofilecombined.php';
        }

        function viewMyPosts() {
            window.location.href = 'mypostcombined.php';
        }

        function openPostRecipe() {
            window.location.href = 'postrecipecombined.php';
        }
    </script>
</body>

</html>
