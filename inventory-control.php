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
            echo '<td id="stock-' . $row["id"] . '">' . $row["stock"] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "データがありません。";
    }

    // アイテム一覧を取得するクエリ
    $sql_items = "SELECT item FROM inventory";

    // クエリを実行して結果を取得
    $result_items = $conn->query($sql_items);

    if ($result_items->num_rows > 0) {
        // 在庫追加フォームのHTMLを表示
        echo '
        <h2>在庫を追加する</h2>
        <form id="add-stock-form">
            <label for="item_name">アイテム名:</label>
            <select id="item_name" name="item_name" required>';
        
        while ($row = $result_items->fetch_assoc()) {
            echo '<option value="' . $row["item"] . '">' . $row["item"] . '</option>';
        }

        echo '
            </select><br>
            <label for="quantity">追加する在庫数:</label>
            <input type="number" id="quantity" name="quantity" required><br>
            <input type="button" value="追加" onclick="addStock()">
        </form>
        ';
    } else {
        echo "アイテムがありません。";
    }

    // データベース接続を閉じる
    $conn->close();
    ?>

    <script>
        // グローバルスコープでxhrを定義
        let xhr;

        function addStock() {
            const item = document.getElementById("item_name").value;
            const quantity = document.getElementById("quantity").value;
            xhr = new XMLHttpRequest();
            xhr.open("POST", "add-stock.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        const stockElement = document.getElementById("stock-" + response.id);
                        if (stockElement) {
                            stockElement.innerText = response.updatedStock;
                        }
                        alert("在庫が追加されました。");
                        updateStockDisplay();
                    } else {
                        alert("エラー: " + response.message);
                    }
                }
            };
            xhr.send("item_name=" + encodeURIComponent(item) + "&quantity=" + encodeURIComponent(quantity));
        }

        function updateStockDisplay() {
            const newXHR = new XMLHttpRequest();
            newXHR.open("GET", "get-stock.php", true);
            newXHR.onreadystatechange = function() {
                if (newXHR.readyState === 4 && newXHR.status === 200) {
                    const stocks = JSON.parse(newXHR.responseText);
                    for (const stock of stocks) {
                        const stockElement = document.getElementById("stock-" + stock.id);
                        if (stockElement) {
                            stockElement.innerText = stock.stock;
                        }
                    }
                }
            };
            newXHR.send();
        }

        // ページ読み込み時に在庫数を更新
        window.onload = function() {
            updateStockDisplay();
        };
    </script>
</body>
</html>