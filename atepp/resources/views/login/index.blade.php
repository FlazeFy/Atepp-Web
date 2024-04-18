@extends('layouts.main')

@section('content')
    <div style="max-width: 700px; margin-top:23vh;" class="d-block mx-auto position-relative">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-white fw-bold mb-2" style="font-size:calc(var(--textXJumbo)*2);">Welcome to Atepp</h2>
                <h6>API Testing App, Test your API, Make dummy data, Generate document, and share it with your co-worker</h6>
            </div>
            <div class="col-lg-6">
                @include('login.form')
            </div>
        </div>
    </div>
@endsection
