<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];

// Check if there are already notifications
$check = $conn->query("SELECT COUNT(*) AS count FROM notifications WHERE username='$username'");
$countRow = $check->fetch_assoc();

if ($countRow['count'] == 0) {
    // Insert sample notifications for testing
    $conn->query("INSERT INTO notifications (username, message) VALUES ('$username', 'Your appointment has been confirmed.')");
    $conn->query("INSERT INTO notifications (username, message) VALUES ('$username', 'Your grievance has been resolved.')");
    $conn->query("INSERT INTO notifications (username, message) VALUES ('$username', 'New service available: Voter ID update.')");
    $conn->query("INSERT INTO notifications (username, message) VALUES ('$username', 'Reminder: Your Aadhaar appointment is tomorrow.')");
}

// Mark all notifications as read
$conn->query("UPDATE notifications SET is_read = 1 WHERE username='$username'");

// Fetch notifications
$result = $conn->query("SELECT * FROM notifications WHERE username='$username' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('Free Photo _ Bell reminder notification alert or alarm icon sign or symbol for application website ui on white background 3d rendering illustration.jpg'); /* Replace with actual image path */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="p-6 bg-gray-50 bg-opacity-70 min-h-screen">
    <h1 class="text-2xl font-bold mb-6 text-white">Notifications</h1>
    <ul class="space-y-4">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li class="p-4 border bg-white rounded shadow">
                <p><?= htmlspecialchars($row['message']) ?></p>
                <small class="text-gray-500"><?= $row['created_at'] ?></small>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
