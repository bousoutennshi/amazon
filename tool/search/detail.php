<?php

// DBライブラリ読み込み
require('lib/db.php');

// エラー変数
$error_stg = null;

// 引数受け取り
$asin = isset($_POST['asin']) ? $_POST['asin'] : NULL;

// MySQL接続
$db = new Db();
$pdo = $db->connect();
if( !$pdo ){
    $error_stg = 'データベース接続失敗。'.$e->getMessage();
}

// SQL文作成
$sql = "(SELECT * FROM item WHERE asin = '$asin') UNION ALL (SELECT * FROM other WHERE asin = '$asin')";

// データ取得
$stmt = $pdo->prepare($sql);
if( !$stmt ){
    error_log(var_export($pdo->errorInfo(),true));
    $error_stg = var_export($pdo->errorInfo(),true);
}
if( !$stmt->execute() ){
    error_log('mysql select failed.');
    $error_stg = 'データの取得に失敗しました。';
}else{
    error_log('mysql select success.');
    $error_stg = 'データの取得に成功しました。';
}

// データ挿入
$detail = array();
while( $row = $stmt -> fetch(PDO::FETCH_ASSOC) ){
    $detail['title']            = $row['title'];
    $detail['asin']             = $row['asin'];
    $detail['detail']           = $row['detail'];
    $detail['medium_image_url'] = $row['medium_image_url'];
    $detail['large_image_url']  = $row['large_image_url'];
}

// アクティブ
$nav_list = 'active';
?>

<!DOCTYPE html>
<html lang="ja">
    <?php include './header.inc'; ?>
    <body>
        <?php include './nav.inc'; ?>
        <div class="container">
            <div class="detail">
                <form action="./update.php" method="POST">
                    <div class="form-group">
                        <label for="asin">ASIN</label>
                        <input type="text" class="form-control" name="asin" value="<?php echo $detail['asin']; ?>" disabled />
                        <input type="hidden" name="asin" value="<?php echo $detail['asin']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="title">タイトル</label>
                        <input type="text" class="form-control" name="title" value="<?php echo $detail['title']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="detail">内容</label>
                        <textarea class="form-control" rows="5" name="detail"><?php echo $detail['detail']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="medium_image_url">サムネイル画像URL</label>
                        <input type="url" class="form-control" name="medium_image_url" value="<?php echo $detail['medium_image_url']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="medium_image_url">詳細画像URL</label>
                        <input type="url" class="form-control" name="large_image_url" value="<?php echo $detail['large_image_url']; ?>" />
                    </div>
                    <div class="center">
                        <button type="submit" class="btn btn-default">更新</button>
                    </div>
                <form>
            </div>
        </div>
        <?php include './footer.inc'; ?>
    </body>
</html>
