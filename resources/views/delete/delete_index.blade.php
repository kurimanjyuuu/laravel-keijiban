<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="utf8">
        <title>削除読み込み</title>
    </head>

    <body>
        <div style="text-align:center">
            <h1>掲示板</h1>
            <a href="{{ route('boards.index') }}">一覧(新規投稿)</a>❘
            <a href="">ワード検索</a>❘
            <a href="">使い方</a>❘
            <a href="">携帯へURLを送る</a>❘
            <a href="">管理</a>
            <br>
            <p>編集/削除キーを入力し、［送信］して下さい。</p>
            <br>
            <form action="{{ route('delete.complete') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <table border="1" align="center">
                    <tr>
                        <td><input type="password" name="delete_key" value="" maxlength="8"></td>
                        <td><input class="button" type="submit" name="delete_index_blade" value="送信"></td>
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="delete_type" value="{{ $delete_type }}">
                        <?php var_dump($id);?>
                        <?php echo ($delete_type);?>               
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>