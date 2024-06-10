<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection; //追記
use Illuminate\Pagination\LengthAwarePaginator; //追記
use Illuminate\Support\Facades\DB;// 追加
use Illuminate\Http\Request;
use App\Http\Requests\BoardsFormRequest;
use App\Http\Requests\RepliesFormRequest;
use App\Http\Requests\DeleteFormRequest;
use App\Http\Requests\SearchFormRequest;
use Illuminate\Database\Eloquent\Model;
use App\Boards;
use App\Replies;
// use Carbon\Carbon;




class BoardsController extends Controller
{
    public function index(Request $request)
    {
        $text_color = config('text_color');

        // boards DB 取得
        $boards = DB::table('boards')->get()->toArray();
        $boards = Boards::orderBy('id', 'desc')->get();
        // replies DB　取得
        $replies = DB::table('replies')->get()->toArray();
        $replies = Replies::orderBy('board_id', 'desc')->get();

        // var_dump($replies);
        // exit;
        
        return view('boards/boards_index')
        -> with ([
            
            'text_color'=>$text_color,
            'boards'=>$boards,
            'replies'=>$replies
        ]);
    }

    public function preview(BoardsFormRequest $request)
    {
        $boards = $request->preview;
        
        // プレビューにバリューの値が入っていたら
        if($boards == "1"){
        
            $tmp_name = $request->file('image_path');
            
            if($tmp_name) {

                $image_path = $tmp_name->store('public/images');
                var_dump($image_path);
            } else {

                $image_path = null;
            } 
            $boards = $request->all();
            return view('boards/boards_preview',compact('boards','image_path'));
        // プレビューにバリューの値が入っていなかったら
        }  else {

            $tmp_name = $request->file('image_path');
            
            if($tmp_name) {

                $image_path = $tmp_name->store('public/images');

            } else {

                $image_path = null;
            } 
            $boards = new Boards;

            $boards->name = $request->name;
            $boards->subject = $request->subject;
            $boards->message = $request->message;
            $boards->image_path = $image_path;
            $boards->email = $request->email;
            $boards->url = $request->url;
            $boards->text_color = $request->text_color;
            $boards->created_at = $request->created_at;
            $boards->delete_key = $request->delete_key;
            $boards->created_at = date('Y-m-d H:i:s');
            $boards->save();
        
            return view('boards/boards_complete',compact('boards','image_path'));
        }
    }

    public function complete(Request $request)
    {
        $boards = new Boards;

        $boards->name = $request->name;
        $boards->subject = $request->subject;
        $boards->message = $request->message;
        $boards->image_path = $request->image_path;
        $boards->email = $request->email;
        $boards->url = $request->url;
        $boards->text_color = $request->text_color;
        $boards->created_at = $request->created_at;
        $boards->delete_key = $request->delete_key;
        $boards->created_at = date('Y-m-d H:i:s');
        $boards->save();
        
        return view('boards/boards_complete',compact('boards'));
    }

    public function replies(Request $request)
    {
        $text_color = config('text_color');
        $id = $request->input('id');

        if(!empty($id)) {

            // セッションに保存する
            $request->session()->put("board_id", $id);
            // セッションから取り出す
            $get_session_id = $request->session()->get("board_id");
        } else {
            // セッションから取り出す
            $get_session_id = $request->session()->get("board_id");
        }

        $bow = Boards::whereId($get_session_id)->get();
        // var_dump($bow);
        // exit;
        $replies = DB::table('replies')->get()->toArray();
       
        return view('replies/replies_index',compact('bow','text_color','id'))
        -> with ([
            'text_color'=>$text_color,
            'replies'=>$replies,
            'id'=>$id
        ]);
    }

    public function repliespreview(RepliesFormRequest $request)
    {
        
        $board_id = $request->board_id; 
        $replies = $request->preview;
        // var_dump($board_id);
        // exit;
        if($replies == "1") {

            $tmp_name = $request->file('image_path');

            if($tmp_name) {

                $image_path = $tmp_name->store('public/images');

            } else {

                $image_path = null;
            } 
            $replies = $request->all();
            return view('replies/replies_preview',compact('replies','image_path','board_id'));

        } else {

            $tmp_name = $request->file('image_path');

            if($tmp_name) {

                $image_path = $tmp_name->store('public/images');

            } else {

                $image_path = null;
            } 
            $replies = new Replies;
            
            $replies->board_id = $request->board_id; 
            $replies->name = $request->name;
            $replies->subject = $request->subject;
            $replies->message = $request->message;
            $replies->image_path = $image_path;
            $replies->email = $request->email;
            $replies->url = $request->url;
            $replies->text_color = $request->text_color;
            $replies->delete_key = $request->delete_key;
            $replies->created_at = date('Y-m-d H:i:s');
            $replies->save();
            
            return view('replies/replies_complete',compact('replies'));
        }
    }

