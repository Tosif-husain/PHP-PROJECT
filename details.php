<?php
session_start(); 

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "project"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $company_name = $_POST['company_name'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $comments = $_POST['comments'];
    $job_type = $_POST['job_type'];

    $sql = "INSERT INTO user_details (name, email, phone_number, company_name, country, city, comments, job_type) 
            VALUES ('$name', '$email', '$phone_number', '$company_name', '$country', '$city', '$comments', '$job_type')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link rel="stylesheet" href="details.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div id="main-container">
        <div id="parent-div">
            <div id="child-one">
                <h3 class="heading">Global delivery center</h3>
                <img class="location" src="images/location.png" alt="">
                <p class="location-text">Technology, Green Park, Gujrat, India</p>
                <img class="call" src="images/call.png" alt="">
                <p class="number">+91 9601067518</p>
                <img class="call" src="images/call.png" alt="">
                <p class="number">+91 9106246093</p>
            </div>

            <div id="child-two">
                <h3 class="heading2">REGD Office</h3>
                <img class="location" src="images/location.png" alt="">
                <p class="location-text2">C2, 4th Block, VB Park, Faisalnagar, Danilimda, Ahmedabad, Gujarat, India</p>
                <img class="call" src="images/call.png" alt="">
                <p class="number">+91 9601067518</p>
            </div>

            <div id="footer">
                <p class="footer-text">App4Church is a digital solution that streamlines church operations and data handling.</p>
                <div id="icons">
                    <img class="instagram" src="images/instagram.png" alt="">
                    <img class="facebook" src="images/facebook.png" alt="">
                    <img class="you-tube" src="images/youtube (2).png" alt="">
                    <img class="linked-in" src="images/linked in.png" alt="">
                </div>
            </div>
        </div>

        <div id="second-parent-div">
            <div id="all-text">            
                <h1 class="lets">Lets <span class="talk">Talk</span></h1>
                <p class="para">Our team is here round-the-clock, ready to respond to all your inquiries</p>
            </div>

            <form method="POST" action="">
                <div class="input-field1">
                    <p>Name</p>
                    <div class="input-items">
                        <i class="fa-regular fa-user icon"></i>
                        <input placeholder="Enter name" type="text" name="name" class="input1" required>
                    </div>

                    <p>What are you looking for?</p>
                    <div class="input-items1">
                        <i class="fa-regular fa-user icon"></i>
                        <select class="input1" name="job_type" required>
                            <option value="Job">Job</option>
                            <option value="InternShip">Internship</option>
                            <option value="Hackathon">Hackathon</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-field1">
                    <p>Email</p>
                    <div class="input-items">
                        <i class="fa-regular fa-user icon"></i>
                        <input placeholder="Enter email" type="email" name="email" class="input1" required>
                    </div>

                    <p>Phone Number</p>
                    <div class="input-items2">
                        <i class="fa-regular fa-user icon"></i>
                        <input placeholder="Enter phone number" type="tel" name="phone_number" class="input1" required>
                    </div>
                </div>
                
                <div class="input-field1">
                    <p>Company name</p>
                    <div class="input-items3">
                        <i class="fa-regular fa-user icon"></i>
                        <input placeholder="Enter company name" type="text" name="company_name" class="input1" required>
                    </div>

                    <p class="country">Country</p>
                    <div class="input-items4">
                        <i class="fa-regular fa-user icon"></i>
                        <select class="input1" name="country" required>
                            <option value="India">India</option>
                            <option value="USA">USA</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="UAE">UAE</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-field1">
                    <p>City</p>
                    <div class="input-items10">
                        <i class="fa-regular fa-user icon"></i>
                        <select class="input10" name="city" required>
                            <option value="Ahmedabad">Ahmedabad</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Bengaluru">Bengaluru</option>
                        </select>
                    </div>
                </div>

                <div class="input-field4">
                    <p>Write Your Comments</p>
                    <div class="input-items20">
                        <i class="fa-regular fa-user icon"></i>
                        <input placeholder="Enter Your Comment" type="text" name="comments" class="input1" required>
                    </div>
                    <button id="login" type="submit">Submit Form</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
