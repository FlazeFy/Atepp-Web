@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col">
        </div>
        <div class="col">
            @include('dashboard.usecases.get_endpoint_performance')
        </div>
    </div>
@endsection
