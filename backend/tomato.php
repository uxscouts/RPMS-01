<?php
// 1. Allow your React app (running on port 3000) to access this endpoint
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// 2. Connect to the database using your docker-compose environment variables
$host = getenv('DB_HOST') ?: 'mysql';
$db   = 'tomato'; // Your tomato database
$user = getenv('DB_USERNAME') ?: 'dev_user';
$pass = getenv('DB_PASSWORD') ?: 'dev_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
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
        echo json_encode(["error" => "Tomato with ID 11 not found"]);
    }

} catch (\PDOException $e) {
    // Return the database error if something goes wrong
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
}
