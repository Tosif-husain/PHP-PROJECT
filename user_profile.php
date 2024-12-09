<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    die("Please log in to view this page.");
}

// Database connection
require_once 'db.php'; // Ensure you have your database connection here

$user_id = $_SESSION['user']['id']; // Assuming the user's ID is stored in the session

// Fetch user details for displaying
$result = $conn->query("SELECT * FROM user_details WHERE user_id = $user_id"); // Adjust your query as needed

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
</head>
<body>
    <h1>Your Profile</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Job Type</th>
            <th>Comments</th>
            <th>Company Name</th>
            <th>City</th>
            <th>Country</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['job_type']); ?></td>
                <td><?php echo htmlspecialchars($user['comments']); ?></td>
                <td><?php echo htmlspecialchars($user['company_name']); ?></td>
                <td><?php echo htmlspecialchars($user['city']); ?></td>
                <td><?php echo htmlspecialchars($user['country']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="home.php">Back to Home</a>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
