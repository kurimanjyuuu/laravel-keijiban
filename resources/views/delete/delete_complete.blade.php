<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="utf8">
        <title>完了</title>
    </head>

    <body>
        <div style="text-align:center">
            <h1>掲示板</h1>
            
                <a href="{{ route('boards.index') }}">ワード検索</a>❘
                <a href="">使い方</a>❘
                <a href="">携帯へURLを送る</a>❘
                <a href="">管理</a>
            
            
            <p><h2>削除完了!!</h2></p>



            <?php var_dump($id);?>
                        
            <?php echo ($delete_type);?> 

            <p><a href="{{ route('boards.index') }}">掲示板へ戻る</a></p>

        </div>
    </body>
</html>