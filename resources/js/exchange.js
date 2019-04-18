
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

    $(document).on("change", '#exchanged_currency', function(e){
        console.log('changed option');
        $.ajax({
            url: 'https://www.cbr-xml-daily.ru/daily_json.js',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
            },
        });

    });

});

