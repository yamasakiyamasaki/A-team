<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("データベース接続エラー: " . $conn->connect_error);
}
?>
<?php
// テーブル名やカラム名が正確でない場合は適宜修正してください
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $inventoryData = array();
    while ($row = $result->fetch_assoc()) {
        $inventoryData[$row["item"]] = $row["stock"];
    }

    // JSON形式で在庫数を出力
    echo json_encode($inventoryData);
} else {
    echo "データがありません。";
}

$conn->close();
?>

<!-- 注文管理画面に在庫数を表示する -->