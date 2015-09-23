<?php

// DBライブラリ読み込み
require('lib/db.php');

// JSON出力
header("Content-Type: application/json; charset=utf-8");

// 格納する引数受け取り
$string = file_get_contents('php://input');
parse_str($string,$params);

// MySQL接続
$db = new Db();
$pdo = $db->connect();
if( !$pdo ){
    echo '{"status":"NG"}';
}

// UPDATE
$sqls = array(
    "UPDATE item SET show_flag = 'N' WHERE asin = '{$params['asin']}'",
    "UPDATE other SET show_flag = 'N' WHERE asin = '{$params['asin']}'"
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
    echo '{"status":"OK"}';
}else{
    error_log('mysql update failed.');
    echo '{"status":"NG"}';
}
?>
