<?php
// Include database connection file
include 'database.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['psw'];
    $confirmPassword = $_POST['psw-check'];

    // Server-side validation
    if ($password !== $confirmPassword) {
        $error = 'Passwords do not match!';
    } else {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = 'Email already exists!';
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $username, $hashed_password);

            // Execute the statement
            if ($stmt->execute()) {
                header("Location: menu.php");
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css">
<style>
    .container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh; /* Ensures that the container takes up the full height of the viewport */
  text-align: center;
}

#registrationForm {
  max-width: 400px; /* Adjust this width as needed */
  width: 100%;
  padding: 20px;
  background: var(--clr-grey-10);
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}


.error {
  color: var(--clr-red-dark); /* Adjust color for error messages */
  margin-top: 10px;
  text-align: center;
}

label {
    line-height: 1.25;

    letter-spacing: var(--spacing);

    font-family: var(--ff-primary);

    font-size: 1rem;

    text-transform: capitalize;


            display: block;
            margin: 10px 0 5px;
        }
input[type="email"], input[type="password"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .error {
            color: red;
            margin-top: -15px;
            margin-bottom: 15px;
        }
</style>
</head>
<body>

<div class="container">
    <form id="registrationForm" action="registrace.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="username">Username:</label>
        <input  type="text" id="username" name="username" maxlength="20" required>

        <label for="psw">Password:</label>
        <input  type="password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>

        <label for="psw-check">Confirm Password:</label>
        <input type="password" id="psw-check" name="psw-check" required>

        <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>

        <input class="btn" type="submit" value="Submit">
           <div class="button">
        <a href="login.php">Already have an account? Login</a>
    </div>
    </form>

</div>

<script>
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
        var password = document.getElementById('psw').value;
        var confirmPassword = document.getElementById('psw-check').value;
        var errorMessage = document.getElementById('error-message');

        if (password !== confirmPassword) {
            event.preventDefault();
            if (!errorMessage) {
                var newError = document.createElement('div');
                newError.id = 'error-message';
                newError.className = 'error';
                newError.textContent = 'Passwords do not match!';
                document.getElementById('registrationForm').insertBefore(newError, document.getElementById('registrationForm').childNodes[9]);
            } else {
                errorMessage.textContent = 'Passwords do not match!';
            }
        }
    });
</script>

</body>
</html>
