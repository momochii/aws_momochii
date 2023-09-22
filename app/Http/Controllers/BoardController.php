<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    protected $fillable = [
        'email', // 'email' 속성을 대량 할당 허용 목록에 추가
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

//        $users = DB::table('users')->get();
//
        return view('board');
    }

    public function write($id=null)
    {

        // 뷰에 스크립트 추가
        View::composer('board_write', function ($view) {
            $view->with('script', asset('js/board.js'));
        });

        $boards = '';
        if (!empty($id) && $id > 0) {
            $boards = DB::table('board')->where('id', $id)->get()->toArray();

        }

        echo "<xmp>";
        print_r($boards);
        echo "</xmp>";
        return;

        return view('board_write', $boards);

    }

    public function proc(Request $request)
    {

        $post = $request->all();

        $email = $post['email'];
        $content = $post['content'];

        if (!empty($post['upload_file'])) {
            /***** 업로드 처리 *****/
            $path = storage_path('app/public/uploads');

            // 파일 유효성 검사
            $request->validate([
                'file' => 'file|mimes:jpg,png,pdf|max:2048', // 원하는 파일 유형 및 크기로 변경
            ]);

            // 파일을 서버에 저장
            $file = $request->file('upload_file');

            $fileName = $file->getClientOriginalName(); // 원본 파일 이름 가져오기
            $file->move($path, $fileName);
        }

        //update
        if (!empty($post['id'])) {
            $params = [];
            $params['email']    = $email;
            $params['content']  = $content;
            $params['name']     = Auth::user()->name;
            if (!empty($fileName)) {
                $params['file']  = $fileName;
            }

            DB::table('board')->where('id', $id)->update($params);

        } else {
        //insert
            $params = [];
            $params['email']    = $email;
            $params['content']  = $content;
            $params['name']     = Auth::user()->name;
            if (!empty($fileName)) {
                $params['file']  = $fileName;
            }

            $id = DB::table('board')->insertGetId($params);
        }

        return redirect('/board/view/'.$id)->with('success', '게시물이 등록되었습니다.');
    }

    public function view($id)
    {

        $boards = DB::table('board')->where('id', $id)->get();
        echo "<xmp>";
        print_r($boards);
        echo "</xmp>";

    }

}
