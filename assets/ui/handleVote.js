import {voteInsult} from '../api/insult';
import {handleVoteDisplay} from './handleClickMenu';

function typeVoteInsultClick(type) {
  return function onVoteInsultClick(e) {
    e.preventDefault();
    const id = this.getAttribute('data-insult-id');
    voteInsult(id, type);
    handleVoteDisplay(type === 'up' ? 1 : -1);
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
