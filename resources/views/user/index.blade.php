@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-3">Your balances:</h2>
    <div class="card shadow">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="width: 10%">#</th>
                    <th scope="col" style="width: 30%">Currency</th>
                    <th scope="col" style="width: 30%">Amount</th>
                </tr>
            </thead>
            <tbody id="balances-block">
            </tbody>
        </table>
    </div>

    <h2 class="mt-5">Today's exchanges:</h2>
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
