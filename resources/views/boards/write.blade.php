@extends('layouts.app')

@section('content')
<script src="{{ $script }}"></script>
<div class="container">
    @if(!empty($board['id']))
        {{ Form::open( ['route'=>['boards.update', $board['id']], 'enctype'=>'multipart/form-data', 'name'=>"boardForm"] ) }}
    @else
        {{ Form::open( ['route'=>['boards.store'], 'enctype'=>'multipart/form-data', 'name'=>"boardForm"] ) }}
    @endif
        @csrf
        @method('PUT')

        @if(!empty($board['id']))
            <input type="hidden" name="id" value="{{ $board['id'] }}">
        @endif

        <div class="col-md-6">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label font-weight-bold">{{ __('이메일') }}</label>
                <input type="email" name="email" class="form-control check-invalid" id="exampleFormControlInput1" value="{{ $board['email'] ?? '' }}" placeholder="name@example.com">
                <div class="invalid-feedback">
                    이메일을 입력해주세요.
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label font-weight-bold">문의내용</label>
                <textarea name="content" class="form-control check-invalid" id="exampleFormControlTextarea1" rows="3">{{ $board['content'] ?? '' }}</textarea>
                <div class="invalid-feedback">
                    문의내용을 입력해주세요.
                </div>
            </div>

            <div class="mb-3">
                <div class="mb-3">
                  <label for="formFile" class="form-label font-weight-bold">첨부파일</label>
                  <input class="form-control" name="upload_file" type="file" id="formFile">
                </div>
            </div>

            <div class="mb-5">
                <button type="button" class="btn btn-secondary" onclick="location.href='/boards'">{{ __('목록') }}</button>
                <button type="button" class="btn btn-primary" onclick="boardWrite();">{{ (!empty($board)) ? __('수정') : __('등록') }}</button>
            </div>
        </div>
    {!! Form::close() !!}
</div>

@endsection
