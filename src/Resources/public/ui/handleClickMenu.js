import { getInsult, getRandom } from '../api/insult';

/**
 * @param response
 */
function displayInsult(response) {
  const insultContainer = document.querySelector('.insult');

  insultContainer.querySelector('span').innerText = response.insult.value;
  window.location.hash = response.insult.id;
}

function displayError() {
  alert('Cette insulte n\'existe pas :/');
  location.href = '/';
}

/**
 * @param e
 */
function randomMenuItemClick(e) {
  e.preventDefault();

  getRandom().then(displayInsult);
}

/**
 * @param e
 */
function addInsultMenuItemClick(e) {
  e.preventDefault();
  this.classList.toggle('active');
  document
    .querySelector('.form-send')
    .classList
    .toggle('show');
}

function getInsultId() {
  return +window.location.hash.replace('#', '');
}

export default function handleClickMenu() {
  document
    .querySelector('nav li a.add')
    .addEventListener('click', addInsultMenuItemClick, false);

  const getRandomInsultSelector = document.querySelector('.menu a:first-child');
  const insultId = getInsultId();

  getRandomInsultSelector.addEventListener('click', randomMenuItemClick, false);

  if (insultId) {
    getInsult(insultId).then(displayInsult).catch(displayError);
  } else {
    getRandomInsultSelector.click();
  }
}
