<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Validate form inputs
    if (empty($fullname) || empty($email) || empty($message)) {
        echo "<div class='alert alert-danger'>Please fill in all fields.</div>";
    } else {
        // Include database connection
        require_once "database.php";

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO contacts (fullname, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullname, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Your message has been sent successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>
