@extends('layouts.app')

@section('content')
<script src="{{ $script }}"></script>
<div class="container">
    <form action="{{ route('board.proc') }}" name="boardForm" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{ $id }}" />
        @csrf
        <div class="col-md-6">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">{{ __('이메일') }}</label>
                <input type="email" name="email" class="form-control check-invalid" id="exampleFormControlInput1" value="{{ Auth::user()->email }}" placeholder="name@example.com">
                <div class="invalid-feedback">
                    이메일을 입력해주세요.
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">문의내용</label>
                <textarea name="content" class="form-control check-invalid" id="exampleFormControlTextarea1" rows="3"></textarea>
                <div class="invalid-feedback">
                    문의내용을 입력해주세요.
                </div>
            </div>

            <div class="mb-3">
                <div class="mb-3">
                  <label for="formFile" class="form-label">첨부파일</label>
                  <input class="form-control" name="upload_file" type="file" id="formFile">
                </div>
            </div>

            <div class="mb-5">
                <button type="button" class="btn btn-secondary" onclick="location.href='/board'">{{ __('목록') }}</button>
                <button type="button" class="btn btn-primary" onclick="boardWrite();">{{ __('등록') }}</button>
            </div>
        </div>
    </form>

</div>

@endsection
