import $ from 'jquery';
import { updateRate, roundToTwoDecimal } from './utilities';

const setupForm = (url, token) =>
  $.ajax({
    url,
    type: 'GET',
    data: { token },
    dataType: 'json',
  });

let amount_warning_sign = false;

const getRate = () => {
  const urlCurrencies = 'https://cors-anywhere.herokuapp.com/https://www.cbr-xml-daily.ru/daily_json.js';

  return updateRate(urlCurrencies).then((data) => {
    const currentRates = JSON.parse(data).Valute;
    const receivedCurrencyName = $('#received_currency').children(":selected").data("name");
    const currentRate = currentRates[receivedCurrencyName].Value;
    return Math.round(currentRate * 100) / 100;
  });
};

const showReceivedCurrencies = (balances) => {
  const exchangeBalanceName = getExchangeBalance(balances).name;

  balances
    .filter(el => el.name !== exchangeBalanceName)
    .forEach(el => $(`#received_currency`).append(`
      <option id=${ el.balance_id } data-name=${ el.name }>
          ${ el.name } ${ el.amount }
      </option>
    `))
};

const getExchangeBalance = (balances) =>
  balances.find(el => el.name === 'RUB');

const showExchangeBalance = (balances) => {
  const exchangeBalance = getExchangeBalance(balances);
  $('#exchange_balance').val(exchangeBalance.amount);
  $('#exchange_currency').val(exchangeBalance.name);
};

$(document).ready(() => {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }
  });

  const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  const url = `/api/user`;

  setupForm(url, CSRF_TOKEN).then(({ data }) => {
    showExchangeBalance(data.balances);
    showReceivedCurrencies(data.balances);

    getRate().then((rate) => {
      const exchangeBalance = getExchangeBalance(data.balances);

      $('#rate').val(rate);

      $(document).on('keyup', '#amount_to_exchange', function (e) {
        const exchangeBalanceAmount = exchangeBalance.amount;
        const exchangingAmount = roundToTwoDecimal($(this).val());

        const maxPossibleAmount = roundToTwoDecimal(exchangeBalanceAmount / rate);
        let receivingAmount = roundToTwoDecimal(exchangingAmount * rate);

        $(this).val(exchangingAmount);
        if (exchangeBalanceAmount < exchangingAmount * rate) {
            console.log('more');
            console.log(amount_warning_sign);
          if (!amount_warning_sign) {
            $('#amount_label').append(`<span id="amount_warning_sign" style="color:red">Maximum amount to exchange: ${maxPossibleAmount} </span>`);
            $('#amount_to_exchange').addClass('border-danger');
            amount_warning_sign = true;
          }
          $('#amount_to_exchange').val(maxPossibleAmount);
          receivingAmount = exchangeBalanceAmount;
        } else {
          $('#amount_to_exchange').removeClass('border-danger');
          $('#amount_warning_sign').remove();
          amount_warning_sign = false;
        }
        $(`#amount`).val(receivingAmount);
      });

      $('#exchange_button').on('click', (e) => {
        e.preventDefault();

        if (!confirm('Make a transaction?')) {
          return false;
        }

        const url = 'api/exchange';
        const exchangeCurrencyId = exchangeBalance.balance_id;
        const receivedCurrencyId = $('#received_currency').children(":selected").attr("id");
        const amount = $('#amount_to_exchange').val();

        $.ajax({
          url,
          type: 'POST',
          data: {
            exchanged_cur: exchangeCurrencyId,
            received_cur: receivedCurrencyId,
            amount,
            rate,
            _token: CSRF_TOKEN },
          dataType: 'json',
          beforeSend: () => $('#exchange_button').hide(),
          complete: () => $('#exchange_button').show(),
        }).done(({ data }) => showExchangeBalance(data.balances));
      });
    });
    });
});
