<?php
session_start();

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;

if (!$is_admin) {
    die("Access denied.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM user_details WHERE id=$delete_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM user_details");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
        }
        table, th, td {
            border: 1px solid #dddddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-home {
            display: block;
            text-align: center;
            margin: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>User Profiles</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Job Type</th>
            <th>Comments</th>
            <th>Company Name</th>
            <th>City</th>
            <th>Country</th>
            <th>Actions</th>
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
                <td>
                    <a href="update_user.php?id=<?php echo $user['id']; ?>">Update</a>
                    <a href="?delete_id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="home.php" class="back-home">Back to Home</a>
</body>
</html>

<?php
$conn->close();
?>
