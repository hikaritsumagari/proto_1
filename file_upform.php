<?php
session_start();
include("functions.php");
check_session_id();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>作品登録</title>
</head>

<body>
  <!-- POSTで送る、fileを送るときはenctypeは必ず必要！ -->
  <form action="file_upload.php" method="POST" enctype="multipart/form-data">
    <div>
      <!-- acceptでどんなファイルか指定/*で拡張子限らず全部の意味  caputure=でスマホカメラ起動できる -->
      <input type="file" multiple name="upfile" accept="image/*" capture="environment">
    </div>
    <div class="formItem">
      <label>
        作品名<br> <input type="text" name="title" placeholder="作品名" autocomplete=”off”>
      </label>
    </div>
    <div class="formItem">
      <label>説明<br>
        <textarea name="description" rows="4" cols="40" id="result_text" placeholder="説明"></textarea>
      </label>

      <div>
        <button class="btn">登録</button>
      </div>
  </form>


  <script src="https://kit.fontawesome.com/b28496ef11.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>