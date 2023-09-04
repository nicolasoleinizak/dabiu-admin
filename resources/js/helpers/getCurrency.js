export const getCurrency = (value) => {
  const numberValue = parseFloat(value);
  
  if (isNaN(numberValue)) {
    return value; // Return the original string if it's not a valid number
  }

  return numberValue.toFixed(2);

}