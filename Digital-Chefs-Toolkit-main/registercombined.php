<!DOCTYPE html>
<html>
<head>
  <title>Registration Form</title>
  <link rel="stylesheet" href="RegistrationStyle.css?v=1.0">
  <style>
    .error-message {
      color: red;
      font-size: 14px;
    }

    .error-message a {
      color: #654321; 
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="container">
    <form method="POST" action="" id="registrationForm">
      <div class="formgroup">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>
      </div>

      <div class="formgroup">
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>
      </div>

      <div class="formgroup">
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div class="formgroup">
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>
      </div>

      <div class="formgroup">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <span id="email-error" class="error-message"></span>
      </div>

      <div class="formgroup">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="formgroup">
        <label for="confirm_password">Retype Password:</label>
        <input type="password" id="confirmpassword" name="confirmpassword" required>
        <span id="password-error" class="error-message"></span>
      </div>

      <button type="submit" name="register">Register</button>
    </form>

    <div class="formgroup">
      <p>Already have an account? <a href="logincombined.php" style="color: rgba(10, 10, 10, 0.459);">Login</a></p>
    </div>
  </div>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "project";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
      die("Connection Failed: " . $connection->connect_error);
    }

    $email = $connection->real_escape_string($_POST['email']);

    
    $check_email_query = "SELECT * FROM users WHERE Email='$email'";
    $result = $connection->query($check_email_query);

    if ($result->num_rows > 0) {
      echo "<script>
                document.getElementById('email-error').innerHTML = 'Email already exists. Login <a href=\"logincombined.php\" style=\"color: #654321;\">here</a>.';
            </script>";
    } else {
      
      $firstname = $connection->real_escape_string($_POST['firstname']);
      $lastname = $connection->real_escape_string($_POST['lastname']);
      $gender = $connection->real_escape_string($_POST['gender']);
      $dob = $connection->real_escape_string($_POST['dob']);
      $password = $connection->real_escape_string($_POST['password']);
      $confirm_password = $connection->real_escape_string($_POST['confirmpassword']);

      if ($password !== $confirm_password) {
        echo "<script>
                  document.getElementById('password-error').textContent = 'Passwords do not match!';
              </script>";
      } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (FirstName, LastName, Gender, DateOfBirth, Email, Password) VALUES ('$firstname', '$lastname', '$gender', '$dob', '$email', '$hashed_password')";

        if ($connection->query($sql) === TRUE) {
          echo "<p style='color:green;'>Registration successful! Redirecting to login page...</p>";
          header("Refresh: 3; url=logincombined.php");
          exit();
        } else {
          echo "<p style='color:red;'>Error: " . $sql . "<br>" . $connection->error . "</p>";
        }
      }
    }

    $connection->close();
  }
  ?>

  <script>
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
      var password = document.getElementById('password').value;
      var confirmPassword = document.getElementById('confirmpassword').value;
      var errorElement = document.getElementById('password-error');

      if (password !== confirmPassword) {
        errorElement.textContent = 'Passwords do not match!';
        event.preventDefault(); 
      }
    });
  </script>
</body>
</html>
