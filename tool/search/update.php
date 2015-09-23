<?php

// DBライブラリ読み込み
require('lib/db.php');

// 格納する引数受け取り
$title              = isset($_POST['title']) ? $_POST['title'] : NULL;
$detail             = isset($_POST['detail']) ? $_POST['detail'] : NULL;
$asin               = isset($_POST['asin']) ? $_POST['asin'] : NULL;
$medium_image_url   = isset($_POST['medium_image_url']) ? $_POST['medium_image_url'] : NULL;
$large_image_url    = isset($_POST['large_image_url']) ? $_POST['large_image_url'] : NULL;

// MySQL接続
$db = new Db();
$pdo = $db->connect();
if( !$pdo ){
    exit(1);
}

// UPDATE
$sqls = array(
    "UPDATE item SET
        title = '$title',
        detail = '$detail',
        medium_image_url = '$medium_image_url',
        large_image_url = '$large_image_url',
        create_time = NOW()
    WHERE asin = '$asin'",
    "UPDATE other SET
        title = '$title',
        detail = '$detail',
        medium_image_url = '$medium_image_url',
        large_image_url = '$large_image_url',
        create_time = NOW()
    WHERE asin = '$asin'"
);
$status = array();
foreach( $sqls as $sql ){
    $stmt = $pdo->prepare($sql);
    if( !$stmt ){
        error_log(var_export($pdo->errorInfo(),true));
        $status[] = false;
    }
    if( !$stmt->execute() ){
        $status[] = false;
    }else{
        $status[] = true;
    }
}
if( in_array(true, $status) ){
    error_log('mysql update success.');
    $results = 'データの更新に成功しました。';
}else{
    error_log('mysql update failed.');
    $results = 'データの更新に失敗しました。';
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
            <div class="search">
                <?php echo $results; ?><p>
                <a href="./list.php">編集へ</a>
            </div>
        </div>
        <?php include './footer.inc'; ?>
    </body>
</html>
