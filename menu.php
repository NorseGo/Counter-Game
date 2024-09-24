<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';

// Get the username from the session
$username = $_SESSION['username'];

// Fetch the highest scores for each difficulty
$difficulties = ['easy', 'medium', 'hard', 'impossible'];
$scores = [];

foreach ($difficulties as $difficulty) {
    $sql = "SELECT users.username, MAX(user_scores.score) as highest_score 
            FROM user_scores 
            JOIN users ON user_scores.user_id = users.id 
            WHERE user_scores.mode = 'time_$difficulty' 
            GROUP BY users.username 
            ORDER BY highest_score DESC 
            LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $scores[$difficulty] = [
            'username' => $row['username'],
            'highest_score' => $row['highest_score']
        ];
    } else {
        $scores[$difficulty] = [
            'username' => 'N/A',
            'highest_score' => 0
        ];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Menu</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 10px 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #ffffff;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;
            min-width: 160px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Make the header background invisible */
        .header {
            background-color: transparent;
        }

        /* Adjust username color and padding */
        .dropdown span {
            color: black;
            padding-right: 10px; /* Add padding to separate from the dropdown */
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="dropdown">
            <span><?php echo htmlspecialchars($username); ?></span>
            <div class="dropdown-content">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <main>
        <form action="">
            <h1>Select Game Mode:</h1>
            <div class="radio-container">
                <input type="radio" id="timeless-mode" class="radio-input" name="mode" value="timeless">
                <label for="timeless-mode" class="radio-label">Timeless</label>

                <input type="radio" id="time-mode" class="radio-input" name="mode" value="time">
                <label for="time-mode" class="radio-label">Time</label>
            </div>

            <h1>Select Difficulty:</h1>
            <div class="radio-container">
                <input type="radio" id="easy-difficulty" class="radio-input" name="difficulty" value="easy">
                <label for="easy-difficulty" class="radio-label">Easy</label>

                <input type="radio" id="medium-difficulty" class="radio-input" name="difficulty" value="medium">
                <label for="medium-difficulty" class="radio-label">Medium</label>

                <input type="radio" id="hard-difficulty" class="radio-input" name="difficulty" value="hard">
                <label for="hard-difficulty" class="radio-label">Hard</label>

                <input type="radio" id="impossible-difficulty" class="radio-input" name="difficulty" value="impossible">
                <label for="impossible-difficulty" class="radio-label">Impossible</label>
            </div>
        </form>

        <div class="button-container">
            <button class="btn" id="start-button">Start</button>
        </div>
    </main>

    <table>
        <tr>
            <th id="col" colspan="3">Table of scores</th>
        </tr>
        <tr>
            <th id="diff">Difficulty</th>
            <th id="user">Username</th>
            <th id="hscore">Highest Score</th>
        </tr>
        <?php foreach ($difficulties as $difficulty): ?>
        <tr>
            <td><?php echo ucfirst($difficulty); ?></td>
            <td><?php echo htmlspecialchars($scores[$difficulty]['username']); ?></td>
            <td><?php echo htmlspecialchars($scores[$difficulty]['highest_score']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <script src="menu.js"></script>
</body>
</html>
