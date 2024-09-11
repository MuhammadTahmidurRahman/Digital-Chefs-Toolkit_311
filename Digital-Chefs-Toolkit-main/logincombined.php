<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="LoginStyle.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <div class="formgroup">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <span id="email-error" class="error-message"></span>
            </div>

            <div class="formgroup">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <span id="password-error" class="error-message"></span>
            </div>

            <button type="submit" name="login">Login</button>
        </form>

        <div class="formgroup">
            <p>Don't have an account? <a href="registercombined.php" style="color: rgba(10, 10, 10, 0.459);">Register</a></p>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "project";

        $connection = new mysqli($servername, $username, $password, $database);

        if ($connection->connect_error) {
            die("Connection Failed: " . $connection->connect_error);
        }

        $email = $connection->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE Email='$email'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['Password'])) {
                session_start();
                $_SESSION['user_name'] = $row['FirstName'] . ' ' . $row['LastName'];
                $_SESSION['user_email'] = $row['Email'];
                $_SESSION['user_id'] = $row['UserID'];
                echo "<p style='color:green;'>Login successful! Redirecting to homepage...</p>";
                header("Refresh: 3; url=homepagecombined.php");
                exit();
            } else {
                echo "<script>document.getElementById('password-error').innerText = 'Password doesn\\'t match';</script>";
                echo "<script>document.getElementById('password').value = '';</script>";
                echo "<script>document.getElementById('password').style.borderColor = 'red';</script>";
            }
        } else {
            echo "<script>document.getElementById('email-error').innerHTML = 'No email found. <a href=\"registercombined.php\">Register here</a>';</script>";
            echo "<script>document.getElementById('email').style.borderColor = 'red';</script>";
        }

        $connection->close();
    }
    ?>
</body>
</html>