    public function repliescomplete(Request $request)
    {
        $replies = new Replies;
        
        $replies->board_id = $request->board_id;
        $replies->name = $request->name;
        $replies->subject = $request->subject;
        $replies->message = $request->message;
        $replies->image_path = $request->image_path;
        $replies->email = $request->email;
        $replies->url = $request->url;
        $replies->text_color = $request->text_color;
        $replies->delete_key = $request->delete_key;
        $replies->created_at = date('Y-m-d H:i:s');
        $replies->save();
        
        return view('replies/replies_complete', compact('replies'));
    }

        /**
     * 削除処理
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        $delete_type = $request->delete_type;

        // var_dump($boards_id);
        var_dump($id);
        echo $delete_type;
        // exit;
        return view('delete/delete_index',compact('id','delete_type'));
    }

    /**
     * 削除完了
     */
    public function deletecomplete(Request $request)
    {
        // 削除対象のid取得 
        $id = $request->id;
        $delete_type = $request-> delete_type;
        $board_id = $request->board_id;
        // userが入力したdelete_key
        $user_delete_key = $request->delete_key;
        
        if($delete_type === 'boards'){
            $delete_rows = Boards::where('id', $id)->get();
        }
        if($delete_type === 'replies'){
            $delete_rows = Replies::where('id', $id)->get();
            // echo $delete_rows;
            // exit;
        }
     
        foreach($delete_rows as $delete_row){
            $delete_key = $delete_row->delete_key;
        }
        // var_dump($delete_rows);
        // exit;
        if($delete_key == $user_delete_key){
            if($delete_type === 'boards'){
                $delete_replies = Replies::where('board_id', $id)->get();
                foreach ($delete_replies as $delete_reply){
                    $delete_reply->delete();
                }
            }
            $delete_row->delete();

            return view('delete/delete_complete',compact('id','delete_type','delete_key'));
        } else {
            echo "パスワードが違います。\n";
            // exit;
            return view('delete/delete_index',compact('id','delete_type'));
        }
    }

    // パスワード入力画面
    public function read(Request $request)
    {
        $id = $request->id;
        $board_id = $request->board_id;
        $edit_type = $request->edit_type;
        var_dump($id);
        var_dump($board_id);
        
        return view('read/read_index',compact('id','edit_type','board_id'));
    }

    public function edit(Request $request)
    { 
        $user_delete_key = $request->delete_key;
        $edit_type = $request->edit_type;
        $board_id = $request -> board_id;
        $text_color = config('text_color');
        $id = $request->input('id');
        var_dump($id);

        if($edit_type === 'boards'){
            $edit_rows = Boards::where('id', $id)->get();
        }
        if($edit_type === 'replies'){
            $edit_rows = Replies::where('id', $id)->get();
        }

        foreach($edit_rows as $edit_row){
            $delete_key = $edit_row->delete_key;
        }

        if($delete_key == $user_delete_key){
            if($edit_type === 'boards'){
                $edit_replies = Replies::where('board_id', $id)->get();
                foreach ($edit_replies as $edit_reply){
                   
                }
            }
            $tmp_name = $request -> file('image_path');
            if($tmp_name) {
    
                $image_path = $tmp_name -> store('public/images');
    
            } else {
    
                $image_path = null;
            } 
            // exit;
            if($edit_type === 'boards'){
    
            $bow = Boards::whereId($id)->get();
            // var_dump($bow);
            // exit;
            $boards = DB::table('boards')->get()->toArray();
           
            return view('edit/edit_index',compact('id','bow','edit_type','text_color','board_id'))
            -> with ([
                'id'=>$id,
                'boards'=>$boards,
                'text_color'=>$text_color
            ]);
        } else {
            $bow = Replies::whereId($id)->get();
            $boards = DB::table('replies')->get()->toArray();
            return view('edit/edit_index',compact('id','bow','text_color','edit_type','board_id'))
            -> with ([
                'id'=>$id,
                'boards'=>$boards,
                'text_color'=>$text_color
            ]);
        }
        } else {
            echo "パスワードが違います。\n";
            return view('read/read_index',compact('id','edit_type','board_id'));
        }
    }

