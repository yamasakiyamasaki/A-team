function getData() {
  document.getElementById("Result").value = "問い合わせ中です…";
  var data = {
    "code": document.getElementById("Fruits").value
  }
  var json = JSON.stringify(data);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax.php");
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded;charset=UTF-8");
  xhr.send(json);
  xhr.onreadystatechange = function () {
    try {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          var result = JSON.parse(xhr.response);
          document.getElementById("Result").value = result.value == 0 ? "選択してください" : result.value;
        } else {
        }
      } else {
      }
    } catch (e) {
    }
  };
}