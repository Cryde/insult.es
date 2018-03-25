import {voteInsult} from '../api/insult';

function typeVoteInsultClick(type) {
  return function onVoteInsultClick(e) {
    e.preventDefault();
    const id = this.getAttribute('data-insult-id');
    voteInsult(id, type).then(() => {
      document.querySelector('li.random').click();
    });
  };
}

export default function handleVote() {
  document
  .querySelector('.vote-down')
  .addEventListener('click', typeVoteInsultClick('down'), false);

  document
  .querySelector('.vote-up')
  .addEventListener('click', typeVoteInsultClick('up'), false);
}
