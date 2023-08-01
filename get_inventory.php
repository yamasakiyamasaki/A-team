<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $errorData = array("error" => "データベース接続エラー: " . $conn->connect_error);
    header('Content-Type: application/json');
    echo json_encode($errorData);
    exit;
}

$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $inventoryData = array();
    while ($row = $result->fetch_assoc()) {
        $inventoryData[$row["item"]] = $row["stock"];
    }

    header('Content-Type: application/json');
    echo json_encode($inventoryData);
} else {
    $noDataMessage = array("message" => "データがありません。");
    header('Content-Type: application/json');
    echo json_encode($noDataMessage);
}

$conn->close();
?>

