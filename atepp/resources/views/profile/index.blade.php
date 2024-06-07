@extends('layouts.main')

@section('content')
    <div class="row mx-2">
        <div class="col-lg-3 position-relative">
            @include('profile.submenu')
        </div>
        <div class="col-lg-9 position-relative">
            @include('profile.section.profile')
        </div>
    </div>
@endsection
