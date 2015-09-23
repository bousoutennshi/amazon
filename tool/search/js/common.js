function itemDelete(asin){
    var ret = confirm('削除しますか？');
    if( ret == true ){
        $.ajax({
            type: "POST",
            url: "./delete.php",
            data: {
                "asin": asin
            },
            success: function(data){
                if( data.status === 'OK' ){
                    location.reload(false);
                }else{
                    alert('削除に失敗しました。');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert('削除に失敗しました。');
            }
        });
    }
}
