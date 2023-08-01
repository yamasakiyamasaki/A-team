<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文管理画面</title>
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
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ?>
    <script>
        function confirmDelete(orderId, orderName) {
            // 既存のconfirmDelete関数のコードをここに記述
            // ...
            var result = confirm("IDナンバー " + orderId + " を削除してよろしいですか？");
            if (result) {
                // 「はい」を選択した場合はPHPに注文IDを送信して削除処理を実行
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_order.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // 削除が成功したら、行をテーブルから削除
                            var row = document.getElementById("orderRow_" + orderId);
                            row.parentNode.removeChild(row);
                            // 在庫数を更新する
                            updateInventoryTable();
                        } else {
                            alert("削除エラーが発生しました。");
                        }
                    }
                };

                xhr.send("orderId=" + encodeURIComponent(orderId));
            }
        
        }

        // 新たに在庫数を取得して表示する関数
        function updateInventoryTable() {
            // AJAXを使ってget_inventory.phpから在庫データを取得
            fetch('get_inventory.php')
                .then(response => response.json())
                .then(data => {
                    // 在庫情報をテーブルのセルに更新
                    document.getElementById('itemA_stock').innerText = data['itemA'] || '';
                    document.getElementById('itemB_stock').innerText = data['itemB'] || '';
                    document.getElementById('itemC_stock').innerText = data['itemC'] || '';
                })
                .catch(error => {
                    console.error('在庫データの取得エラー:', error);
                });
        }

        // updateInventory関数を修正して、在庫数を更新するためにupdateInventoryTable関数を呼び出す
        function updateInventory() {
            // 既存のupdateInventory関数のコードをここに記述
            // ...

            // 在庫数を更新するためにupdateInventoryTable関数を呼び出す
            updateInventoryTable();
        }

        // ページ読み込み時に在庫数を更新する
        window.onload = function() {
            updateInventory();
        };

    </script>
</head>
<body>
    <h1>注文管理画面</h1>
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

    // 注文データを取得するクエリ
    $sql = "SELECT id, order_date, itemA, itemB, itemC, total_amount, name, email, zip01, addr11 FROM shop3";

    // クエリを実行して結果を取得
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 結果をテーブル形式で表示
        echo '<table>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>注文日時</th>';
        echo '<th>アイテムA</th>';
        echo '<th>アイテムB</th>';
        echo '<th>アイテムC</th>';
        echo '<th>合計金額</th>';
        echo '<th>名前</th>';
        echo '<th>メールアドレス</th>';
        echo '<th>郵便番号</th>';
        echo '<th>住所</th>';
        echo '<th>削除</th>';
        echo '</tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr id="orderRow_' . $row["id"] . '">';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td>' . $row["order_date"] . '</td>';
            echo '<td>' . $row["itemA"] . '</td>';
            echo '<td>' . $row["itemB"] . '</td>';
            echo '<td>' . $row["itemC"] . '</td>';
            echo '<td>' . $row["total_amount"] . '</td>';
            echo '<td>' . $row["name"] . '</td>';
            echo '<td>' . $row["email"] . '</td>';
            echo '<td>' . $row["zip01"] . '</td>';
            echo '<td>' . $row["addr11"] . '</td>';
            echo '<td><button onclick="confirmDelete(' . $row["id"] . ', \'' . $row["name"] . '\')">削除</button></td>';
            echo '</tr>';
        }

        echo '<tr>';
        echo '<td></td>';
        echo '<th>在庫数</th>';
        echo '<th id="itemA_stock"></th>';
        echo '<th id="itemB_stock"></th>';
        echo '<th id="itemC_stock"></th>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '</tr>';

        echo '</table>';
    } else {
        echo "データがありません。";
    }

    // データベース接続を閉じる
    $conn->close();
    ?>
</body>
</html>
