<?php
// アクティブ
$nav_add = 'active';
?>

<!DOCTYPE html>
<html lang="ja">
<?php include './header.inc'; ?>
    <body>
        <?php include './nav.inc'; ?>
        <div class="container">
            <div class="add">
                <form action="./insert.php" method="POST">
                    <div class="form-group">
                        <label for="title">タイトル</label>
                        <input type="text" class="form-control" name="title" placeholder="タイトル" />
                    </div>
                    <div class="form-group">
                        <label for="detail">内容</label>
                        <textarea class="form-control" rows="5" name="detail" placeholder="内容"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="detail_url">詳細URL</label>
                        <input type="url" class="form-control" name="detail_url" placeholder="詳細URL" />
                    </div>
                    <div class="form-group">
                        <label for="medium_image_url">サムネイル画像URL</label>
                        <input type="url" class="form-control" name="medium_image_url" placeholder="サムネイル画像URL" />
                    </div>
                    <div class="form-group">
                        <label for="medium_image_url">詳細画像URL</label>
                        <input type="url" class="form-control" name="large_image_url" placeholder="詳細画像URL" />
                    </div>
                    <div class="center">
                        <button type="submit" class="btn btn-default">入稿</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include './footer.inc'; ?>
    </body>
</html>
