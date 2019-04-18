import $ from 'jquery';

$(document).ready(() => {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }
  });

  const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  const url = `/api/user/stats`;

  $.ajax({
    url,
    type: 'GET',
    data: { 'token': CSRF_TOKEN },
    dataType: 'json',
  }).done(({ data }) => {
    const exchangesBlock = $('#exchanges-block');
    data.forEach((elem) => {
      const exchangeBlock = `
        <div class="card">
          <div class="card-body">
            <p>Exchanged currency: ${ elem.exchanged_currency }</p>
            <p>Amount: ${ elem.amount }</p>
            <p>Received currency: ${ elem.received_currency }</p>
            <p>Rate: ${ elem.rate }</p>
            <p>Date: ${ elem.date }</p>
          </div>
        </div>
      `;
      exchangesBlock.append(exchangeBlock);
    })
  });
});
