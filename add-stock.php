<?php
// データベースの接続情報
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

// POSTデータを取得し、サニタイズ
$item_name = isset($_POST['item_name']) ? $_POST['item_name'] : '';
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

// 入力値のバリデーション
if (empty($item_name) || $quantity <= 0) {
    http_response_code(400); // Bad Request
    $response = array('success' => false, 'message' => '無効な入力値です。');
    echo json_encode($response);
    exit;
}

// データベースに在庫を追加
$stmt = $conn->prepare("UPDATE inventory SET stock = stock + ? WHERE item = ?");
$stmt->bind_param("is", $quantity, $item_name);

if ($stmt->execute()) {
    // 在庫追加後の在庫数を取得
    $sql = "SELECT stock FROM inventory WHERE item = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $item_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $updatedStock = $row["stock"];

        // 成功時のレスポンスを準備
        $response = array('success' => true, 'id' => $item_name, 'updatedStock' => $updatedStock);
        echo json_encode($response);
    } else {
        // データが見つからない場合のエラーレスポンス
        http_response_code(404); // Not Found
        $response = array('success' => false, 'message' => 'アイテムが見つかりません。');
        echo json_encode($response);
    }
} else {
    // データベース更新失敗時のエラーレスポンス
    http_response_code(500); // Internal Server Error
    $response = array('success' => false, 'message' => 'データベースの更新に失敗しました。');
    echo json_encode($response);
}

// プリペアドステートメントを閉じる
$stmt->close();

// データベース接続を閉じる
$conn->close();
?>