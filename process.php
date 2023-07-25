<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<?php
// データベースの接続情報
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop3";

// POSTデータを取得し、サニタイズ
$itemA = isset($_POST['itemA']) ? intval($_POST['itemA']) : 0;
$itemB = isset($_POST['itemB']) ? intval($_POST['itemB']) : 0;
$itemC = isset($_POST['itemC']) ? intval($_POST['itemC']) : 0;
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : '';
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
$zip01 = isset($_POST['zip01']) ? preg_replace('/[^0-9]/', '', $_POST['zip01']) : '';
$addr11 = isset($_POST['addr11']) ? htmlspecialchars($_POST['addr11'], ENT_QUOTES, 'UTF-8') : '';

// 入力値のバリデーション
if ($itemA < 0 || $itemB < 0 || $itemC < 0 || empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($zip01) !== 7 || empty($addr11)) {
    die("入力値が正しくありません。");
}

// 注文個数の合計を計算
$totalQuantity = $itemA + $itemB + $itemC;

// 商品1個あたりの価格（690円）と合計金額を計算
$unitPrice = 690;
$totalAmount = $totalQuantity * $unitPrice;

// 注文日を取得
$orderDate = date('Y-m-d');

// データベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラーの確認
if ($conn->connect_error) {
    die("データベース接続エラー: " . $conn->connect_error);
}

// SQLインジェクション対策のため、プリペアドステートメントを使用してデータをデータベースに保存
$stmt = $conn->prepare("INSERT INTO shop3 (itemA, itemB, itemC, total_amount, name, email, zip01, addr11, order_date) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("iiissssss", $itemA, $itemB, $itemC, $totalAmount, $name, $email, $zip01, $addr11, $orderDate);

if ($stmt->execute()) {
    echo "データベースに保存されました。";
} else {
    echo "エラー: " . $stmt->error;
}

// プリペアドステートメントを閉じる
$stmt->close();

// データベース接続を閉じる
$conn->close();
?>

</body>
</html>