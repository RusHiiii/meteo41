export function showFixedValue(value, precision = 1) {
  if (value) {
    return value.toFixed(precision);
  }

  return '-';
}
