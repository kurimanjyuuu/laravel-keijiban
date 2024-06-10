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
            @if($errors->any())
            <div class="alert alert-danger">
            @foreach($errors->all() as $message)
            {{ $message }}
            @endforeach
            </div>
            @endif
                <form method="POST" action="{{ route('edit.complete') }}" enctype="multipart/form-data">
                @csrf
                @foreach($bow as $b)
                    <div style="margin-top:20px;">
                        <table border="0" frame="box" rulues="none" border="black" width="600" align="center">
                            <tr style="text-align:left">
                                <td nowrap>名前</td>
                                <td>
                                <input type="text" name="name" value="{{ $b->name }}">
                                </td>
                            </tr>
                            <tr style="text-align:left">
                                <td nowrap>件名</td>
                                <td>
                                    <input type="text" name="subject" value="{{ $b->subject }}">
                                </td>
                            </tr>
                            <tr style="text-align:left">
                            <td nowrap>メッセージ</td>
                                <td>
                                    <textarea name="message" value="{!! nl2br($b->message) !!}" cols="70" rows="10" autofocus></textarea>
                                </td>
                            </tr>
                            <tr style="text-align:left">
                                <td nowrap>画像</td>
                                <td><input type="file" name="image_path"></td>  
                            </tr>
                            
                            <tr>
                                <td colspan="2" style="text-align:center">
                                    <small>※新しい画像をアップロードすると現在の画像は削除されます。</small>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center">
                                    <small>
                                        ▽現在の画像を削除する。
                                        (<input class="radio" type="checkbox" name="delete_path" value="1">この画像を削除する。)  
                                    </small>
                                </td>
                            </tr>     
                            <tr>
                                <td colspan="2" style="text-align:center">
                                @isset($b->image_path)
                                    <img src="{{ Storage::url($b->image_path) }}" height="250" weight="100">
                                @else
                                    現在の画像はありません。
                                @endisset   
                                </td>
                            </tr>  
                            <tr style="text-align:left">
                                <td nowrap>メールアドレス</td>
                                <td>
                                <input type="text" name="email" value="{{ $b->email }}">
                                </td>
                            </tr>
                            <tr style="text-align:left">
                                <td nowrap>URL</td>
                                <td>
                                    <input type="text" name="url" value="{{ $b->url }}">
                                </td>
                            </tr>
                            <tr style="text-align:left">
                                <td nowrap>文字色</td>
                                <td>
                                @foreach($text_color as $color)
                                    <input type="radio" name="text_color" value="{{ $color }}">
                                    <span style="color:{{ $color }}">■</span>
                                @endforeach
                                </td>
                            </tr>
                            <tr style="text-align:left">
                                <td nowrap>編集/削除キー<br><small>(半角英数字のみで4～8文字)<br></small></td>
                                <td>    
                                    <input type="password" name="delete_key" maxlength="8"></br>
                                </td>
                            </tr> 
                                <td colspan="2" style="text-align:center">
                                    ※編集時はプレビュー機能を使えません。
                                </td>
                            <tr style="text-align:center">
                                <td colspan="2" style="text-align:center">
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="board_id" value="{{ $board_id }}">
                                    <input type="hidden" name="edit_type" value="{{ $edit_type }}">
                                    
                                    <?php 
                                    var_dump($id);
                                    echo $edit_type;
                                    ?>
                                    <input class="button" type="submit" value="編集投稿">
                                </td>
                            </tr>      
                        </table>
                    </div>
                <br> 
                @endforeach
            </form><br>
        </div>
    </body>
</html>