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
    <div class="ahiru">
        <div>
        <img src="img/ahiruicon.png" alt="Image" style="width:150px;"0. >
        <p class="ahirutitle">アヒルショップ</p>
        </div> 
    </div>
    <div class="ahirugazou">
        <img src="img/ahirushark.png" class="ahirugazou">
        <img src="img/ahiruspiderman.png" class="ahirugazou">
        <img src="img/ahirustar.png" class="ahirugazou"> 
    </div>
    <p>価格690円</p>
    <form action="process.php" method="POST" id="form" onsubmit="return validateForm()">
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
                <input type="submit" id="submit" value="送信">
            </div>
        </section>
    </form> 
    
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
</body>
</html>
