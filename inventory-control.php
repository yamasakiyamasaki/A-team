<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在庫管理表</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>在庫管理表</h1>
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

    // 在庫データを取得するクエリ
    $sql = "SELECT * FROM inventory";

    // クエリを実行して結果を取得
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 結果をテーブル形式で表示
        echo '<table>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>アイテム</th>';
        echo '<th>在庫数</th>';
        echo '</tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td>' . $row["item"] . '</td>';
            echo '<td>' . $row["stock"] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "データがありません。";
    }

    // データベース接続を閉じる
    $conn->close();
    ?>

</body>
</html>

<!-- 【在庫管理表】◎表示する -->
<!-- http://localhost/A-team/inventory-control.php -->

