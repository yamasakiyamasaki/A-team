<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Ajax動作サンプル</title>
    <script type="text/javascript" src="ajax.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="ue">
        <img src="img/ahiruicon.png" alt="Image" style="width:150px;"0. >
        <p class="headtext">アヒル隊長が自転車用パフホーンになって登場！
            <br>押すと音が鳴り、ヘルメットは着脱可能。
            <br>回るプロペラでお子様が喜ぶこと間違いなし！
            <br>貴方の愛車のお供にいかがでしょうか?
            <br>アヒル隊長のことをもっと知りたい方は<a href="https://www.pilot-toy.com/ahirutaicho/">コチラ</a>
        </p>
        <img src="img/ahiruicon.png" alt="Image" style="width:150px;"0. >
    </header>

    <div class="ahiru">
        <div>        
        <p class="ahirutitle">アヒルショップ</p>
        </div> 
    </div>
    <?php
    // データベースに接続する処理（例としてPDOを使用）
    $host = "localhost";
    $dbname = 'shop3';
    $username = 'root';
    $password = '';
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('データベースに接続できませんでした。' . $e->getMessage());
    }

    // 商品Aの在庫数をデータベースから取得するクエリ
    $itemA_query = "SELECT stock FROM inventory WHERE id = '1'";
    $itemA_result = $db->query($itemA_query);
    $itemA_stock = $itemA_result->fetchColumn();

    // 商品Bの在庫数をデータベースから取得するクエリ
    $itemB_query = "SELECT stock FROM inventory WHERE id = '2'";
    $itemB_result = $db->query($itemB_query);
    $itemB_stock = $itemB_result->fetchColumn();

    // 商品Cの在庫数をデータベースから取得するクエリ
    $itemC_query = "SELECT stock FROM inventory WHERE id = '3'";
    $itemC_result = $db->query($itemC_query);
    $itemC_stock = $itemC_result->fetchColumn();
    ?>

    <div class="ahirugazou">
        <img src="img/ahirushark.png" class="ahirugazou">
        <img src="img/ahiruspiderman.png" class="ahirugazou">
        <img src="img/ahirustar.png" class="ahirugazou">
    </div>

    <form action="process.php" method="POST" id="form" onsubmit="return validateForm()">
        <div class="order">
            <div class="ordernumber">
                <div>
                    <p>価格690円</p>
                    <input type="number" min="0" name="itemA" class="" placeholder="Aの注文個数">個
                </div>
                <div>
                    <p>価格690円</p>
                    <input type="number" min="0" name="itemB" class="" placeholder="Bの注文個数">個
                </div>   
                <div>
                    <p>価格690円</p>
                    <input type="number" min="0" name="itemC" class="" placeholder="Cの注文個数">個
                </div>   

    <p>価格690円</p>
    <form action="process.php" method="POST" id="form" onsubmit="return submitForm()">
        <div class="order">
            <div class="ordernumber">
                <div>
                    <?php
                    if ($itemA_stock > 0) {
                        echo '<input type="number" min="0" name="itemA" class="" placeholder="Aの注文個数">個 (在庫あり)';
                    } else {
                        echo 'Aの商品は在庫切れです。';
                    }
                    ?>
                </div>
                <div>
                    <?php
                    if ($itemB_stock > 0) {
                        echo '<input type="number" min="0" name="itemB" class="" placeholder="Bの注文個数">個 (在庫あり)';
                    } else {
                        echo 'Bの商品は在庫切れです。';
                    }
                    ?>
                </div>
                <div>
                    <?php
                    if ($itemC_stock > 0) {
                        echo '<input type="number" min="0" name="itemC" class="" placeholder="Cの注文個数">個 (在庫あり)';
                    } else {
                        echo 'Cの商品は在庫切れです。';
                    }
                    ?>
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
            <br> 
            <div>
                <input type="submit" id="submit" value="送信">
            </div>

        </section>
    </form> 
    <br>
    <script>
        function validateForm() {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var zip01 = document.getElementsByName('zip01')[0].value;
            var addr11 = document.getElementsByName('addr11')[0].value;

            if (name.trim() === '') {
                alert('お名前を入力してください。');
                return false;
            }

            if (!isValidEmail(email)) {
                alert('有効なメールアドレスを入力してください。');
                return false;
            }

            if (zip01.replace('-', '').length !== 7) {
                alert('有効な郵便番号を入力してください。');
                return false;
            }

            if (addr11.trim() === '') {
                alert('都道府県と住所を入力してください。');
                return false;
            }

            return true;
        }

        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>
     <script>
    function submitForm() {
        // フォーム送信前にクライアント側でフォームのバリデーションを行います
        if (!validateForm()) {
            return false;
        }

        // jQueryを使用してフォームデータをAJAXで送信します
        $.ajax({
            url: 'process.php', // PHP処理ファイルのURL
            type: 'POST',
            data: $('#form').serialize(), // フォームデータをシリアライズ
            dataType: 'json', // サーバーからのJSONレスポンスを期待
            success: function(data) {
                alert(data.message); // レスポンスのメッセージをアラートで表示
            },
            error: function(xhr, status, error) {
                alert('エラー: データベースへの保存に失敗しました。'); // リクエストに問題がある場合はエラーメッセージを表示
            }
        });

        // フォームの通常の送信を防ぎます
        return false;
    }
    </script>
<footer>
        <img src="img/ahiruicon.png" alt="Image" style="width:150px;"0. >
        <p class="headtext">お客様から数々のご好評をいただいております！
            <br>
            <br>・プロペラ、ヘルメット、音等ギミックがたくさんある
            <br>・子供が夢中になるので、安全に走行できる
            <br>・自転車に乗りたがるので、乗せるときのストレスが無くなる…等々           
        </p>
        <img src="img/ahiruicon.png" alt="Image" style="width:150px;"0. >
</footer>        
</body>
</html>
