
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

                @if($errors->any())
                <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                {{ $message }}
                @endforeach
                </div>
                @endif

            <form method="POST" action="{{ route('boards.preview') }}" enctype="multipart/form-data">
                @csrf
                <table border="0" frame="box" rulues="none" border="black" width="600" align="center">
                    <tr>
                        <td nowrap>名前</td>
                        <td nowrap><input type="text" name="name" class="control-label @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus></td>
                    </tr>
                    <tr>
                        <td nowrap>件名</td>
                        <td nowrap><input type="text" name="subject" class="control-label @error('subject') is-invalid @enderror"  value="{{ old('subject') }}" autofocus></td>
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
                        </td>
                    </tr>
                </table>
            </form>

            @foreach($boards as $board)
            <div style="margin-top:20px;">
                <table border="0" frame="box" rulues="none" border="black" width="600" align="center">
                    <tr>
                        <td>
                            <div style="text-align:left">
                            <?php echo $board->delet_key;?>
                                名前:{{ $board->name}} -
                                件名:{{ $board->subject }} -
                                URL:{{ $board->url }}
                            </div>
                            <div style="text-align:right">
                            {{ date("Y/m/d/H時i分", strtotime( $board->created_at)) }}
                            </div>
                            <div style="text-align:left">
                                <br>
                                メッセージ:
                                <br>
                                <span style="color:{{ $board->text_color }}">{!! nl2br($board->message) !!}</span>
                                <br>
                                画像:
                            </div>
                            <div style="text-align:center">
                                <img src="{{ Storage::url($board->image_path) }}" alt="" height="250" weight="100"> 
                            </div>
                            <div style="display:inline-flex">
                                <form method="GET" action="{{ route('replies.index') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id"  value="{{ $board->id }}">
                                    <?php var_dump($board->id);?>
                                    <input class="button" type="submit" value="返信">
                                </form>
                                <form method="GET" action="{{ route('read.index') }}" enctype="multipart/form-data">
                                    <input type="hidden" name="id"  value="{{ $board->id }}">
                                    <input type="hidden" name="edit_type" value="boards">
                                    <input type="hidden" name="delete_key" value="{{ $board->delete_key }}">
                                    <?php var_dump($board->id);?>
                                    @csrf
                                    <input class="button" type="submit" value="編集">
                                </form>
                                <form method="GET" action="{{ route('delete.index') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id"  value="{{ $board->id }}">
                                    <input type="hidden" name="delete_type" value="boards">
                                    <input type="hidden" name="delete_key" value="{{ $board->delete_key }}">
                                    <?php var_dump($board->id);?>
                                    <input class="button" type="submit" value="削除">
                                </form>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <br> 
            
            @foreach($replies as $reply)
            @if($board->id == $reply->board_id)
            <div style="margin-top:20px;">
                <table border="0" frame="box" rulues="none" border="black" width="600" align="center">
                    <tr>
                        <td>
                            <div style="text-align:left">
                                名前:{{ $reply->name}} -
                                件名:{{ $reply->subject }} -
                                URL:{{ $reply->url }}
                                </div>
                                <div style="text-align:right">
                                {{ date("Y/m/d/H時i分", strtotime( $reply->created_at)) }}
                                </div>
                                <div style="text-align:left">
                                <br>
                                メッセージ:
                                <br>
                                <span style="color:{{ $reply->text_color }}">{!! nl2br($reply->message) !!}</span>
                                <br>
                                画像:
                            </div>
                            <div style="text-align:center">
                                <img src="{{ Storage::url($reply->image_path) }}" alt="" height="250" weight="100"> 
                            </div>
                            <div style="display:inline-flex">
                                <form method="GET" action="{{ route('read.index') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id"  value="{{ $reply->id }}">
                                    <input type="hidden" name="board_id"  value="{{ $reply->board_id }}">
                                    <input type="hidden" name="edit_type" value="replies">
                                    <input type="hidden" name="delete_key" value="{{ $reply->delete_key }}">
                                    <?php
                                        var_dump($reply->id);
                                        var_dump($reply->board_id);
                                    ?>
                                    <input class="button" type="submit" value="編集">
                                </form>
                                <form method="GET" action="{{ route('delete.index') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id"  value="{{ $reply->id }}">
                                    <input type="hidden" name="board_id"  value="{{ $reply->board_id }}">
                                    <input type="hidden" name="delete_type" value="replies">
                                    <input type="hidden" name="delete_key" value="{{ $reply->delete_key }}">
                                    <?php
                                    var_dump($reply->id);
                                    ?>
                                    <input class="button" type="submit" value="削除">
                                </form>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <br> 
            @endif
            @endforeach
            @endforeach

    </body>     
</html>