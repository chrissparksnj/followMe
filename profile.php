<?php



require_once 'db_config.php';

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$id = $_GET["id"];
$sql = "SELECT * FROM follow_me_table WHERE short_code = ?";
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
    $linkedin = $row['linkedin'];
    $tiktok = $row['tiktok'];
} else {
    echo "No user found";
    exit;
}

if (!isset($_COOKIE['viewed'])) {
    // Increment the view count in the database
    $sql = "UPDATE follow_me_table SET views = views + 1 where short_code = ?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("s", $id);
    $stmt2->execute();
    $stmt2->close();
    // Set the cookie for a specified duration (e.g., 1 day)
    setcookie('viewed', 'true', time() + 86400);
}





$sql = "SELECT views FROM follow_me_table WHERE short_code = ?";
$stmt3 = $conn->prepare($sql);
$stmt3->bind_param("s", $id);
$stmt3->execute();

$result = $stmt3->get_result();
$row = $result->fetch_assoc();
$views = $row['views'];

$stmt3->close();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

</head>

<style>
        .oval-bubble {
            margin-top: 20px;
            display: inline-block;
            border: 5px solid #007bff;
            background-color: #ADD8E6;
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
            line-height: 1.5;
            min-width: 100%;
        }
        .oval-bubble a {
            color: white;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mt-5"><small><a href='https://carcraze.co/followme/'>Follow Me</a></small></h1>
                <h1 class="text-center"><?php echo htmlspecialchars($name); ?>'s Profile</h1>
                <h3 class="text-center"><span class='badge badge-secondary'>Views: <?php echo $views; ?></span></h3>
                <div class="mt-4">
                
                    <ul class="list-unstyled">
                        
                        <?php if (!empty($facebook)): ?>
                            <div class='oval-bubble'>
                            <li>
                                <strong><i class="bi bi-facebook"> </i></strong> <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank"><?php echo htmlspecialchars($facebook); ?></a>
                            </li>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($twitter)): ?>
                            <div class='oval-bubble'>
                            <li>
                                <strong><i class="bi bi-twitter"> </i></strong> <a href="<?php echo htmlspecialchars($twitter); ?>" target="_blank"><?php echo htmlspecialchars($twitter); ?></a>
                            </li>
                            </div>
                        <?php endif; ?>
                        

                        
                        <?php if (!empty($instagram)): ?>
                            <div class='oval-bubble'>
                            <li>
                                <strong><i class="bi bi-instagram"></i> </strong> <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank"><?php echo htmlspecialchars($instagram); ?></a>
                            </li>
                            </div>
                        <?php endif; ?>
                        

                        
                        
                        <?php if (!empty($linkedin)): ?>
                            <div class='oval-bubble'>
                            <li>
                                <strong><i class="bi bi-linkedin"></i>  </strong> <a href="<?php echo htmlspecialchars($linkedin); ?>" target="_blank"><?php echo htmlspecialchars($linkedin); ?></a>
                            </li>
                            </div>
                        <?php endif; ?>
                        
                        
                        
                        
                        <?php if (!empty($tiktok)): ?>
                            <div class='oval-bubble'>
                            <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
  <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/>
</svg>
                                <strong><i class="bi bi-tiktok"></i></strong> <a href="<?php echo htmlspecialchars($tiktok); ?>" target="_blank"><?php echo htmlspecialchars($tiktok); ?></a>
                            </li>
                            </div>
                        <?php endif; ?>
                        

                        
                        
                        <div class='mt-5'>
                        <b>Shareable Link:</b> <span id="content"><a href="<?php echo $full_link; ?>"><?php echo $full_link; ?></a></span>
                        </div>
                        
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



