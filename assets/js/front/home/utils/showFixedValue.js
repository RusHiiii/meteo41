export function showFixedValue(value) {
  if (value) {
    return value.toFixed(1);
  }

  return '-';
}
