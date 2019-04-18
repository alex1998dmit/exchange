import $ from 'jquery';

$(document).ready(function() {

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    let currencies_url = 'https://www.cbr-xml-daily.ru/daily_json.js';

    // state
    let exchange_currency_id;
    let exchanged_balance_amount;
    let received_currency_id;
    let rate;
    let amount;
    let amount_warning_sign = false;

    const buildReceivedBalancesMenu = () => {
        $.ajax({
            type:'GET',
            url: `https://cors-anywhere.herokuapp.com/${currencies_url}`,
            success: function(data){
                let rates_json = JSON.parse(data);
                let date_refresh = rates_json.Date
                let rates = rates_json.Valute;
                received_currency_id = $('#received_currency').children(":selected").attr("id");
                const received_currency_name =$('#received_currency').children(":selected").data("name");
                const rate_full_value = rates[received_currency_name].Value;
                rate =  Math.floor(rate_full_value * 100) / 100;
                $(`#rate`).val(rate);
            }
        });
    }


    const prepare_form = () => {

        const url = `/api/user`;

        buildReceivedBalancesMenu();

        $.ajax({
            url,
            type: 'GET',
            data: { 'token': CSRF_TOKEN },
            dataType: 'json',
          }).done((json_response)=> {
                const balances = json_response.data.balances;

                // Отрефакторить чтобы был не массив, добавить в отдельную функцию
                const exchange_balance_json = balances.filter(el => el.name === 'RUB');
                exchanged_balance_amount = exchange_balance_json[0].amount;
                const exchange_balance_name = exchange_balance_json[0].name;
                exchange_currency_id = exchange_balance_json[0].balance_id;
                $('#exchange_balance').val(exchanged_balance_amount);
                $('#exchange_currency').val(exchange_balance_name);

                const received_balances = balances.filter(el => el.name !== 'RUB');
                received_balances.forEach(el => $(`#received_currency`).append(`<option id=${el.balance_id} data-name=${el.name}>${el.name}  ${el.amount}</option>`));
            });

    }

    $(document).on("change", '#received_currency', function(e){
        // Исправить запрос на запрос без проксирования, решить проблему с корс
        buildReceivedBalancesMenu();
    });

    $(document).on("keyup", '#amount_to_exchange', function(e) {
        amount = $(this).val();
        const max_amount_received = Math.floor(exchanged_balance_amount/rate * 100) / 100;
        let amount_received =  Math.floor(amount*rate * 100) / 100;
        if(exchanged_balance_amount < rate * amount) {
            if(!amount_warning_sign) {
                $('#amount_label').append(`<h5 id="amount_warning_sign" style="color:red">У вас недостаточно средств на счету,максимально доступно для обмена: ${max_amount_received} </h5>`);
                amount_warning_sign = true;
                amount_received = max_amount_received;
            }
        } else {
            $('#amount_warning_sign').remove();
            amount_warning_sign = false;
        }
        $(`#amount`).val(amount_received);
    });

    $('#exchange_button').click((e) => {
        e.preventDefault();
        console.log('button is submit');
        let url = 'api/exchange';

        $.ajax({
            url,
            type: 'POST',
            data: { exchanged_cur:  exchange_currency_id, received_cur: received_currency_id, amount: amount, rate: rate, _token: CSRF_TOKEN },
            dataType: 'json',
            success: function(json_response) {
                const balances = json_response.data.balances;
                // Отрефакторить чтобы был не массив, добавить в отдельную функцию
                const exchange_balance_json = balances.filter(el => el.name === 'RUB');
                exchanged_balance_amount = exchange_balance_json[0].amount;
                const exchange_balance_name = exchange_balance_json[0].name;
                exchange_currency_id = exchange_balance_json[0].balance_id;
                $('#exchange_balance').val(exchanged_balance_amount);
                $('#exchange_currency').val(exchange_balance_name);
            },
        });
    });

    prepare_form();
});
