<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="utf8">
        <title>編集</title>
    </head>

    <body>
        <div style="text-align:center">
            <h1>掲示板</h1>
            <a href="{{ route('boards.index') }}">一覧(新規投稿)</a>❘
            <a href="{{ route('search.index') }}">ワード検索</a>❘
            <a href="">使い方</a>❘
            <a href="">携帯へURLを送る</a>❘
            <a href="">管理</a>
            <br>
            <p>編集/削除キーを入力し、［送信］して下さい。</p>
            <br>
            <form action="{{ route('edit.index') }}" method="GET" enctype="multipart/form-data">
            @csrf
                <table border="1" align="center">
                    <td><input type="password" name="delete_key" value="" maxlength="8"></td>
                        <td><input class="button" type="submit" name="" value="送信"></td>
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="edit_type" value="{{ $edit_type }}">
                        <input type="hidden" name="board_id"  value="{{ $board_id }}">
                        <?php
                        var_dump($id);
                        var_dump($board_id);
                        echo $edit_type;
                        ?>
                </table>
            </form>
        </div>
    </body>
</html>