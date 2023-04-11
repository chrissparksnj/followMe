<?php

require_once 'db_config.php';


$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


$sql = "SELECT * FROM follow_me_table";

$stmt = $conn->prepare($sql);

$stmt->execute();

$result = $stmt->get_result();




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
    
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
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mt-5">Stream</h1>
                    <?php 
                        while ($row = $result->fetch_assoc()){
    
                            echo "<a class='oval-bubble' href='profile.php?id=".$row['short_code']."'>" . $row['name'] .  "</a><br>";
                        }
                    ?>
            </div>
        </div>

    </div>
</body>
</html>