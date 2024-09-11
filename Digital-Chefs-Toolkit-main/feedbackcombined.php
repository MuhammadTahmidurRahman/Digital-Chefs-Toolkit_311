<?php
session_start();
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
    header("Location: logincombined.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['feedback'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "project";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection Failed: " . $connection->connect_error);
    }

    $sql = "INSERT INTO feedback (Name, Email, Feedback) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $feedback);
    $stmt->execute();

    header("Location: homepagecombined.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="FeedbackStyle.css?v=2.0">
</head>

<body>
    <div class="feedback-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
        
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
        
            <label for="feedback">Feedback:</label><br>
            <textarea id="feedback" name="feedback" required></textarea><br><br>
        
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</body>

</html>
