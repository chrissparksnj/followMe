<?php



require_once 'db_config.php';

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$id = $_GET["id"];
$sql = "SELECT name, facebook, twitter, instagram FROM follow_me_table WHERE unique_url = ?";
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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($name); ?>'s Profile</title>
    <script>
        function followAll() {
            <?php if ($facebook): ?>window.open('<?php echo htmlspecialchars($facebook); ?>', '_blank');<?php endif; ?>
            <?php if ($twitter): ?>window.open('<?php echo htmlspecialchars($twitter); ?>', '_blank');<?php endif; ?>
            <?php if ($instagram): ?>window.open('<?php echo htmlspecialchars($instagram); ?>', '_blank');<?php endif; ?>
        }
    </script>
</head>
<body>
    <h1><?php echo htmlspecialchars($name); ?>'s Profile</h1>
    <?php if ($facebook): ?><p><a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank">Facebook</a></p><?php endif; ?>
    <?php if ($twitter): ?><p><a href="<?php echo htmlspecialchars($twitter); ?>" target="_blank">Twitter</a></p><?php endif; ?>
    <?php if ($instagram): ?><p><a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank">Instagram</a></p><?php endif; ?>
    <button onclick="followAll()">Follow All</button>
</body>
</html>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v16.0&appId=557244249120978&autoLogAppEvents=1" nonce="7lA0EvzT"></script>