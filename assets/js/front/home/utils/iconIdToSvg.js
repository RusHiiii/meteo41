export function iconIdToSvg(value) {
  switch (value) {
    case '01d':
    case '01n':
      return 'icon-2.svg';
    case '02d':
    case '02n':
      return 'icon-3.svg';
    case '03d':
    case '03n':
      return 'icon-5.svg';
    case '04d':
    case '04n':
      return 'icon-6.svg';
    case '09d':
    case '09n':
      return 'icon-10.svg';
    case '10d':
    case '10n':
      return 'icon-4.svg';
    case '11d':
    case '11n':
      return 'icon-11.svg';
    case '13d':
    case '13n':
      return 'icon-14.svg';
    case '50d':
    case '50n':
      return 'icon-7.svg';
  }

  return 'icon-1.svg';
}
