@extends('layouts.app')

@section('content')
<script src="{{ $script }}"></script>
<div class="container">
    @csrf
    <div class="col-md-6">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">{{ __('이메일') }}</label>
            <div>
                {{ $board['email'] }}
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">문의내용</label>
            <div>
                {!! nl2br($board['content']) !!}
            </div>
        </div>

        <div class="mb-3">
            <div class="mb-3">
                <label for="formFile" class="form-label">첨부파일</label>
                <img src="{{ $board['src'] }}" alt="" style="width: 50px;" />
                <input class="form-control" name="upload_file" type="file" id="formFile">
            </div>
        </div>

        <div class="mb-5">
            <button type="button" class="btn btn-secondary" onclick="location.href='/boards'">{{ __('목록') }}</button>
            @if(Auth::user()->email == $board['email'])
                <button type="button" class="btn btn-warning" onclick="location.href='/boards/{{ $board['id'] }}/edit'">{{ __('수정') }}</button>
                <button type="button" class="btn btn-danger" onclick="delBoard('{{ $board['id'] }}')">{{ __('삭제') }}</button>
            @endif
        </div>
    </div>

</div>

@endsection
