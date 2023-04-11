<?php

require_once 'db_config.php';


$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


$sql = "SELECT * FROM follow_me_table";

$stmt = $conn->prepare($sql);

$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()){
    
    echo "<a href='profile.php?id=".$row['short_code']."'>" . $row['name'] .  "</a><br>";
}