import $ from 'jquery';

const updateRate = async (url) => {
  return await $.ajax({
    type: 'GET',
    url,
  });
};

const getDifferenceBetweenRates = (newRate, oldRate) =>
  Math.round((newRate - oldRate) * 100) / 100;

const showExchanges = (exchanges, currentRates) => {
  const blockWithAllExchanges = $('#exchanges-block');

  exchanges.forEach((exchange) => {
    const currentRate = (currentRates[exchange.exchanged_currency] || currentRates[exchange.received_currency]).Value;

    const blockOfExchange = `
      <div class="card">
        <div class="card-body">
          <p>Exchanged currency: ${ exchange.exchanged_currency }</p>
          <p>Amount: ${ exchange.amount }</p>
          <p>Received currency: ${ exchange.received_currency }</p>
          <p>Rate: ${ exchange.rate }</p>
          <p>Date: ${ exchange.date }</p>
          <p>Difference: ${ getDifferenceBetweenRates(currentRate, exchange.rate) }%</p>
        </div>
      </div>
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
