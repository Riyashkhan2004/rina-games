<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$host = 'localhost';
$db = 'game_scores'; // Change to your database name
$user = 'root'; // Default user
$pass = ''; // Default password (leave blank)

$conn = new mysqli($host, $user, $pass, $db);
$data = [
    'gameName' => 'Test Game',
    'playerName' => 'Test Player',
    'score' => 100,
    'dateTime' => date('Y-m-d H:i:s')
];


if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => $conn->connect_error]));
}

$stmt = $conn->prepare("INSERT INTO scores (game_name, player_name, score, date_time) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $data['gameName'], $data['playerName'], $data['score'], $data['dateTime']);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
