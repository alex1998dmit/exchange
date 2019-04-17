@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Девки тачками, деньги пачками</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('exchange.post') }}" method="POST">
                        <div class="form-group">
                            <label for="exchanged_currency">Откуда списываем ваши денюжки ?</label>
                            <select class="form-control" id="exchanged_currency" name="exchanged_cur">
                                <option> Православный счет(Рубль   500)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>У Вас иммется: </label>
                            <input type="text" class="form-control" name="rate" value="100" disabled>
                        </div>

                        <div class="form-group">
                            <label for="received_currency">Какой кошель пополняем, Господин ?</label>
                            <select class="form-control" id="received_currency" name="received_cur">
                                <option>Американцев поддерживаю (доллары)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="received_currency">Курсик выбранной вами валюты: </label>
                            <input type="text" class="form-control" name="rate" value="65" disabled>
                        </div>

                        <div class="form-group">
                            <label for="amount">Сколько башляем ?</label>
                            <input type="text" class="form-control" name="amount">
                        </div>

                        <div class="form-group">
                            <label for="amount">В новой валюте это ... </label>
                            <input type="text" class="form-control">
                        </div>

                        <input type="submit">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

