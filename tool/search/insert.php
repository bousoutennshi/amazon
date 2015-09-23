<?php

// DBライブラリ読み込み
require('lib/db.php');

// 格納する引数受け取り
$title              = isset($_POST['title']) ? $_POST['title'] : NULL;
$detail             = isset($_POST['detail']) ? $_POST['detail'] : NULL;
$detail_url         = isset($_POST['detail_url']) ? $_POST['detail_url'] : NULL;
$medium_image_url   = isset($_POST['medium_image_url']) ? $_POST['medium_image_url'] : NULL;
$large_image_url    = isset($_POST['large_image_url']) ? $_POST['large_image_url'] : NULL;
$insert_data = array(
    $title,
    $detail,
    $medium_image_url,
    $large_image_url,
    $detail_url
);

// MySQL接続
$db = new Db();
$pdo = $db->connect();
if( !$pdo ){
    exit(1);
}

// INSERT
$sql = "INSERT INTO other (
            title,
            detail,
            medium_image_url,
            large_image_url,
            detail_url,
            create_time,
            show_flag
        ) VALUES (
            ?,?,?,?,?,NOW(),'Y'
        )";
$stmt = $pdo->prepare($sql);
if( !$stmt ){
    error_log(var_export($pdo->errorInfo(),true));
    exit(1);
}
foreach( $insert_data as $index => $value ){
    $stmt->bindValue($index+1, $value);
    if( !$stmt ){
        error_log(var_export($pdo->errorInfo(),true));
        exit(1);
    }
}
if( !$stmt->execute() ){
    error_log('mysql insert failed.');
    $results = 'データベースの登録に失敗しました。';
}else{
    error_log('mysql insert success.');
    $results = 'データベースの登録に成功しました。';
}

// アクティブ
$nav_add = 'active';
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
