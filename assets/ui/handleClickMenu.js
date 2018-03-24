import { getInsult, getRandom } from '../api/insult';

/**
 * @param response
 */
function displayInsult(response) {
  const insultId = response.insult.id;
  const insult = response.insult.value;
  const insultContainer = document.querySelector('.insult');

  insultContainer.querySelector('span').innerText = insult;
  window.location.hash = insultId;

  document.querySelector('.vote-down').setAttribute('data-insult-id', insultId);
  document.querySelector('.vote-up').setAttribute('data-insult-id', insultId);
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
  if (e.target.nodeName !== 'INPUT' && e.target.nodeName !== 'TEXTAREA') {
    this.classList.toggle('active');
    document
    .querySelector('.form-send')
    .classList
    .toggle('show');
  }
}

function getInsultId() {
  return +window.location.hash.replace('#', '');
}

export default function handleClickMenu() {
  document
    .querySelector('li.add')
    .addEventListener('click', addInsultMenuItemClick, false);

  const getRandomInsultSelector = document.querySelector('li.random');
  const insultId = getInsultId();

  getRandomInsultSelector.addEventListener('click', randomMenuItemClick, false);

  if (insultId) {
    getInsult(insultId).then(displayInsult).catch(displayError);
  } else {
    getRandomInsultSelector.click();
  }
}
