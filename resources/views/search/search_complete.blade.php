<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="utf8">
        <title>ワード検索2</title>
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

            <form class="inline_button" action="{{ route('search.complete') }}" method="POST" enctype="multipart/form-data">
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
                    <th>    
                        <td style="text-align:center">
                            <input class="radio" type="submit" name="key" value="検索開始">
                        </td>
                    </th>
                </table> 

                @foreach($boards as $board)
                <div style="margin-top:20px;">
                    <tr style="text-align:center">
                        <table border="0" frame="box" rulues="none" border="black" width="600" align="center">
                            <tr>
                                <td>
                                    <div style="text-align:left">
                                        名前:{{ $board->name }} -
                                        件名:{{ $board->subject }} -
                                        URL:{{ $board->url }}<br>
                                        メッセージ:
                                        <br>
                                        <span style="color:{{ $board->text_color }}">{!! nl2br($board->message) !!}</span>
                                        <br>
                                        画像:
                                    </div>
                                    <div style="text-align:center">
                                        @isset($board->image_path)
                                        <img src="{{ Storage::url($board->image_path) }}" alt="" height="250" weight="100"> 
                                        @else
                                        @endisset
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                <br> 
                @endforeach
                    </tr>
                </table>

            </form>


        </div>
    </body>

</html>