<?php
if( !isset($nav_add) ){
    $nav_add = '';
}
if( !isset($nav_submit) ){
    $nav_submit = '';
}
if( !isset($nav_list) ){
    $nav_list = '';
}
?>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./submit.php">Amazon入稿ツール</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="<?php echo $nav_add; ?>"><a href="./add.php">新規入稿</a></li>
                        <li class="<?php echo $nav_submit; ?>"><a href="./submit.php">Amazon入稿</a></li>
                        <li class="<?php echo $nav_list; ?>"><a href="./list.php">編集</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
