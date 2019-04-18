
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    let currencies_url = 'https://www.cbr-xml-daily.ru/daily_json.js';

    let exchanged_balances_list = $('#exchanged_currency');
    let received_balances_list = $('#received_currency');


    let show_exchange_balance = (input, value) => {
        $(input).val(value);

    }

    let prepare_form = (form_name = 'form', data) => {
        let options_data = 12;
        $('#exchanged_currency')
        .append(`<option value="foo">foo</option>`)
        .append(`<option value="bar">bar</option>`)
    }


    $.ajax({
        type:'GET',
        url: 'https://cors-anywhere.herokuapp.com/https://www.cbr-xml-daily.ru/daily_json.js',
        success: function(data){
            let rates_json = JSON.parse(data);

            let date_refresh = rates_json.Date
            let rates = rates_json.Valute;

            let exchange_currency = $('#exchange_balance').attr('id');

            show_exchange_balance('#exchange_balance');
        }
    });


    $(document).on("change", '#exchanged_currency', function(e){
        console.log('changed option');
        // Исправить запрос на запрос без проксирования, решить проблему с корс
        $.ajax({
            type:'GET',
            url: `https://cors-anywhere.herokuapp.com/${currencies_url}`,
            success: function(data){
                let rates_json = JSON.parse(data);

                let date_refresh = rates_json.Date
                let rates = rates_json.Valute;
                console.log(rates);
                // let exchange_currency = $('#exchange_balance').attr('id');

                // show_exchange_balance('#exchange_balance');
            }
        });
    });

    prepare_form();


});

