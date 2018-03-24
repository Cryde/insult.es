import {voteInsult} from '../api/insult';

function onVoteInsultClick(type) {
  return function (e) {
    e.preventDefault();
    const id = this.getAttribute('data-insult-id');
    voteInsult(id, type);
  }
}

export default function handleVote() {
  document
  .querySelector('.vote-down')
  .addEventListener('click', onVoteInsultClick('down'), false);

  document
  .querySelector('.vote-up')
  .addEventListener('click', onVoteInsultClick('up'), false);
}
