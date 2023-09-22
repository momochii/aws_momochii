@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card" style="width: 20rem;">
                <div class="card-header">{{ __('New Register') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card" style="width: 18rem;">
                        <ul class="list-group list-group-flush">
                            @if (!empty($users))
                                @foreach($users as $item)
                                <li class="list-group-item">{{ $item->name }} ({{ $item->email }})</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
