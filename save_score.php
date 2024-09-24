<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id']) && isset($_POST['score']) && isset($_POST['mode'])) {
        $user_id = $_SESSION['user_id'];
        $score = $_POST['score'];
        $mode = $_POST['mode'];

        // Příprava a spojování jména, score a módu
        $stmt = $conn->prepare("INSERT INTO user_scores (user_id, score, mode) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $score, $mode);

        if ($stmt->execute()) {
            echo "Score saved successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid request";
    }
} else {
    echo "Invalid request method";
}
?>
