/* global Routing */

function getRandom() {
  return fetch(Routing.generate('api_get_random_insult')).then(response => response.json());
}

function getInsult(id) {
  return fetch(Routing.generate('api_get_insult', { id })).then(response => response.json());
}

function voteInsult(id, voteType) {
  return fetch(Routing.generate('api_vote_insult', { id , voteType})).then(response => response.json());
}

export { getRandom, getInsult, voteInsult };
