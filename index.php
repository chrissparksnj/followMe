<?php
require_once 'db_config.php';


$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method

    $name = $_POST["name"];
    $facebook = $_POST["facebook"];
    $twitter = $_POST["twitter"];
    $instagram = $_POST["instagram"];

    $unique_url = generateUniqueUrl($name);

    $sql = "INSERT INTO follow_me_table (name, unique_url, facebook, twitter, instagram) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $unique_url, $facebook, $twitter, $instagram);

    if ($stmt->execute()) {
        header("Location: profile.php?id=$unique_url");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
    }


function generateUniqueUrl($name) {
    return md5($name . time());
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form action="index.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>
        
        <label for="facebook">Facebook:</label>
        <input type="url" name="facebook" id="facebook"><br><br>

        <label for="twitter">Twitter:</label>
        <input type="url" name="twitter" id="twitter"><br><br>

        <label for="instagram">Instagram:</label>
        <input type="url" name="instagram" id="instagram"><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>