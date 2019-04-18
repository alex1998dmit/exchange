@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" id="exchanges-block">
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/stat.js') }}"></script>
@endsection
