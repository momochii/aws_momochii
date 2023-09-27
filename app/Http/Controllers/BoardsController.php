<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class BoardsController extends Controller
{

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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $boards = DB::table('boards')->orderBy('id', 'desc')->paginate(5);

        $params = [];
        $params['list'] = $boards;

        return view('boards.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // 뷰에 스크립트 추가
        View::composer('boards.write', function ($view) {
            $view->with('script', asset('js/board.js'));
        });

        return view('boards.write');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'email'=>'required',
            'content'=>'required',
        ]);

        $post = $request->all();

        $email = $post['email'];
        $content = $post['content'];

        $params = [];
        $params['email']    = $email;
        $params['content']  = $content;
        $params['name']     = Auth::user()->name;
        $params['created_at'] = date('Y-m-d H:i:s');

        if (!empty($post['upload_file'])) {
            /***** 업로드 처리 *****/
            $path = storage_path('app/public/uploads');

            // 파일 유효성 검사
            $request->validate([
                'file' => 'file|mimes:jpg,png,pdf|max:2048', // 원하는 파일 유형 및 크기로 변경
            ]);

            // 파일을 서버에 저장
            $file = $request->file('upload_file');

            $originfileName = $file->getClientOriginalName(); // 원본 파일 이름 가져오기
            $ext            = $file->getClientOriginalExtension();
            $hashFileName   = hash('sha256', time() . $originfileName) . '.' . $ext;

            $file->move($path, $hashFileName);

            $params['file']         = $hashFileName;
            $params['file_origin']  = $originfileName;
        }

        $id = DB::table('boards')->insertGetId($params);

        return to_route('boards.show', $id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {

        View::composer('boards.show', function ($view) {
            $view->with('script', asset('js/board.js'));
        });

        $board = Board::where('id', $board->id)->first()->toArray();
        // 파일 URL 생성 (asset 함수 사용)
        $fileUrl = asset('storage/uploads/' . $board['file']);
        $board['src'] = $fileUrl;

        return view('boards.show')->with('board', $board);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        //

        View::composer('boards.write', function ($view) {
            $view->with('script', asset('js/board.js'));
        });

        $board = Board::where('id', $board->id)->first()->toArray();

        $data = [];
        $data['email'] = Auth::user()->email;

        if (!empty($board['id'])) {
            $data = [];
            $data = $board;
        }

        return view('boards.write', ['board'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board)
    {
        //
        $request->validate([
            'email'=>'required',
            'content'=>'required',
        ]);

        $post = $request->all();

        $id = preg_replace("/\D/", "", $post['id']);

        $params = [];
        $params['email']    = $post['email'];
        $params['content']  = $post['content'];
        $params['name']     = Auth::user()->name;

        if (!empty($post['upload_file'])) {
            /***** 업로드 처리 *****/
            $path = storage_path('app/public/uploads');

            // 파일 유효성 검사
            $request->validate([
                'file' => 'file|mimes:jpg,png,pdf|max:2048', // 원하는 파일 유형 및 크기로 변경
            ]);

            // 파일을 서버에 저장
            $file = $request->file('upload_file');

            $originfileName = $file->getClientOriginalName(); // 원본 파일 이름 가져오기
            $ext            = $file->getClientOriginalExtension();
            $hashFileName   = hash('sha256', time() . $originfileName) . '.' . $ext;

            $file->move($path, $hashFileName);

            $params['file']         = $hashFileName;
            $params['file_origin']  = $originfileName;
        }

        $params['updated_at'] = date('Y-m-d H:i:s');

        DB::table('boards')->where('id', $id)->update($params);

        return to_route('boards.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $item = Board::find($id);
        if (!$item) {
            return response()->json(['message'=>'레코드를 찾을 수 없습니다.', '404']);
        }

        $item->delete();
        return response()->json(['message'=>'레코드가 삭제되었습니다.']);

    }
}
