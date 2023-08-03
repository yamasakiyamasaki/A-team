<?php
// get-stock.php

// データベースの接続情報（同じものを使用）
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop3";

// データベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラーの確認
if ($conn->connect_error) {
    die("データベース接続エラー: " . $conn->connect_error);
}

// 在庫データを取得するクエリ
$sql = "SELECT * FROM inventory";

// クエリを実行して結果を取得
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 結果を配列として格納
    $stocks = array();
    while ($row = $result->fetch_assoc()) {
        $stocks[] = array(
            'id' => $row["id"],
            'stock' => $row["stock"]
        );
    }

    // JSON形式でレスポンスを返す
    header('Content-Type: application/json');
    echo json_encode($stocks);
} else {
    // データがない場合は空の配列を返す
    header('Content-Type: application/json');
    echo json_encode(array());
}

// データベース接続を閉じる
$conn->close();
?>