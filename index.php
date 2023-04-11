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
    $short_code = generateShortCode();

    $sql = "INSERT INTO follow_me_table (name, short_code, unique_url, facebook, twitter, instagram) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $short_code, $unique_url, $facebook, $twitter, $instagram);

    if ($stmt->execute()) {
        header("Location: profile.php?id=$short_code");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
    }


function generateUniqueUrl($name) {
    return md5($name . time());
}

function generateShortCode() {
    return substr(md5(uniqid(rand(), true)), 0, 8);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media App</title>
    <!-- Add the Bootstrap CSS file -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mt-5">Follow Me</h1>
                <p class='text-center'>Enter your links below to create a unique shareable link. </p>
                <form  action="index.php" method="post" class="mt-4">
                    <div id='form-inputs'>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="facebook">Facebook:</label>
                        <input type="text" name="facebook" id="facebook" class="form-control" placeholder="Facebook username">
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter:</label>
                        <input type="text" name="twitter" id="twitter" class="form-control" placeholder="Twitter username">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram:</label>
                        <input type="text" name="instagram" id="instagram" class="form-control" placeholder="Instagram username">
                    </div>
                    </div>
                    <button type="button" id="addInput" class="btn btn-primary mb-2">+</button>
                    <button type="submit" class="btn btn-primary btn-block">Generate URL</button>
                    <a href='stream.php' class='btn btn-success btn-block'>See Stream</a>
                    
                </form>
            </div>
        </div>
    </div>

<script>
   let inputCount = 0;

function addInputField() {
    inputCount++;
    const inputGroup = document.createElement('div');
    inputGroup.className = 'form-group';

    const label = document.createElement('label');
    label.htmlFor = 'input' + inputCount;
    label.textContent = 'Other:  ' + inputCount;

    const input = document.createElement('input');
    input.type = 'text';
    input.className = 'form-control';
    input.id = 'input' + inputCount;
    input.placeholder = "Other link"

    inputGroup.appendChild(label);
    inputGroup.appendChild(input);

    document.getElementById('form-inputs').appendChild(inputGroup);
}

document.getElementById('addInput').addEventListener('click', addInputField);

</script>
    
    <!-- Add the Bootstrap and jQuery JavaScript files -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

