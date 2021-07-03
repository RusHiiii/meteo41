export function showSpeedValue(value) {
  if (value) {
    return (value * 3.6).toFixed(1);
  }

  return '-';
}
