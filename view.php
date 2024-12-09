<?php
session_start(); // Start the session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details based on ID
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM user_details WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "No user found with this ID.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - <?php echo htmlspecialchars($user['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 text-white py-4">
        <div class="container mx-auto flex justify-between">
            <a class="header text-xl" href="Home.php">Home</a>
            <a class="header text-xl" href="about.html">About</a>
            <a class="header text-xl" href="contact.html">Contact</a>
            <a class="header text-xl" href="details.php">Upload Details</a>
            <a class="header text-xl" href="technology.html">Profile</a>
            <a class="header text-xl" href="profile.php">All Users</a> <!-- Updated link -->
        </div>
    </header>

    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">User Details</h1>
        
        <div class="bg-white shadow-md rounded-lg p-6">
            <p class="mb-2"><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
            <p class="mb-2"><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p class="mb-2"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p class="mb-2"><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
            <p class="mb-2"><strong>Job Type:</strong> <?php echo htmlspecialchars($user['job_type']); ?></p>
            <p class="mb-2"><strong>Company Name:</strong> <?php echo htmlspecialchars($user['company_name']); ?></p>
            <p class="mb-2"><strong>Country:</strong> <?php echo htmlspecialchars($user['country']); ?></p>
            <p class="mb-2"><strong>City:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
            <p class="mb-2"><strong>Comments:</strong> <?php echo htmlspecialchars($user['comments']); ?></p>
            <p class="mb-2"><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
        </div>

        <div class="mt-4">
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="edit.php?id=<?php echo $user['id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Edit</a>
                <a href="user_details.php?delete_id=<?php echo $user['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded">Delete</a>
            <?php else: ?>
                <p class="text-gray-500">You do not have permission to edit or delete this user.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
