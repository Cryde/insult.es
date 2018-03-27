import {getInsult, getRandom} from '../api/insult';
import {formatInsultResponse} from '../utils/formatter';

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

/**
 * @param insult
 */
function displayInsult(insult) {
  const insultId = insult.id;
  const value = insult.value;
  const currentVote = insult.currentVote;
  const insultContainer = document.querySelector('.insult');
  const voteDownSelector = document.querySelector('.vote-down');
  const voteUpSelector = document.querySelector('.vote-up');

  insultContainer.querySelector('span').innerText = value;
  window.location.hash = insultId;

  handleVoteDisplay(currentVote);

  voteDownSelector.setAttribute('data-insult-id', insultId);
  voteUpSelector.setAttribute('data-insult-id', insultId);

  displayTotalVote(insult);
}

function displayTotalVote(insult) {
  const totalVoteDownSelector = document.querySelector('.total-vote-down .bar');
  const totalVoteUpSelector = document.querySelector('.total-vote-up .bar');

  totalVoteDownSelector.style.width = calculatePercent(insult.totalVote, insult.totalVoteDown) + '%';
  totalVoteUpSelector.style.width = calculatePercent(insult.totalVote, insult.totalVoteUp) + '%';
}

function calculatePercent(total, value) {
  return (value / total) * 100;
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

  getRandom().then(formatInsultResponse).then(displayInsult);
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
    getInsult(insultId).then(formatInsultResponse).then(displayInsult).catch(displayError);
  } else {
    getRandomInsultSelector.click();
  }
}