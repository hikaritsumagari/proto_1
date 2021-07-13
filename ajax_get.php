<?php
// 関数読み込み
session_start();
include("functions.php");
check_session_id();
//コンソールのネットワークで確認する
// var_dump($_GET);
// exit();

$years_select = $_GET["years_select"]; // GETでデータ受け取り


// var_dump($_SESSION['user_id']);
// exit();

// db連携
$pdo = connect_to_db();
$sql = "SELECT * FROM item_table WHERE exif_year LIKE $years_select AND user_id=?";

$stmt = $pdo->prepare($sql);
// $stmt->bindValue(':years_select', $years_select, PDO::PARAM_STR);
// $stmt->execute([$_SESSION['user_id']]);
$status = $stmt->execute([$_SESSION['user_id']]);

// var_dump($status);
// exit();

// $sql = "SELECT * FROM item_table WHERE user_id=? ";
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':years_select', $years_select, PDO::PARAM_STR);
// $stmt->execute([$_SESSION['user_id']]);
// $status = $stmt->execute();

// var_dump($status);
// exit();


if ($status == false) {
    // エラー処理をかく
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output = '';
    //繰り返し文（foreach以外）でもOK
    foreach ($result as $record) {
        // var_dump($result);
        // exit;
        $output .= '<li>';
        $output .= '<img src="' . $record["item_img"] . '">';
        $output .= '<h2>' . $record["title"] . '</h2>';
        $output .= '<p>' . $record["description"] . '</p>';
        $output .= '</li>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>こども美術館</title>
    <!-- Bootstrapの読み込み -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> -->


    <link href="style.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="nav_wrap">
            <h3>こども作品</h3>
            <a href="file_upform.php" class="btn"><i class="far fa-plus-square fa-lg"></i></a>
            <a href="child.php" class="btn">お子さま情報</a>
            <a href="ar_view.php" class="btn"><i class="fas fa-landmark fa-lg"></i></a>
            <a href="logout.php" class="btn">ログアウト</a>
        </div>
        <nav class="scroll-nav">
            <div class="scroll-nav__view">
                <form method='get' action="ajax_get.php">
                    <ul class="scroll-nav__list">
                        <li class="scroll-nav__item"><input type="submit" value="2021" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2020" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                        <li class="scroll-nav__item"><input type="submit" value="2019" name="years_select"></li>
                    </ul>
                </form>
            </div>
        </nav>
    </header>



    <main>

        <ul>
            <!-- ここに<li>でphpデータが入る -->
            <?= $output ?>
        </ul>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/b28496ef11.js" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</body>

</html>