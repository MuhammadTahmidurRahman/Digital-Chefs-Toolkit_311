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
        die("Connection failed: " . $connection->connect_error);
    }

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_SESSION['user_email']; 

    
    $sql = "UPDATE users SET FirstName=?, LastName=? WHERE Email=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sss", $firstName, $lastName, $email);

    if ($stmt->execute()) {
        
        $_SESSION['user_name'] = $firstName . ' ' . $lastName;

        
        header("Location: homepagecombined.php");
        exit();
    } else {
        $updateError = "Error updating record: " . $stmt->error;
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
    <title>Edit Profile</title>
    <link rel="stylesheet" href="editProfileStyle.css?v=1.0">
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <?php
        if (isset($updateError)) {
            echo "<p style='color:red;'>$updateError</p>";
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
