<?php
// Start the session to use session variables if needed
session_start();

// Include the database connection file
include('db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate the form data
    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required!";
        exit();
    }

    // Save to database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    if (mysqli_query($conn, $sql)) {
        // If data saved successfully, send email
        $to = "admin@example.com"; // Change this to your email address
        $subject = "New Contact Form Submission";
        $body = "Name: $name\nEmail: $email\nMessage: $message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            echo "Thank you for contacting us! We'll get back to you soon.";
        } else {
            echo "Error sending the email. Please try again later.";
        }
    } else {
        echo "Error saving your message to the database.";
    }
}
?>
