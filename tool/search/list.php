<?php

// DBライブラリ読み込み
require('lib/db.php');

// エラー文言定義
$error_stg = null;

// MySQL接続
$db = new Db();
$pdo = $db->connect();
if( !$pdo ){
    $error_stg = 'データベース接続失敗。'.$e->getMessage();
}

// SQL文作成
$sql = "(SELECT * FROM item WHERE show_flag = 'Y') UNION ALL (SELECT * FROM other WHERE show_flag = 'Y') ORDER BY create_time DESC";

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

// アクティブ
$nav_list = 'active';
?>

<!DOCTYPE html>
<html lang="ja">
    <?php include './header.inc'; ?>
    <body>
        <?php include './nav.inc'; ?>
        <div class="container">
            <div class="edit">
                <table class="table table-hover table-striped">
                    <tr>
                        <th>ASIN</th>
                        <th>画像</th>
                        <th>タイトル</th>
                        <th>操作</th>
                    </tr>
<?php
while( $row = $stmt -> fetch(PDO::FETCH_ASSOC) ){
    $html = <<< EOF
<tr>
<td>{$row['asin']}</td>
<td><img src="{$row['medium_image_url']}"></td>
<td><a href="{$row['detail_url']}">{$row['title']}</a></td>
<td>
<form action="./detail.php" method="POST">
<input type="hidden" name="asin" value="{$row['asin']}">
<button type="submit" class="btn btn-primary">編集</button>
</form>
<br><br>
<button type="button" class="btn btn-danger" onClick="itemDelete('{$row['asin']}')">削除</button>
</td>
</tr>
EOF;
    echo $html;
}
?>
                </table>
            </div>
        </div>
        <?php include './footer.inc'; ?>
    </body>
</html>
