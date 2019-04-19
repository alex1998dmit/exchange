@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Обмен валют</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exchanged_currency">Ваш счет для списания</label>
                            <input type="text" class="form-control" id="exchange_currency" name="rate" disabled>
                        </div>

                        <div class="form-group">
                            <label>На счету у вас: </label>
                            <input type="text" class="form-control" id="exchange_balance" name="rate" disabled>
                        </div>

                        <div class="form-group">
                            <label for="received_currency">Выберите покупаемую валюту</label>
                            <select class="form-control" id="received_currency" name="received_cur">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="received_currency">Курс обмениваемой валюты: </label>
                            <input type="text" class="form-control" id="rate" name="rate" disabled>
                        </div>

                        <div class="form-group">
                            <label for="amount" id="amount_label">Какое количество новой валюты вы хотите приобрести ? </label>
                            <input type="text" id="amount_to_exchange" class="form-control" name="amount">
                        </div>

                        <div class="form-group">
                            <label for="amount">Обмен будет стоить:</label>
                            <input type="text" class="form-control" id="amount">
                        </div>

                        <button type="submit" id="exchange_button" class="btn btn-primary">Транзакция</button>
                    </form>
                </div>
            </div>
        </div>
</div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/exchange.js') }}"></script>
@endsection
