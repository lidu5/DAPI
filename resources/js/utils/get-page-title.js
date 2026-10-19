const title = 'Digital Agriculture Project Inventory';

export default function getPageTitle(key) {
  if (key) {
    return `${key} - ${title}`;
  }
  return `${title}`;
}