    public function editcomplete(BoardsFormRequest $request)
    {
        $id = $request->id;
        $board_id = $request->board_id;
        $edit_type = $request->edit_type;
        $delete_path = $request->delete_path;
        
        if($edit_type === 'boards'){

            $tmp_name = $request -> file('image_path');
            if($tmp_name) {
    
                $image_path = $tmp_name -> store('public/images');
    
            } else if($delete_path == 1) {
            
                $image_path = "";

            } else {
                $image_path = null;
            }

        $boards = Boards::find($id);

        $boards->name = $request->name;
        $boards->subject = $request->subject;
        $boards->message = $request->message;
        $boards->image_path = $image_path;
        $boards->email = $request->email;
        $boards->url = $request->url;
        $boards->updated_at = $request->updated_at;
        $boards->text_color = $request->text_color;
        $boards->delete_key = $request->delete_key;

        $boards->save(); // IDが入ってるからupdateになる(上書きされる)
        return view('edit/edit_complete',compact('id','edit_type','image_path','board_id','delete_path'));
        }  

        if($edit_type === 'replies')  {

            $tmp_name = $request->file('image_path');
            if($tmp_name) {
    
                $image_path = $tmp_name->store('public/images');
    
            } else if($delete_path == 1) {
            
                $image_path = "";

            } else {
                $image_path = null;
            }
            $replies = Replies::find($id);
        
            $replies->board_id = $request->board_id; 
            $replies->name = $request->name;
            $replies->subject = $request->subject;
            $replies->message = $request->message;
            $replies->image_path = $image_path;
            $replies->email = $request->email;
            $replies->url = $request->url;
            $replies->updated_at = $request->updated_at;
            $replies->text_color = $request->text_color;
            $replies->delete_key = $request->delete_key;

            $replies->save();
            return view('edit/edit_complete',compact('id','edit_type','image_path','board_id','delete_path'));
        }
    }

    public function search(Request $request)
    {
        return view('search/search_index');
    }

    public function searchcomplete(SearchFormRequest $request)
    {
        $id = $request->id;
        $andor = $request->andor;
        $keyword = $request->keyword;
        $image_path = $request->image_path;
        var_dump($keyword);

        if(strpos($keyword,' ')){
            $keywords = explode(' ',$keyword);
        } else {
            $keywords = explode('　',$keyword);
        } 
        echo $keyword;
        echo $andor;

        // keyword 0,1
        if(count($keywords) >= "2") { 
            if($andor == 'or'){
                $boards = Boards::select("name", "subject", "url", "created_at", "text_color", "message", "image_path")
                ->where("message", "LIKE", "%{$keywords[0]}%")
                ->orWhere("message", "LIKE", "%{$keywords[1]}%")
                ->get();
            
                $replies = Replies::select("name", "subject", "url", "created_at", "text_color", "message", "image_path")
                ->where("message", "LIKE", "%{$keywords[0]}%")
                ->orWhere("message", "LIKE", "%{$keywords[1]}%")
                ->get();
        
                $boards = $boards->concat($replies);

            } else {

                $boards = Boards::select("name", "subject", "url", "created_at", "text_color", "message", "image_path")
                ->where("message", "LIKE", "%{$keywords[0]}%")
                ->where("message", "LIKE", "%{$keywords[1]}%")
                ->get();
            
                $replies = Replies::select("name", "subject", "url", "created_at", "text_color", "message", "image_path")
                ->where("message", "LIKE", "%{$keywords[0]}%")
                ->where("message", "LIKE", "%{$keywords[1]}%")
                ->get();
            
                $boards = $boards->concat($replies);

            }  
        
        } else {
        
            $boards = Boards::select("name", "subject", "url", "created_at", "text_color", "message", "image_path")
            ->where("message", "LIKE", "%{$keywords[0]}%")
            ->get();
        
            $replies = Replies::select("name", "subject", "url", "created_at", "text_color", "message", "image_path")
            ->where("message", "LIKE", "%{$keywords[0]}%")
            ->get();
        
            $boards = $boards->concat($replies);
    
        }
        
        return view('search/search_complete',compact('id','boards'));
    }   
}

