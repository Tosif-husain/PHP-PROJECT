<?php
session_start();

// Ensure that only admins can access the page
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

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

// Fetch the user details for editing
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // Prepare and execute the select query
    $sql = "SELECT * FROM user_details WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found";
        exit();
    }
    $stmt->close(); // Close after use
}

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $job_type = $_POST['job_type'];
    $company_name = $_POST['company_name'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $comments = $_POST['comments'];

    // Prepare the update query
    $update_sql = "UPDATE user_details SET name = ?, job_type = ?, company_name = ?, city = ?, country = ?, comments = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssi", $name, $job_type, $company_name, $city, $country, $comments, $user_id);

    // Execute the update query and check for errors
    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully'); window.location.href = 'profile.php';</script>";
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close(); // Close after executing
    $conn->close(); // Close the connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1A202C;
            color: #E2E8F0;
        }
        input, textarea {
            background-color: #2D3748;
            color: #E2E8F0;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        input:focus, textarea:focus {
            background-color: #4A5568;
            box-shadow: 0 0 10px rgba(66, 153, 225, 0.5);
        }
        input::placeholder, textarea::placeholder {
            color: #A0AEC0;
        }
        form {
            background-color: #2D3748;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        button {
            transition: background-color 0.2s ease, transform 0.1s ease;
        }
        button:hover {
            background-color: #63B3ED;
            transform: translateY(-2px);
        }
        button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="container max-w-lg mx-auto p-8 bg-gray-900 rounded-lg shadow-xl transform hover:scale-105 transition-transform">
        <h2 class="text-4xl font-bold mb-8 text-center text-blue-400">Edit User Details</h2>

        <form method="POST" class="p-8 rounded-lg shadow-lg">
            <label class="block mb-3 text-lg font-semibold">Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Enter name" class="border border-gray-600 rounded-lg p-3 w-full mb-6 focus:outline-none focus:ring focus:border-blue-400">

            <label class="block mb-3 text-lg font-semibold">Job Type:</label>
            <input type="text" name="job_type" value="<?php echo htmlspecialchars($user['job_type']); ?>" placeholder="Enter job type" class="border border-gray-600 rounded-lg p-3 w-full mb-6 focus:outline-none focus:ring focus:border-blue-400">

            <label class="block mb-3 text-lg font-semibold">Company Name:</label>
            <input type="text" name="company_name" value="<?php echo htmlspecialchars($user['company_name']); ?>" placeholder="Enter company name" class="border border-gray-600 rounded-lg p-3 w-full mb-6 focus:outline-none focus:ring focus:border-blue-400">

            <label class="block mb-3 text-lg font-semibold">City:</label>
            <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" placeholder="Enter city" class="border border-gray-600 rounded-lg p-3 w-full mb-6 focus:outline-none focus:ring focus:border-blue-400">

            <label class="block mb-3 text-lg font-semibold">Country:</label>
            <input type="text" name="country" value="<?php echo htmlspecialchars($user['country']); ?>" placeholder="Enter country" class="border border-gray-600 rounded-lg p-3 w-full mb-6 focus:outline-none focus:ring focus:border-blue-400">

            <label class="block mb-3 text-lg font-semibold">Comments:</label>
            <textarea name="comments" placeholder="Enter comments" class="border border-gray-600 rounded-lg p-3 w-full mb-6 focus:outline-none focus:ring focus:border-blue-400"><?php echo htmlspecialchars($user['comments']); ?></textarea>

            <button type="submit" class="w-full bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-400 transition-transform transform hover:scale-105">Update</button>
        </form>
    </div>
</body>
</html>
