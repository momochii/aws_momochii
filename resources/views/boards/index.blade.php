@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-5">
        <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('boards.create') }}'">{{ __('Write') }}</button>
    </div>

    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Memo</th>
                <th scope="col">Name</th>
                <th scope="col">#</th>
            </tr>
            </thead>
            <tbody>
            @if (!empty($list))
                @foreach($list as $item)
                <tr>
                    <td>
                        <a href="{{ route('boards.show', $item->id, false) }}">{!! nl2br($item->content) !!}</a>
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a href="{{ route('boards.show', $item->id, false) }}" class="btn btn-primary">Detail</a>
                    </td>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    <div>
        {{ $list->links() }}
    </div>



</div>

@endsection
