<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf8">
        <title>掲示板 Sample</title>
    </head>

    <body>
        <div style="text-align:center">
            <h1>掲示板</h1>
            <a href="{{ route('boards.index') }}">一覧(新規投稿)</a>❘
            <a href="{{ route('search.index') }}">ワード検索</a>❘
            <a href="">使い方</a>❘
            <a href="">携帯へURLを送る</a>❘
            <a href="">管理</a>

            <p>
                以下の内容でよろしければ、「このまま投稿する」ボタンを押してください。</br>
                戻って修正する場合は、「戻って修正する」ボタンでお戻りください。
            </p>
        
            <form method="POST" action="{{ route('replies.complete') }}" enctype="multipart/form-data">
                @csrf
                <table border="1" frame="box" rulues="none" border="black" width="600" align="center">
                    <tr>
                        <td nowrap>名前</td>
                        <td>{{ $replies['name'] }}</td>
                        <input type="hidden" name="name" value="{{ $replies['name'] }}">
                    </tr>
                    <tr>
                        <td nowrap>件名</td>
                        <td>{{ $replies['subject'] }}</td>
                        <input type="hidden" name="subject" value="{{ $replies['subject'] }}">                
                    </tr>
                    <tr>
                        <td nowrap>メッセージ<br><small style="color:{{ $replies['text_color'] }}">(文字色■)</small></td>
                        <td>{!! nl2br($replies['message']) !!}</td>
                        <input type="hidden" name="message" value="{{ $replies['message'] }}">
                    </tr>
                    <tr>
                        <td nowrap>画像</td>
                        <td>
                        @isset($image_path)
                        <img src="{{ Storage::url($image_path) }}" alt="" height="250" weight="100"> 
                        <input type="hidden" name="image_path" value="{{ $image_path }}">
                        @else
                        <div>画像は選択されていません。</div>
                        <input type="hidden" name="image_path" value="">
                        @endisset
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>メールアドレス</td>
                        <td>{{ $replies['email'] }}</td>
                        <input type="hidden" name="email" value="{{ $replies['email'] }}">
                    </tr>
                    <tr>
                        <td nowrap>URL</td>
                        <td>{{ $replies['url'] }}</td>
                        <input type="hidden" name="url" value="{{ $replies['url'] }}">
                    </tr>
                    <tr>
                        <td nowrap>編集/削除キー</td>
                        <td>{{ $replies['delete_key'] }}</td>
                        <input type="hidden" name="delete_key" value="{{ $replies['delete_key'] }}">
                    </tr>
                    <tr>
                    <input type="hidden" name="text_color" value="{{ $replies['text_color'] }}">
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center">
                            <button type="button" onclick=history.back()>戻って修正する</button>
                            <input class="button" onclick="location.href='./com.php'" type="submit" value="このまま投稿する">
                            <input type="hidden" name="board_id"  value="{{ $board_id }}">
                              <?php var_dump($board_id);?> 
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>