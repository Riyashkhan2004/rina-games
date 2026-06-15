<?php
header('Content-Type: application/json');

$servername = "localhost"; // your database host
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "search"; // your database name
<?php
header('Content-Type: application/json');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $_GET['query'];
$stmt = $conn->prepare("SELECT name, link FROM games WHERE name LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("s", $query);
$stmt->execute();
$result = $stmt->get_result();

$games = [];
while ($row = $result->fetch_assoc()) {
    $games[] = $row; // Include link in the result
}

$stmt->close();
$conn->close();

echo json_encode($games);
?>

