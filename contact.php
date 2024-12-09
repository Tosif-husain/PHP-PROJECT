<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "project";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $location = $_POST['location'];
    $message = $_POST['message'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("INSERT INTO contacts (full_name, location, message, email, contact) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $location, $message, $email, $contact);

    if ($stmt->execute()) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Error sending message.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact page</title>
    <link rel="stylesheet" href="contact.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <header>
        <div id="container">
            <a href="Home.php">Home</a>
            <a href="#">Services</a>
            <a href="#">Skill</a>
            <a href="#">Projects</a>
            <a href="#">Contact</a>
        </div>
    </header>

    <div id="main-container">
        <div id="contact-paragraph">
            <h1 class="contact">Contact Me</h1>
            <p style="color: #ffffff; margin-top: 25px">
            We’d love to hear from you! Whether you have a question, feedback, or need assistance, feel free to reach out to us. <br><br>

Phone: 96010XXXXX <br><br>
Email: ansaritausif763@gmail.com <br><br>

Our team is available to assist you Monday to Friday, from 9:00 AM to 5:00 PM. We strive to respond to all inquiries within 24 hours.

Alternatively, you can fill out the contact form below, and we’ll get back to you as soon as possible.

Thank you for choosing CODEHUB!
            </p>
        </div>

        <div id="second-div">
            <div id="first_child">
                <span class="material-symbols-outlined"> mail </span>
                <h3 id="Email">Email</h3>
                <p id="mail-id">ansaritausif763@gmail.com</p>
                <button id="massage-button">Send a message</button>
            </div>

            <div id="second_child">
                <span class="material-symbols-outlined"> phone_in_talk </span>
                <h3 id="Email">Contact</h3>
                <p id="mail-id">+91 9601067518</p>
                <button id="massage-button">Send a message</button>
            </div>
        </div>

        <div class="third-div">
            <form method="POST" action="">
                <input type="text" name="full_name" placeholder="Your full name" required />
                <input type="text" name="location" placeholder="Your Local" required />
                <textarea name="message" placeholder="Your message" required></textarea>
                <input type="email" name="email" placeholder="Your email" required />
                <input type="text" name="contact" placeholder="Your contact number" required />
                <button type="submit">Send message</button>
            </form>
        </div>
    </div>
</body>
</html>
