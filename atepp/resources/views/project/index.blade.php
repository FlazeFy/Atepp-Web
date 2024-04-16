@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-2 position-relative">
            @include('project.usecases.get_project')
        </div>
        <div class="col-10 position-relative">
            @include('project.usecases.get_endpoint_exec')
            @include('project.usecases.get_endpoint_container')
            @include('project.usecases.get_endpoint_response')
        </div>
    </div>
@endsection
