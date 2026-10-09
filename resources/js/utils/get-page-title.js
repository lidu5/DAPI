const title = 'Digital Health Project Inventory';

export default function getPageTitle(key) {
  if (key) {
    return `${key} - ${title}`;
  }
  return `${title}`;
}
