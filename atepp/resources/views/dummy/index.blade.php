@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-4 position-relative">
        </div>
        <div class="col-lg-8 position-relative">
            @include('dummy.usecases.get_my_variable')
        </div>
    </div>
@endsection
