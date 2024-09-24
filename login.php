<?php
// Start the session
session_start();

// Include database connection file
include 'database.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the email exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;

            // Redirect to the game menu
            header("Location: menu.php");
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "Invalid email or password!";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">

    <style>
 .container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh; /* Ensures that the container takes up the full height of the viewport */
  text-align: center;
}

.forma {
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
    <form class="forma" action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>

        <input class="btn" type="submit" value="Login">
        <div>
        <a href="index.php">Don't have an account? Register</a>
    </div>
    </form>
</div>

</body>
</html>
