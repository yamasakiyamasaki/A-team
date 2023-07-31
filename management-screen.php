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
    <script>
        function confirmDelete(orderId, orderName) {
            var result = confirm("IDナンバー " + orderId + " を削除してよろしいですか？");
            if (result) {
                // 「はい」を選択した場合はPHPに注文IDを送信して削除処理を実行
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_order.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                // 削除したアイテム数を設定
                var deletedItemCounts = {
                    itemA: 0, // このサンプルコードでは削除時の在庫数更新処理は省略しているので0を設定
                    itemB: 0,
                    itemC: 0
                };

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // 削除が成功したら、行をテーブルから削除
                            var row = document.getElementById("orderRow_" + orderId);
                            row.parentNode.removeChild(row);
                            // 在庫数を更新
                            updateInventory();
                        } else {
                            alert("削除エラーが発生しました。");
                        }
                    }
                };

                xhr.send("orderId=" + encodeURIComponent(orderId) + "&deletedItemCounts=" + JSON.stringify(deletedItemCounts));
            }
        }

        function updateInventory() {
            // 在庫数を取得して表示する処理
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_inventory.php", true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // レスポンスから在庫数を取得
                        var inventoryData = JSON.parse(xhr.responseText);
                        document.getElementById("itemA_stock").innerText = inventoryData.itemA;
                        document.getElementById("itemB_stock").innerText = inventoryData.itemB;
                        document.getElementById("itemC_stock").innerText = inventoryData.itemC;
                    } else {
                        alert("在庫数の取得エラーが発生しました。");
                    }
                }
            };

            xhr.send();
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

        // 在庫数の行を追加
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

    // データベース接続を
		// データベース接続を閉じる
	$conn->close();
	?>
</body>
</html>


<!-- 【注文管理画面】◎表示する -->
<!-- http://localhost/A-team/management-screen.php -->

