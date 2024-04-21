@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col">
            @include('dashboard.usecases.get_my_project')
            @include('dashboard.usecases.post_project')
        </div>
        <div class="col">
            @include('dashboard.usecases.get_endpoint_performance')
            @include('dashboard.usecases.get_endpoint_status_code')
        </div>
    </div>
@endsection
