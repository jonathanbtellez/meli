/**
 * Give a format of money to a number
 * @param {number} value
 * @returns New number with a special format
 */
export const moneyFormat = (value) => {
  return value.toLocaleString("en-US", {
    style: "currency",
    currency: "USD",
  });
};
