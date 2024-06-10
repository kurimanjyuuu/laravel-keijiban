<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf8">
        <title>返信</title>
    </head>

    <body>
        <div style="text-align:center">
            <h1>掲示板</h1>
            <a href="{{ route('boards.index') }}">一覧(新規投稿)</a>❘
                <a href="{{ route('search.index') }}">ワード検索</a>❘
                <a href="">使い方</a>❘
                <a href="">携帯へURLを送る</a>❘
                <a href="">管理</a>

            @if($errors->any())
            <div class="alert alert-danger">
            @foreach($errors->all() as $message)
            {{ $message }}
            @endforeach
            </div>
            @endif
                @foreach($bow as $b)
                    <div style="margin-top:20px;">
                        <table border="0" frame="box" rulues="none" border="black" width="600" align="center">
                            <tr>
                                <td>
                                    <div style="text-align:left">
                                        名前:{{ $b -> name}} -
                                        件名:{{ $b -> subject }} -
                                        URL:{{ $b -> url }}<br>
                                        メッセージ:
                                        <br>
                                        <span style="color:{{ $b->text_color }}">{!! nl2br($b -> message) !!}</span>
                                        <br>
                                        画像:
                                    </div>
                                    <div style="text-align:center">
                                    @isset($b -> image_path)
                                        <img src="{{ Storage::url($b -> image_path) }}" alt="" height="250" weight="100"> 
                                    @else
                                        <img src="" alt=""> 
                                    @endisset
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                <br> 
                @endforeach
           
            <form method="POST" action="{{ route('replies.preview') }}" enctype="multipart/form-data">
                @csrf
                <table border="0" frame="box" rulues="none" border="black" width="600" align="center">
                    <tr>
                        <td nowrap>名前</td>
                        <td nowrap><input type="text" name="name" class="control-label @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus></td>

                    </tr>
                    <tr>
                        <td nowrap>件名</td>
                        <td nowrap><input type="text" name="subject" class="control-label @error('subject') is-invalid @enderror"  value="Re:{{ old('subject') }}" autofocus></td>      
                    </tr>
                    <tr>
                        <td nowrap>メッセージ</td>
                        <td><textarea name="message" class="control-label @error('message') is-invalid @enderror" value="{{ old('message') }}" cols="70" rows="10" autofocus></textarea></td>    
                    </tr>
                    <tr>
                        <td nowrap>画像<td>
                        <input id="image_path" type="file" name="image_path" class="control-label @error('image_path') is-invalid @enderror" autofocus>
                    </tr>
                    <tr>
                        <td nowrap>メールアドレス</td>
                        <td><input type="text" name="email" class="control-label @error('email') is-invalid @enderror" autofocus></td>        
                    </tr>
                    <tr>
                        <td nowrap>URL</td>
                        <td><input type="text" name="url" class="control-label @error('url') is-invalid @enderror" value="http://" autofocus></td>
                    </tr>
                    <tr>
                        <td nowrap>文字色</td>
                        <td>
                        @foreach($text_color as $color)
                            <input type="radio" name="text_color" class="control-label @error('text_color') is-invalid @enderror" value="{{ $color }}" autofocus>
                            <span style="color:{{ $color }}">■</span>
                        @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>編集/削除キー</td>
                        <td>
                            <input type="password" name="delete_key" maxlength="8"></br>
                            <small>(半角英数字のみで4～8文字)</small>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" nowrap>
                            <input class="radio" type="checkbox" name="preview" value="1">
                            プレビューする<small>（投稿前に、内容をプレビューして確認できます）</small>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center">
                            <input class="radio" type="submit" name="submit" value="投稿">
                            <input class="radio" type="reset" name="reset" value="リセット">
                            <input type="hidden" name="board_id"  value="{{ $id }}">
                            <?php var_dump( $id );?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>     
</html>