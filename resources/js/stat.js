import $ from 'jquery';
import { updateRate, roundToTwoDecimal } from './utilities';

const getDifferenceBetweenRates = (newRate, oldRate) =>
  roundToTwoDecimal(newRate - oldRate);

const getReceivedAmount = (amount, rate) =>
  roundToTwoDecimal(amount * rate);

const showExchanges = (exchanges, currentRates) => {
  const blockWithAllExchanges = $('#exchanges-block');

  exchanges.forEach((exchange, index) => {
    const currentRate = (currentRates[exchange.exchanged_currency] || currentRates[exchange.received_currency]).Value;
    const blockOfExchange = `
      <tr>
        <th scope="row">${ index + 1 }</th>
        <td>${ exchange.amount } ${ exchange.exchanged_currency }</td>
        <td>${ getReceivedAmount(exchange.amount, exchange.rate) } ${ exchange.received_currency }</td>
        <td>${ exchange.rate }</td>
        <td>${ getDifferenceBetweenRates(currentRate, exchange.rate) }%</td>
      </tr>
    `;
    blockWithAllExchanges.append(blockOfExchange);
  });
}

const showTodayExchanges = (url, currentRates, token) => {
  $.ajax({
    url,
    type: 'GET',
    data: { token },
    dataType: 'json',
  }).done(({ data }) => {
    showExchanges(data, currentRates);
  });
};

$(document).ready(() => {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }
  });
  const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  const exchangeUrl = `/api/user/stats`;
  const rateUrl = 'https://cors-anywhere.herokuapp.com/https://www.cbr-xml-daily.ru/daily_json.js'

  updateRate(rateUrl).then((data) => {
    const currentRates = JSON.parse(data).Valute;
    showTodayExchanges(exchangeUrl, currentRates, CSRF_TOKEN);
  });
});
