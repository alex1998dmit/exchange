@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
            <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="width: 10%">#</th>
                    <th scope="col" style="width: 30%">Exchanged</th>
                    <th scope="col" style="width: 30%">Received</th>
                    <th scope="col" style="width: 15%">Rate</th>
                    <th scope="col" style="width: 15%">Change</th>
                </tr>
            </thead>
            <tbody id="exchanges-block">
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/stat.js') }}"></script>
@endsection
