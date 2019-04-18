
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

    // let rate_list = {
    //     "USD": {
    //         "rate": 65,
    //     },
    //     "EUR": {
    //         "rate": 100,
    //     },
    //     "GBP":{
    //         "rate"
    //     },
    // };

    $(document).on("change", '#exchanged_currency', function(e){
        console.log('changed option');
        // Исправить запрос на запрос без проксирования, решить проблему с корс
        $.ajax({
            type:'GET',
            url: 'https://cors-anywhere.herokuapp.com/https://www.cbr-xml-daily.ru/daily_json.js',
            success: function(data){
                let rates_json = data['Valute'];
                console.log(typeof rates_json);
            }
          });
    });

});

