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
              <input type="number" min="0" name="itemB" class="" placeholder="Cの注文個数">個
              </div>   
            </div>
        </div>
        <section class="contact-form">
        <h2>お客様情報</h2>
            
        <div>
            <label for="name">お名前</label><br>
            <input type="text" id="name" name="name" autofocus required >
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
            <input type="submit" id="submit" value="送信" onclick="submitForm()">
            </div>
        </div>
    </form> 
                 
</body>
</html>