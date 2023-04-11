<?php



require_once 'db_config.php';

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$id = $_GET["id"];
$sql = "SELECT name, facebook, twitter, instagram FROM follow_me_table WHERE short_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $facebook = $row["facebook"];
    $twitter = $row["twitter"];
    $instagram = $row["instagram"];
} else {
    echo "No user found";
    exit;
}

$stmt->close();
$conn->close();

$full_link = "https://carcraze.co/followme/profile.php?id=" . $id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($name); ?>'s Profile</title>
    <!-- Add the Bootstrap CSS file -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mt-5"><small><a href='https://carcraze.co/followme/'>Follow Me</a></small></h1>
                <h1 class="text-center mt-5"><?php echo htmlspecialchars($name); ?>'s Profile</h1>
                <div class="mt-4">
                    <h4>Social Media Profiles</h4>
                    <ul class="list-unstyled">
                        <?php if (!empty($facebook)): ?>
                            <li>
                                <strong>Facebook:</strong> <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank"><?php echo htmlspecialchars($facebook); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($twitter)): ?>
                            <li>
                                <strong>Twitter:</strong> <a href="<?php echo htmlspecialchars($twitter); ?>" target="_blank"><?php echo htmlspecialchars($twitter); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($instagram)): ?>
                            <li>
                                <strong>Instagram:</strong> <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank"><?php echo htmlspecialchars($instagram); ?></a>
                            </li>
                        <?php endif; ?>
                        <li>
                        <b>Shareable Link:</b> <span id="content"><a href="<?php echo $full_link; ?>"><?php echo $full_link; ?></a></span>
                        <button class='mt-3 btn btn-primary btn-block' onclick="copyInnerHTML()">Copy Link</button>
                        

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Add the Bootstrap and jQuery JavaScript files -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>



    <script>
        async function copyInnerHTML() {
            var contentDiv = document.getElementById("content");
            var innerHTML = contentDiv.innerText;

            try {
                await navigator.clipboard.writeText(innerHTML);
                alert("Link copied");
            } catch (err) {
                console.error("Error copying inner HTML: ", err);
            }
        }
    </script>



