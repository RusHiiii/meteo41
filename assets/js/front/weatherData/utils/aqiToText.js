export function aqiToText(value) {
  if (value <= 50) {
    return 'Bon';
  }

  if (value <= 100) {
    return 'Modéré';
  }

  if (value <= 150) {
    return 'Mauvais pour les groupes';
  }

  if (value <= 200) {
    return 'Mauvais';
  }

  if (value <= 300) {
    return 'Trés mauvais';
  }

  return 'Dangereux';
}
