<?php
// Amazon共通の定数
define('AF',    'aiclcl0c-22');                                 // トラッキング
define('AC',    '');                        // アクセスキー
define('SEC',   '');    // シークレットキー
define('URL',   'http://ecs.amazonaws.jp/onca/xml');            // リクエスト先のURL

// 引数取得
$itemSearchWord = isset($_GET['item']) ? $_GET['item'] : '';

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
                <p class="mb5">Amazon商品検索</p>
                <form action="./submit.php" method="get" class="form-inline">
                    <input type="text" class="form-control" placeholder="検索ワード" name="item" size="40" value="<?php echo $itemSearchWord; ?>">
                    <input type="submit" class="btn btn-default" value="検索">
                </form>
            </div>
            <div class="submit">
<?php
if( isset($itemSearchWord) && !empty($itemSearchWord) ){
echo <<< EOF
<form action="./post.php" method="POST" name="iform">
<div class="center">
<button type="submit" class="btn btn-primary">登録</button>
</div>
<label><input type="checkbox" name="allchecked" onClick="AllChecked()" /> 全選択</label>
<div class="row">
<div class="col-md-12">
EOF;
    for( $i = 1; $i < 6; $i++ ){
        output_items($itemSearchWord,$i);
    }
echo <<< EOF
</div>
</div>
<div class="center">
<button type="submit" class="btn btn-primary">登録</button>
</div>
<p>
</form>
EOF;
}
?>
            </div>
        </div><!-- /.container -->
        <?php include './footer.inc'; ?>
        <script language="JavaScript" type="text/javascript">
            function AllChecked(){
                var check =  document.forms['iform'].elements['allchecked'].checked;
                for( var i = 0; i < document.forms['iform'].elements['item[]'].length; i++ ){
                    document.forms['iform'].elements['item[]'][i].checked = check;
                }
            }
        </script>
    </body>
</html>

<?php
function urlencode_rfc3986($str) {
    return str_replace('%7E', '~', rawurlencode($str));
}

// URL取得
function get_url($param){
    ksort($param);
    $canonical_string = '';
    foreach ($param as $k => $v) {
        $canonical_string .= '&'.urlencode_rfc3986($k).'='.urlencode_rfc3986($v);
    }
    $canonical_string = substr($canonical_string, 1);
    $parsed_url = parse_url(URL);
    $string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
    $signature = base64_encode(hash_hmac('sha256', $string_to_sign, SEC, true));

    // 返り値のURLにアクセスするとXMLが取得できます。
    return URL.'?'.$canonical_string.'&Signature='.urlencode_rfc3986($signature);
}

// param取得
function get_param($itemSearchWord,$page){
    $param = array(
        'Service'           => 'AWSECommerceService',
        'AWSAccessKeyId'    => AC,
        'Operation'         => 'ItemSearch',
        'AssociateTag'      => AF,
        'ResponseGroup'     => 'Medium',
        'SearchIndex'       => 'All',
        'Keywords'          => $itemSearchWord,
        'Timestamp'         => gmdate('Y-m-d\TH:i:s\Z'),
        'ItemPage'          => $page
    );

    return $param;
}

// アイテム表示
function output_items($itemSearchWord,$page){
    $url = get_url(get_param($itemSearchWord,$page));
    $xml = @simplexml_load_file($url);
    if( !empty($xml->Items->Item) ){
        $index = 0;
        foreach($xml->Items->Item as $Item){
            if( empty($Item->ASIN) ){
                continue;
            }
            $img = (string)$Item->MediumImage->URL;
            $title = (string)$Item->ItemAttributes->Title;
            $content = isset($Item->EditorialReviews->EditorialReview->Content) ? (string)$Item->EditorialReviews->EditorialReview->Content : null;
            $link = (string)$Item->DetailPageURL;
            $asin = (string)$Item->ASIN;
            $ean = (string)$Item->ItemAttributes->EAN;
            $large = (string)$Item->LargeImage->URL;
            $item = array(
                urlencode($title),
                urlencode($content),
                $img,
                $large,
                $asin,
                NULL,
                $link,
                'Y'
            );
            $item = join("",$item);
            $html = <<< EOM
<div class="col-md-4">
<div class="thumbnail">
<a href="{$link}" target="_blank"><img src="{$img}" alt="test"></a>
<div class="caption">
<h4>{$title}</h4>
<div style="text-align: center;">
<div class="checkbox">
<label>
<input type="checkbox" class="hoge" name="item[]" value="{$item}">選択
</label>
</div>
</div>
</div>
</div>
</div>
EOM;
            echo $html;
            $index++;
        }
    }else{
        echo "データが取得出来ませんでした。";
    }
}

function dump($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}
?>
