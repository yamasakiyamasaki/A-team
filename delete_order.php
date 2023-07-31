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

// POSTリクエストから注文IDを取得
if (isset($_POST["orderId"])) {
    $orderId = $_POST["orderId"];

    // 注文データを取得するクエリ
    $sql = "SELECT itemA, itemB, itemC FROM shop3 WHERE id = " . (int)$orderId;

    // クエリを実行して結果を取得
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $itemA_stock = $row["itemA"];
        $itemB_stock = $row["itemB"];
        $itemC_stock = $row["itemC"];

        // データベースから注文データを削除するクエリ
        $sql_delete = "DELETE FROM shop3 WHERE id = " . (int)$orderId;

        // クエリを実行
        if ($conn->query($sql_delete) === TRUE) {
            // 在庫テーブルにデータを戻す
            $sql_update = "UPDATE inventory SET stock = stock + $itemA_stock WHERE id = 1";
            $conn->query($sql_update);

            $sql_update = "UPDATE inventory SET stock = stock + $itemB_stock WHERE id = 2";
            $conn->query($sql_update);

            $sql_update = "UPDATE inventory SET stock = stock + $itemC_stock WHERE id = 3";
            $conn->query($sql_update);

            // 削除が成功したら、削除成功のレスポンスを返す
            echo "削除成功";
        } else {
            // 削除が失敗した場合は、削除失敗のレスポンスを返す
            echo "削除エラー: " . $conn->error;
        }
    } else {
        echo "注文IDが見つかりません。";
    }
}

// データベース接続を閉じる
$conn->close();
?>


<!-- 注文管理画面で削除したデータの表示を消す、データベースに数量を戻す -->
