<?php

// DBライブラリ読み込み
require('lib/db.php');

// 格納する引数受け取り
$insert_datas = array();
foreach( $_POST['item'] as $item ){
    $item = explode("",$item);
    $insert_datas[] = array(
        isset($item[0]) ? urldecode($item[0]) : NULL,
        isset($item[1]) ? urldecode($item[1]) : NULL,
        isset($item[2]) ? $item[2] : NULL,
        isset($item[3]) ? $item[3] : NULL,
        isset($item[4]) ? $item[4] : NULL,
        isset($item[5]) ? $item[5] : NULL,
        isset($item[6]) ? $item[6] : NULL,
        isset($item[7]) ? $item[7] : NULL,
    );
}

// MySQL接続
$db = new Db();
$pdo = $db->connect();
if( !$pdo ){
    exit(1);
}

// INSERT
foreach( $insert_datas as $insert_data ){
    $sql = "REPLACE INTO item (
                title,
                detail,
                medium_image_url,
                large_image_url,
                asin,
                tag,
                detail_url,
                create_time,
                show_flag
            ) VALUES (
                ?,?,?,?,?,?,?,NOW(),?
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
}

// アクティブ
$nav_submit = 'active';
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
