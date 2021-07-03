export function showRoundValue(value) {
  if (value) {
    return Math.round(value);
  }

  return '-';
}
