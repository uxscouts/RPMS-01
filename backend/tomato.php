<?php
// 1. Allow your React app (running on port 3000) to access this endpoint
header("Access-Control-Allow-Origin: *"); // this is way unsecure,* should be your domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// 2. Allow credentials to be sent securely along with the Authorization header
header("Access-Control-Allow-Credentials: true");

// 3. Instantly kill preflight OPTIONS requests so they don't run your main code
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // 204 No Content is ideal for preflight
    exit();
}

// 2. Connect to the database using your docker-compose environment variables
$host = getenv('DB_HOST') ?: 'mysql';
$db   = getenv('DB_DATABASE') ?: 'my_database';
$user = getenv('DB_USERNAME') ?: 'dev_user';
$pass = getenv('DB_PASSWORD') ?: 'dev_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$fallbackTomato = [
    'id' => 3692,
    'userid' => 1001,
    'title' => 'wash dishes',
    'tomdate' => '2025-06-09',
    'datestring' => '2025-06-09',
    'timestamp' => '1749441600',
    'weekdayno' => 1,
    'tomweek' => '2025-W24',
    'count' => 4,
    'category' => 6,
    'notes' => "wash dishes clean room\r\n        \r\n        ",
    'URL' => null,
    'nowstamp' => '2025-06-09 18:29:00',
    'fallback' => true,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // 3. Execute your exact query
    // $stmt = $pdo->prepare("SELECT * FROM tomato WHERE id = 11");
    $stmt = $pdo->prepare("SELECT * FROM tomato ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $tomatoData = $stmt->fetch();

    // 4. Send the data back to React as JSON
    if ($tomatoData) {
        echo json_encode($tomatoData);
    } else {
        echo json_encode($fallbackTomato);
    }

} catch (\PDOException $e) {
    // Return a usable fallback payload if the database is temporarily unavailable
    http_response_code(200);
    echo json_encode($fallbackTomato);
}
