<?php
session_start();
include("functions.php");
check_session_id();

//DB接続
$pdo = connect_to_db();

//SQLで参照
$sql = 'SELECT * FROM item_table WHERE user_id=? AND is_deleted=0 ORDER BY created_at ASC';

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$status = $stmt->execute(); // SQLを実行 $statusに実行結果(取得したデータではない！)


// 失敗時にエラーを出力し，成功時は登録画面に戻る
if ($status == false) {
    $error = $stmt->errorInfo();  // データ登録失敗時にエラーを表示
    exit('sqlError:' . $error[2]);
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  //fetchAllで全部とれる
    $output = '';
    //繰り返し文（foreach以外）でもOK
    foreach ($result as $key => $record) {
        // var_dump($result);
        // exit;

        if ($key > 7) {
            $countz = ($key * 1) + 10;
            $countl = -90;
            $countx = 0;
        } else {
            $countz = -9;
            $countl = 0;
            $countx = ($key * -3) + 10;
        }

        $output .= "<a-image src='img/" . $record['image'] . "' width='2' position='$countx 4 $countz' rotation='0 $countl 0'></a-image>";
        // $output .= '<a-image src="img/' . $record["image"] . '" width="6" height="3" opacity="0.5" position="8 4 -8" rotation="0 -10 0"></a-image>';
        // $output .= '<a-image src="img/' . $record["image"] . '" width="2"position="6 4 -8" rotation="0 0 0"></a-image>';
        // $output .= '<a-image src="img/' . $record["image"] . '" width="2"position="4 4 -8" rotation="0 0 0"></a-image>';

    }

    // for ($record = 0; $record < 20; $record++) {
    // }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>こどもar</title>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <!-- <script src="https://cdn.rawgit.com/jeromeetienne/AR.js/1.5.0/aframe/build/aframe-ar.js"></script> -->
    <!-- <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar-nft.js"></script> -->

    <!-- 空のグラデーションのためのコンポーネント呼び出し -->
    <script src="https://unpkg.com/aframe-environment-component@1.0.0/dist/aframe-environment-component.min.js"></script>
</head>

<body>
    <a-scene>
        <a-camera cursor="rayOrigin: mouse;"></a-camera>

        <a-sky id="sky" radius="200" theta-length="110" material="shader:gradientshader;topColor:#005AA7;bottomColor:#FFFDE4" geometry="" visible="" id="sky" position=""></a-sky>
        <a-plane position="0 0 -4" rotation="-90 0 0" width="50" height="20" shadow></a-plane>
        <a-box position="0 0 -10 " rotation="0 0 0" width="50" height="20" src="https://cdn.glitch.com/866272cc-16b8-4de4-8382-6e667af3948b%2Fplane.jpeg?v=1623942772478"></a-box>
        <?= $output ?>
    </a-scene>
    <script>

    </script>

    <script>
        const item = <?= json_encode($result) ?>;
        console.log(item);
    </script>
</body>

</html>