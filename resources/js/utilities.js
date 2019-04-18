export const updateRate = async (url) => {
  return await $.ajax({
    type: 'GET',
    url,
  });
};
