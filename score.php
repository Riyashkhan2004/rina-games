<?php
$host = 'localhost';
$db = 'game_scores';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT game_name, player_name, score, date_time FROM scores ORDER BY date_time DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['game_name']}</td>
                <td>{$row['player_name']}</td>
                <td>{$row['score']}</td>
                <td>{$row['date_time']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No scores found.</td></tr>";
}

$conn->close();
?>
