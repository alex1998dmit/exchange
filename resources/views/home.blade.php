@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Currency exchange:</h2>
            <div class="card shadow" col-md-8>
                <div class="card-body">
                    <form action="" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exchanged_currency">Exchange balance:</label>
                            <input type="text" class="form-control" id="exchange_currency" name="rate" disabled>
                        </div>

                        <div class="form-group">
                            <label>You have:</label>
                            <input type="text" class="form-control" id="exchange_balance" name="rate" disabled>
                        </div>

                        <div class="form-group">
                            <label for="received_currency">Received balance:</label>
                            <select class="form-control" id="received_currency" name="received_cur">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="received_currency">Rate:</label>
                            <input type="text" class="form-control" id="rate" name="rate" disabled>
                        </div>

                        <div class="form-group">
                            <label for="amount" id="amount_label">Amount of receiving currency</label>
                            <input type="text" id="amount_to_exchange" class="form-control" name="amount">
                        </div>

                        <div class="form-group">
                            <label for="amount">Cost of exchange:</label>
                            <input type="text" class="form-control" id="amount" disabled>
                        </div>

                        <button type="submit" id="exchange_button" class="btn btn-primary">Exchange</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/exchange.js') }}"></script>
@endsection
