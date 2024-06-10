<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="utf8">
        <title>ワード検索１</title>
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
            @if($errors->any())
            <div class="alert alert-danger">
            @foreach($errors->all() as $message)
            {{ $message }}
            @endforeach
            </div>
            @endif

            <p>検索語句を入力してください。</p>

            <form action="{{ route('search.complete') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <table border="0" frame="box" rulues="none" border="black" height="120" width="600" align="center">
                    <tr style="text-align:center">
                        <td nowrap>検索語：</td>
                        <td><input type="text" name="keyword" rows="70"></td>
                        <td><input type="radio" name="andor" value="or" checked></td>
                        <td><small>OR</small></td>
                        <td><input type="radio" name="andor" value="and"></td>
                        <td><small>AND</small></td>
                    </tr>
                    <tr>    
                        <td colspan="5">
                            <input class="radio" type="submit" name="key" value="検索開始">
                            
                        </td>
                    </tr>
                </table>
            </form>


        </div>
    </body>

</html>