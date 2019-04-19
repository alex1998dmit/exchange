import $ from 'jquery';
import { updateRate, roundToTwoDecimal } from './utilities';

const setupForm = (url, token) =>
  $.ajax({
    url,
    type: 'GET',
    data: { token },
    dataType: 'json',
  });

const validation = (exchangeBalance, rate) => {
  const exchangeBalanceAmount = exchangeBalance.amount;
  const exchangingAmount = roundToTwoDecimal($('#amount_to_exchange').val());
  const receivingAmount = roundToTwoDecimal(exchangingAmount * rate);

  return exchangeBalanceAmount >= receivingAmount;
}

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

      $('#amount_to_exchange').on('change paste keyup', (e) => {
        const exchangingAmount = roundToTwoDecimal($('#amount_to_exchange').val());
        const receivingAmount = roundToTwoDecimal(exchangingAmount * rate);

        if (!validation(exchangeBalance, rate)) {
          $('#amount_to_exchange').addClass('border-danger');
        } else {
          $(`#amount`).val(receivingAmount);
          $('#amount_to_exchange').removeClass('border-danger');
        }
      });

      $('#exchange_button').on('click', (e) => {
        e.preventDefault();

        const url = 'api/exchange';
        const exchangeCurrencyId = exchangeBalance.balance_id;
        const receivedCurrencyId = $('#received_currency').children(":selected").attr("id");
        const amount = $('#amount_to_exchange').val();
        const maxPossibleAmount = roundToTwoDecimal(exchangeBalance.amount / rate);

        if (!validation(exchangeBalance, rate)) {
          alert(`Maximum amount to exchange: ${ maxPossibleAmount }`);
          return false;
        }

        if (!confirm('Make a transaction?')) {
          return false;
        }

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
