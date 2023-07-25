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
			echo '<tr>';
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
			echo '<td><button onclick="moveToDeleted(this)">削除</button></td>';
			echo '</tr>';
		}

		echo '</table>';
	} else {
		echo "データがありません。";
	}

	// データベース接続を閉じる
	$conn->close();
	?>

	<h1>削除データ</h1>
	<table id="deleted-table">
		<tr>
			<th>ID</th>
			<th>注文日時</th>
			<th>アイテムA</th>
			<th>アイテムB</th>
			<th>アイテムC</th>
			<th>合計金額</th>
			<th>名前</th>
			<th>メールアドレス</th>
			<th>郵便番号</th>
			<th>住所</th>
			<th>削除</th>
		</tr>
	</table>

	<script>
		function moveToDeleted(button) {
			// 削除対象の行を取得
			var row = button.parentNode.parentNode;

			// 削除対象の行を削除データのテーブルに追加
			document.getElementById("deleted-table").appendChild(row);

			// 削除ボタンを無効化
			button.disabled = true;
		}
	</script>
</body>
</html>
