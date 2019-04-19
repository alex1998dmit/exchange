export const updateRate = async (url) => {
  return await $.ajax({
    type: 'GET',
    url,
  });
};

export const roundToTwoDecimal = (number) =>
  Math.floor(number * 100) / 100;
