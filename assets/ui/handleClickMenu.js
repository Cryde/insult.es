import {getInsult, getRandom} from '../api/insult';

/**
 * @param response
 */
function displayInsult(response) {
  const insultId = response.insult.id;
  const insult = response.insult.value;
  const currentVote = response.insult.current_vote;
  const insultContainer = document.querySelector('.insult');
  const voteDownSelector = document.querySelector('.vote-down');
  const voteUpSelector = document.querySelector('.vote-up');

  insultContainer.querySelector('span').innerText = insult;
  window.location.hash = insultId;

  handleVoteDisplay(currentVote);

  voteDownSelector.setAttribute('data-insult-id', insultId);
  voteUpSelector.setAttribute('data-insult-id', insultId);
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
    document.querySelector('.form-send').classList.toggle('show');
  }
}

function getInsultId() {
  return +window.location.hash.replace('#', '');
}

export {handleVoteDisplay};
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

function handleVoteDisplay(currentVote) {
  const voteDownSelector = document.querySelector('.vote-down');
  const voteUpSelector = document.querySelector('.vote-up');

  voteDownSelector.classList.remove('active');
  voteUpSelector.classList.remove('active');

  if (currentVote) {
    if (currentVote === 1) {
      voteUpSelector.classList.add('active');
    } else {
      voteDownSelector.classList.add('active');
    }
  }
}