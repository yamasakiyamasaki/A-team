<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Ajax動作サンプル</title>
    <script type="text/javascript" src="ajax.js"></script>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>
     <p>690円</p>
    <form action="process.php" method="POST" id="form">
        <div class="order">
            <div class="ordernumber">
              <div>
              <input type="number" min="0" name="itemA" class="" placeholder="Aの注文個数">個
              </div>
              <div>
              <input type="number" min="0" name="itemB" class="" placeholder="Bの注文個数">個
              </div>   
              <div>
              <input type="number" min="0" name="itemC" class="" placeholder="Cの注文個数">個
              </div>   
            </div>
        </div>
        <section class="contact-form">
        <h2>お客様情報</h2>
            
        <div>
        <label for="name">お名前</label><br>
            <input type="text" id="name" name="name" autofocus required>
            </div>
            <div>
            <label for="email">メールアドレス</label><br>
            <input type="email" id="email" name="email" placeholder="fullofdreams@inbothhands.com" required>
            </div>
            <div>
            <label>郵便番号(ハイフンもOK)</label><br>
            <input type="text" name="zip01" maxlength="8" placeholder="1234567" onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11');">
            </div>
            <div> 
            <label>都道府県と以降の住所</label><br>
            <input type="text" name="addr11" placeholder="大阪府大阪市・・・" style="width:260px">
            </div> 
            <div>
            <input type="submit" id="submit" value="送信" onclick="showSubmitAlert()">

            </div>
        </div>
    </form> 
    <h1>在庫一覧</h1>

    <!-- 在庫情報を表示するためのテーブル -->
    <table border="1">
        <tr>
            <th>商品名</th>
            <th>在庫数</th>
        </tr>
        <?php
        // get_inventory.phpから在庫情報を取得する
        $inventoryData = json_decode(@file_get_contents("http://localhost/A-team/get_inventory.php"), true);

        // 在庫情報をテーブルに表示する
        if ($inventoryData !== null) {
            $items = array("itemA", "itemB", "itemC");
            foreach ($items as $item) {
                echo "<tr>";
                echo "<td>{$item}</td>";
                echo "<td>{$inventoryData[$item]}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>在庫情報が取得できませんでした。</td></tr>";
        }
        ?>
    </table>
              
    
</body>
</html>

<!-- 【トップページ】◎表示する -->
<!-- http://localhost/A-team/index.php -->
